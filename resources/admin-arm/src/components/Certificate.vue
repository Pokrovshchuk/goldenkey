<template>
  <div
    class="certificate"
    :class="{
      'certificate--empty': !status,
    }"
  >
    <p v-if="!status" class="certificate__empty">
      Сертификат еще не просканирован
    </p>

    <div
      v-if="error"
      class="certificate__wrapper certificate__wrapper--error"
    >
      <h2 class="certificate__title certificate__title--mba">
        <SvgIcon
          className="certificate__icon"
          name="red-face"
          width="30"
          height="30"
        />{{ title }}
      </h2>
      <div class="certificate__controls">
        <p
          class="certificate__message certificate__message--absolute"
          :class="{ ' certificate__message--error': description < 1 }"
        >
          {{ 'Вход в бизнес зал запрещен.' }}
        </p>
        <button
          class="certificate__close-button button button--attention"
          @click="clearCertificate"
          :key="timeToClear"
        >
          Закрыть ({{ timeToClear }})
        </button>
      </div>
    </div>
    <!-- Certificate does not exist -->

    <div
      v-if="isNotExist"
      class="certificate__wrapper certificate__wrapper--error"
    >
      <h2 class="certificate__title certificate__title--mba">
        <SvgIcon
          className="certificate__icon"
          name="red-face"
          width="30"
          height="30"
        />{{ title }}
      </h2>
      <div class="certificate__controls">
        <p
          class="certificate__message certificate__message--absolute"
          :class="{ ' certificate__message--error': description < 1 }"
        >
          {{ 'Вход в бизнес зал запрещен.' }}
        </p>
        <button
          class="certificate__close-button button button--attention"
          @click="clearCertificate"
          :key="timeToClear"
        >
          Закрыть ({{ timeToClear }})
        </button>
      </div>
    </div>

    <!-- Certificate is not valid -->
    <div
      v-if="hasBeenActivated"
      class="certificate__wrapper certificate__wrapper--error"
    >
      <h2 class="certificate__title certificate__title--mba">
        <SvgIcon
          className="certificate__icon"
          name="red-face"
          width="30"
          height="30"
        />{{ title }}
      </h2>

      <div class="certificate__controls">
        <p
          class="certificate__message"
          :class="{ ' certificate__message--error': isMessageError }"
        >
          {{ 'Вход в бизнес зал запрещен.' }}
        </p>
        <button
          class="certificate__close-button button button--attention"
          @click="clearCertificate"
          :key="timeToClear"
        >
          Закрыть ({{ timeToClear }})
        </button>
      </div>
    </div>
    <!-- Certificate is valid -->
    <div
      v-if="status === 'success'"
      class="certificate__wrapper certificate__wrapper--success"
    >
      <h2 class="certificate__title">
        <SvgIcon
          className="certificate__icon"
          name="green-face"
          width="30"
          height="30"
        />{{ title }}
      </h2>
      <dl class="certificate__paragraph certificate__paragraph--before-text">
        <dt class="certificate__term">{{ term }}</dt>
        <dd class="certificate__description certificate__description--plain">
          {{ certificate.pass_limit }}
        </dd>
      </dl>
      <p class="certificate__text">
        Посещение Бизнес-зала разрешено. Для посещения Бизнес-зала билет не
        требуется.
      </p>
      <div class="certificate__controls">
        <TimerToggler :timer="timer" :toggle-timer="toggleTimer" />
        <button
          class="certificate__close-button button button--accept"
          @click="clearCertificate"
          :key="timeToClear"
        >
          Закрыть ({{ timeToClear }})
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import TimerToggler from './TimerToggler.vue'
export default {
  components: { TimerToggler },
  data() {
    return {
      term: 'Количество гостей:',
      description: 0,
      message:
        'Посещение Бизнес-зала разрешено. Для посещения Бизнес-зала билет не требуется.',
      timeToClear: 5,
      intervalIndex: null,
      timer: true,
    }
  },
  mounted() {
    this.$eventBus.$on('certificate-scanned', () => {
      this.intervalIndex = setInterval(this.decrementTimeToCLear, 1000)
    })
  },
  beforeDestroy() {
    if (this.intervalIndex) {
      clearInterval(this.intervalIndex)
      this.timeToClear = 5
    }
  },
  computed: {
    error() {
      return this.status.toLowerCase() === 'error' && !this.code
    },
    hasBeenActivated() {
      return this.status.toLowerCase() === 'error' && Number(this.code) === 1003
    },
    isNotExist() {
      return this.status.toLowerCase() === 'error' && Number(this.code) === 1001
    },
    certificate() {
      return this.$store.getters['getCertificate']
    },
    isMessageError() {
      return !this.isDescriptionError && this.description < 1
    },
    isDescriptionError() {
      return typeof this.description !== 'number'
    },
    code() {
      return this.$store.getters['getCertificateCode']
    },
    status() {
      return this.$store.getters['getCertificateStatus']
    },
    title() {
      return this.$store.getters['getCertificateMessage']
    },
  },
  methods: {
    decrementTimeToCLear() {
      if (this.timeToClear > 0) {
        this.timeToClear = this.timeToClear - 1
      } else {
        this.clearCertificate()
      }
    },
    toggleTimer() {
      this.timer = false
      this.$store
        .dispatch('removeCertificate', { id: this.certificate.id })
        .catch(() => {
          this.timer = true
        })
    },
    getDescription(d) {
      return d < 100 ? d : '99+'
    },
    clearCertificate() {
      this.$store.commit('clearStore')
      this.$eventBus.$emit('clear-qr')
      clearInterval(this.intervalIndex)
      this.timeToClear = 5
    },
  },
}
</script>

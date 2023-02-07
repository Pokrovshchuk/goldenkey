<template>
  <form
    class="qr-scanner"
    action="#"
    method="post"
    @submit.prevent="submit"
    autocomplete="off"
  >
    <div class="qr-scanner__input-wrapper">
      <input
        ref="input"
        class="qr-scanner__input"
        :class="{
          'qr-scanner__input--applied': isCodeApplied,
          'qr-scanner__input--declined': isCodeDeclined,
        }"
        type="text"
        name="qr-code"
        id="qr-code"
        placeholder="Введите код сертификата"
        required
        v-model="qr"
      />
      <label class="qr-scanner__placeholder" for="qr-code"
        >Введите код сертификата</label
      >
    </div>
    <p class="qr-scanner__message">
      <SvgIcon
        name="info"
        class-name="qr-scanner__message-icon"
        width="17"
        height="17"
      />
      Для посещения Бизнес-зала билет не требуется
    </p>
    <button class="qr-scanner__submit button" type="submit">Активировать</button>
  </form>
</template>
<script>
export default {
  data() {
    return {
      qr: '',
    }
  },
  beforeMount() {
    this.$eventBus.$on('clear-qr', this.clearQr)
  },
  mounted() {
    this.$refs.input.focus()
  },
  beforeDestroy() {
    this.$eventBus.$off('clear-qr', this.clearQr)
  },
  methods: {
    submit() {
      this.$store.dispatch('sendCode', { code: this.qr })
    },
    clearQr() {
      this.qr = ''
    },
  },
  computed: {
    isCodeDeclined() {
      return this.$store.getters['getCertificateStatus'] === 'error'
    },
    isCodeApplied() {
      return this.$store.getters['getCertificateStatus'] === 'success'
    },
  },
}
</script>

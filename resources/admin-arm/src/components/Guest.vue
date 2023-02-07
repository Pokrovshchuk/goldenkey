<template>
  <details
    class="guest"
    :class="{ 'guest--soon': isSoonOver || data.status === 'expired' }"
    @toggle="changeGuest"
  >
    <summary>
      <span class="guest__queue-number">{{ data.queue_id || '' }}</span
      ><span class="guest__table">{{
        data.table_number ? data.table_number : localTable
      }}</span>
      <span class="guest__cert">{{
        data.id ? data.id : ''
      }}</span>
      <span class="guest__guests">{{ data.pass_limit }}</span>
      <Timer
        :time-to="data.start_time"
        :time-left-string="timeLeftString"
        :class="{
          'guest__timer--over-soon': isSoonOver || data.status === 'expired',
        }"
      />
    </summary>
    <div class="guest__wrapper">
      <p
        v-if="data.table"
        class="guest__queue-number guest__queue-number--inside"
      >
        №гостя: <span class="guest__order">{{ data.table }}</span>
      </p>
      <p v-if="data.bank" class="guest__bank">Оплачено с помощью Тинькофф</p>
    </div>
    <div class="guest__wrapper">
      <input
        class="guest__input guest__input--table"
        type="text"
        name="table"
        placeholder="№ столика"
        v-model="localTable"
      />
      <textarea
        class="guest__input"
        name="description"
        cols="30"
        rows="2"
        placeholder="Здесь вы можете указать комментарии для идентификации гостя"
        v-model="description"
      ></textarea>
    </div>
    <div class="guest__wrapper">
      <button class="button guest__cancel-button" @click="removeCertificate">
        Завершить пребывание
      </button>
      <TimerToggler
        :toggleTimer="toggleTimer"
        :timer="timer"
        :is-guest="true"
      />
    </div>
  </details>
</template>
<script>
import TimerToggler from './TimerToggler.vue'
export default {
  components: { TimerToggler },
  props: {
    data: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
  data() {
    return {
      description: '',
      timeLeftString: '',
      intervalId: null,
      isSoonOver: false,
      timer: true,
      willSendNote: true,
      localTable: '',
    }
  },
  mounted() {
    if (this.data.description) {
      this.description = this.data.description
    }
    if (this.data.table) {
      this.localTable = this.data.table
    }

    if (this.isActive) {
      this.intervalId = setInterval(this.timeLeft, 1000)
      this.timeLeft()
    }
  },
  beforeDestroy() {
    if (this.intervalId) {
      clearInterval(this.intervalId, 1000)
    }
  },
  computed: {
    isActive() {
      return this.data.status === 'active'
    },
  },
  methods: {
    timeLeft() {
      const timeLeftString = this.timeDiff()
      const fiveMinutes = 1000 * 60 * 5

      this.isSoonOver = timeLeftString < fiveMinutes
      this.timeLeftString =
        timeLeftString > 0 ? timeLeftString.format('HH:mm:ss') : '00:00:00'

      if (timeLeftString < 0 && this.isActive) {
        this.sendExpired()
        clearInterval(this.intervalId, 1000)
      }

      if (this.isSoonOver && this.willSendNote) {
        this.willSendNote = false
        this.$store.dispatch('addNote', {note: this.data})
      }
    },

    timeDiff() {
      const now = this.$moment()
      const timeTo = this.$moment
        .tz(this.data.start_time, now.format('z'))
      return this.$moment(timeTo.diff(now))
    },
    sendExpired() {
      this.$store.dispatch('sendExpiredCertificate', { id: this.data.id })
    },
    removeCertificate() {
      return this.$store
        .dispatch('removeCertificate', { id: this.data.id })
        .then(() => {
          clearInterval(this.intervalId, 1000)
        })
    },
    toggleTimer() {
      this.timer = false
      this.removeCertificate().then(
        () => {},
        () => {
          this.timer = true
        },
      )
    },
    changeGuest(e) {
      if (!e.target.open) {
        this.$axios
          .post('/certificates-edit', {
            description: this.description,
            table_number: this.localTable,
            id: this.data.id,
          })
          .catch((e) => {
            console.warn(e)
            this.description = ''
            this.localTable = ''
          })
      }
    },
  },
}
</script>

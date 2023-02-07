<template>
  <div
    class="note"
    ref="note"
    :class="{
      'note--removed-left': isRemoved === 'left',
      'note--removed-right': isRemoved === 'right',
    }"
  >

    <div v-if="!isBank && note._type === 'scanned'" class="note__wrapper">
      <h4 class="note__title" :class="{
        'note__title--error': note.status === 'error'
      }">
        <SvgIcon
          name="qr"
          class-name="note__message-icon"
          width="26"
          height="26"
        />{{note.message}}
        
      </h4>
    </div>

    <div v-if="!isBank && note._type !== 'scanned'" class="note__wrapper">
      <h4 class="note__title">
        <SvgIcon
          name="info"
          class-name="note__message-icon"
          width="16"
          height="16"
        />Заканчивается время пребывания в Бизнес-зале
        <span class="note__time-left">Осталось: 5 мин</span>
      </h4>
      <p class="note__text">
        Гость №{{ note.queue_id ? note.queue_id : '' }} {{ note.user_name ? note.user_name : '' }}
        <span class="note__info"
          >{{note.description ? note.description : ''}}</span
        >
      </p>
    </div>
    


    <div v-if="isBank" class="note__wrapper note__wrapper--bank">
      <div class="note__img-wrapper">
        <img src="/img/bank-logo.png" alt="" width="32" height="32" />
      </div>
      <h4 class="note__title">
        <span>Тинькофф банк </span
        ><span v-if="note.status === 'failed'" class="note__message note__message--error">Ошибка оплаты</span>
        <span v-if="note._type === 'OrderCreatedEvent'" class="note__message">QR-код cформирован</span>
        <span v-if="note.status === 'completed'" class="note__message note__message--success">Оплата успешна</span>
        <span v-if="note.status === 'processing'" class="note__message">Оплата обрабатывается</span>
        <span v-if="note.info" class="note__info"
          >{{note.info}}</span
        >
      </h4>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    note: {
      type: Object,
      default: () => ({ type: 'end' }),
    },
  },
  data() {
    return {
      xBase: 0,
      currentStart: 0,
      currentDiff: 0,
      xDiff: 0,
      isRemoved: false,
    }
  },
  mounted() {
    this.xBase = this.$refs.note.getBoundingClientRect().x
    this.$refs.note.addEventListener('touchstart', this.handleStartTouch)
    this.$refs.note.addEventListener('touchend', this.handleStopTouch)
    setTimeout(()=>{
      this.removeNewNote(false, false)
    }, 10000)
  },
  computed: {
    isBank() {
      return this.note._type === 'OrderUpdatedEvent' || this.note._type === 'OrderCreatedEvent'
    },
  },
  methods: {
    removeNewNote(flag, remove = true) {
      if (!flag) {
        this.isRemoved = 'left'
      } else {
        this.isRemoved = 'right'
      }

      if (remove) {
        setTimeout(() => {
          this.$store.commit('removeNewNote', { note: this.note })
        }, 100)
      }
    },
    handleStopTouch() {
      this.$refs.note.removeEventListener('touchmove', this.handleTouch)
      if (!this.isRemoved) {
        this.$refs.note.style.transform = `translateX(0)`
      }
    },
    handleTouch(e) {
      const note = e.target.closest('.note')
      const halfWidth = note.offsetWidth / 2
      this.currentStart = e.touches[0].clientX - this.curretnDiff
      const toLeft = this.currentStart - this.xBase > halfWidth
      const toRight = -(this.currentStart - this.xBase) > halfWidth

      if (toLeft || toRight) {
        this.removeNewNote(toLeft)
        note.style.transform = `translateX(${
          this.currentStart - this.xBase > 0 ? halfWidth : -halfWidth
        }px)`
        return
      }

      note.style.transform = `translateX(${this.currentStart - this.xBase}px)`
    },
    handleStartTouch(e) {
      this.$refs.note.addEventListener('touchmove', this.handleTouch)
      this.currentStart = e.touches[0].clientX
      this.curretnDiff = this.currentStart - this.xBase
    },
  },
}
</script>

<template>
  <div class="guests">
    <div v-if="!isEpty" class="guests__header">
      <span class="guests__header-cell guests__header-cell--number"
        >№ п.п.</span
      >
      <span class="guests__header-cell guests__header-cell--table"
        >№ столика</span
      >
      <span class="guests__header-cell guests__header-cell--table"
        >№ серт.</span
      >
      <span class="guests__header-cell guests__header-cell--guests-count"
        >Кол-во гостей</span
      >
      <span class="guests__header-cell guests__header-cell--timer">Таймер</span>
    </div>
    <div class="guests__list-wrapper">
      <ul class="guests__list" :class="{ 'guests__list--empty': isEpty }">
        <li v-if="isEpty" class="guests__item guest__item--empty">
          В вашем зале пока нет гостей
        </li>
        <li v-else v-for="guest in guests" :key="guest.id" class="guests__item">
          <Guest :data="guest" />
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  // data() {
  //   return {
  //     guests: [{ id: '1234' }, { id: '1235' }, { id: '1236' }, { id: '123' }],
  //   }
  // },
  computed: {
    isEpty() {
      return this.guests.length < 1
    },
    guests() {
      return this.$store.getters['getHallCertificates']
    },
  },
}
</script>

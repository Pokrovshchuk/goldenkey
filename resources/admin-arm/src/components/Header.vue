<template>
  <header class="page-header">
    <div class="page-header__wrapper">
      <p class="page-header__admin">
        Администратор Бизнес Зала
        <span class="page-header__place">«{{ title }}»</span>
      </p>

      <OfflineIdicator />
      <Notifications />
      <button
        class="page-header__button button-alternate"
        @click="goToCertificates"
        :disabled="isCertificatesPage"
      >
        Реестр сертификатов
      </button>
      <button class="page-header__button button-alternate" @click="logout">
        Выйти
      </button>
    </div>
  </header>
</template>
<script>
import OfflineIdicator from '@/components/OfflineIndicator.vue'
import Notifications from '@/components/Notifications.vue'
export default {
  components: {
    OfflineIdicator,
    Notifications,
  },
  computed: {
    isCertificatesPage() {
      return this.$route.name === 'Certificates'
    },
    hallName() {
      return this.$store.getters['getHallName']
    },
    adminName() {
      return this.$store.getters['getHallAdminName']
    },
    title() {
      return this.hallName ? this.hallName : this.adminName
    }
  },
  methods: {
    logout() {
      this.$store.dispatch('logout').then(() => {
        this.$router.push({ name: 'Auth' })
        this.$store.commit('clearHallData')
      })
    },
    goToCertificates() {
      this.$router.push({ name: 'Certificates' })
    },
    changestatus() {
      this.$axios.post('/certificates-change-status', {
        id: 9,
        status: 'inactive',
      })
    },
  },
}
</script>

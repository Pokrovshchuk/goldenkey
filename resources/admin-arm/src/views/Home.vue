<template>
  <main class="page-main">
    <div class="page-main__wrapper">
      <section class="page-main__section">
        <h2 class="page-main__title">Активация сертификата</h2>
        <QrScanner />
        <Certificate />
      </section>
      <section class="page-main__section">
        <h2 class="page-main__title">Список гостей</h2>
        <GuestsList />
      </section>
    </div>
  </main>
</template>
<script>
import QrScanner from '@/components/QrScanner.vue'
import Certificate from '@/components/Certificate.vue'
import GuestsList from '@/components/GuestsList.vue'
export default {
  name: 'Home',
  components: {
    QrScanner,
    Certificate,
    GuestsList,
  },
}
</script>

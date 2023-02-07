<template>
  <main class="page-main">
    <router-link to="/" class="logo">
      <img src="/img/logo.png" alt="Golden Key logo" width="200" height="50" />
    </router-link>
    <AuthForm />
  </main>
</template>
<script>
import AuthForm from '@/components/AuthForm.vue'
export default {
  name: 'Auth',
  components: {
    AuthForm,
  },
}
</script>

<template>
  <div id="app" @click="clickOnLayoutHandler">
    <Header v-if="isAuth" />
    <router-view />
  </div>
</template>
<script>
import Header from '@/components/Header.vue'
export default {
  components: {
    Header,
  },
  computed: {
    isAuth() {
      return (
        this.$store.getters['authenticated'] && this.$store.getters['token']
      )
    },
  },
  methods: {
    clickOnLayoutHandler() {
      this.$eventBus.$emit('click-on-layout')
    },
  },
}
</script>

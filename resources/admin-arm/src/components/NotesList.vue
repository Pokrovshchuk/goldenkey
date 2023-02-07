<template>
  <div class="notes-list" @click.stop>
    <h3 class="notes-list__title">Уведомления</h3>
    <button class="notes-list__clear" @click="clearNotes">
      Очистить уведомления
    </button>
    <div class="notes-list__wrapper">
      <ul class="notes-list__list">
        <li v-for="(note, i) in notes" :key="i"><Note :note="note" /></li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    notes() {
      return this.$store.getters['getAllNotes']
    },
  },
  methods: {
    clearNotes() {
      this.$store.dispatch('clearAllNotes')
    },
  },
}
</script>

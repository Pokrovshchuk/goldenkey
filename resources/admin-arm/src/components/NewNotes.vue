<template>
  <ul class="notifications__new-list" @click.stop>
    <li v-for="(note, i) in newNotes" :key="note.id">
      <Note
        :note="note"
        class="note--new"
        :style="`animation-delay: ${100 * (i + 1)}ms`"
      />
    </li>
  </ul>
</template>
<script>
export default {
  mounted() {
    this.$eventBus.$on('click-on-layout', this.clearNewEvents)
  },
  computed: {
    newNotes() {
      return this.$store.getters['getNewNotes']
        ? this.$store.getters['getNewNotes']
        : []
    },
  },
  methods: {
    clearNewEvents() {
      this.$store.dispatch('clearNewNotes')
    },
  },
}
</script>

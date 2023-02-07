<template>
  <button
    class="notifications"
    :class="{
      'notifications--is-present': isNewNotes,
      'notifications--list-shown': isShownNotesList,
    }"
    type="button"
    @click.stop="toggleNotesList"
  >
    <SvgIcon name="bell" />
    <span class="notifications__count">{{ count }}</span>
    <NotesList v-if="isShownNotesList" />
    <NewNotes v-if="isNewNotes && !isShownNotesList" />
  </button>
</template>
<script>
import NotesList from './NotesList.vue'
import NewNotes from './NewNotes.vue'
export default {
  data() {
    return {
      isShownNotesList: false,
    }
  },
  components: {
    NotesList,
    NewNotes,
  },
  mounted() {
    this.$eventBus.$on('click-on-layout', this.hideNotesList)
    // setTimeout(() => {
    //   this.$store.dispatch('fetchNotes')
    // }, 3000)
  },
  computed: {
    count() {
      const count = this.$store.getters['getAllNotes'].length
      return count < 1 ? '' : count > 99 ? '99+' : count
    },
    isNewNotes() {
      return (
        this.$store.getters['getNewNotes'] &&
        this.$store.getters['getNewNotes'].length > 0
      )
    },
  },
  methods: {
    toggleNotesList() {
      this.$store.dispatch('clearNewNotes')
      this.isShownNotesList = !this.isShownNotesList
    },
    hideNotesList() {
      this.$store.dispatch('clearNewNotes')
      this.isShownNotesList = false
    },
  },
}
</script>

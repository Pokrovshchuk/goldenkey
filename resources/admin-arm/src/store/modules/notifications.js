// import axios from 'axios'
// import Vue from 'vue'

const initialState = {
  notes: [],
  newNotes: [],
}

export default {
  state: () => initialState,

  mutations: {
    setNotes(state, payload) {
      state.notes = payload.notes
    },
    setNewNotes(state, payload) {
      state.newNotes = payload.notes
    },
    setNote(state, payload) {
      state.notes = [...state.notes, payload.note]
    },
    setNewNote(state, payload) {
      state.newNotes = [...state.newNotes, payload.note]
    },
    removeNewNote(state, payload) {
      state.newNotes = state.newNotes.filter((it) => it.id !== payload.note.id)
    },
  },

  actions: {
    clearNewNotes({ commit }) {
      const notes = []
      commit('setNewNotes', { notes })
    },
    clearAllNotes({ commit }) {
      const notes = []
      commit('setNewNotes', { notes })
      commit('setNotes', { notes })
    },
    addNote({ commit }, {note}) {

      commit('setNewNote', { note })
      commit('setNote', { note })
    },
  },

  getters: {
    getAllNotes: (s) => s.notes,
    getNewNotes: (s) => s.newNotes,
  },
}

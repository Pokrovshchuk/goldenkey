export default ({ next, store }) => {
  if (!store.getters['getHallData']) {
    store.dispatch('fetchHallData')
  }

  return next()
}

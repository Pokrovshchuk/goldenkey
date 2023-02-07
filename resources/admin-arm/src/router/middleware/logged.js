export default ({ next, store, app }) => {
  if (store.getters.authenticated && store.getters.token) {
    app.prototype.$axios.defaults.headers.common['authorization'] =
      store.getters.token
    return next({
      name: 'Home',
    })
  } else {
    return next()
  }
}

export default ({ next, store }) => {
  if (!store.getters.authenticated) {
    return next({
      name: 'Auth',
    })
  }

  return next()
}

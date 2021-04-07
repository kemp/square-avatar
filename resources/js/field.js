Nova.booting((Vue, router, store) => {
  Vue.component('index-square-avatar', require('./components/IndexField'))
  Vue.component('detail-square-avatar', require('./components/DetailField'))
  Vue.component('form-square-avatar', require('./components/FormField'))
})

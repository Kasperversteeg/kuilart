require('./bootstrap');

Vue.component('card-modal', require('./components/CardModal.vue').default);

const app = new Vue({
  el: '#app',
  data: {
  	modalShowing: false,
  },
});

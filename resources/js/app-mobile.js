require('./bootstrap');

import Modal from './components/Modal';
import FormLine from './components/FormLine';

window.Vue = require('vue');

Vue.component('modal', Modal);
Vue.component('formline', FormLine);

new Vue({
	el: '#app',
	data: {
        isModalVisible: false,
        count: 0,
        fields: [] 
    },
    methods: {
    	addActivity(id){
    		this.fields.push({
    			name: id,
    			id:'act-'+this.count++
    		});
    	},
      showModal() {
        this.isModalVisible = true;
      },
      closeModal() {
        this.isModalVisible = false;
      }
    }
});



// vanillaJS 




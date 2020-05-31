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



// vanillaJS for test version of menu
window.onload = function() {
	var button = document.getElementById("nav-add");
	var dropdown = document.getElementById("nav-dropdown");
	var dropdownAria = document.getElementById("navbarDropdown");
	var nameOfClass = "show";

	
	// declare function for "onMouseOver" event:
	button.onmouseover = function() {
		// Some browsers do not support "classList". So, it's necessary to write a condition to see if the current browser supports it.
		if (button.classList) {
			button.classList.add(nameOfClass);
			dropdown.classList.add(nameOfClass);
			dropdownAria.setAttribute("aria-expanded", "true");
		}
 	}
 
	// declare function for "onMouseOut" event:
	dropdown.onmouseout = function () {
	
		if (button.classList) {
			button.classList.remove(nameOfClass);
			dropdown.classList.remove(nameOfClass);
			dropdownAria.setAttribute("aria-expanded", "false");
		}
	}

}




require('./bootstrap');

import Modal from './components/Modal';

window.Vue = require('vue');

Vue.component('modal', Modal);
// Vue.component('modalContent', ModalContent);

new Vue({
	el: '#app',
	data: {
        isModalVisible: false
    },
    methods: {
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
	var element = document.getElementById("jquery");
	var element2 = document.getElementById("jquery2");
	var dropdown = document.getElementById("navbarDropdown");
	var nameOfClass = "show";

	
	// declare function for "onMouseOver" event:
	element.onmouseover = function() {
		
		// Some browsers do not support "classList". So, it's necessary to write a condition to see if the current browser supports it.
		if (element.classList) {
			element.classList.add(nameOfClass);
			element2.classList.add(nameOfClass);
			dropdown.setAttribute("aria-expanded", "true");
		}
 	}
 
	// declare function for "onMouseOut" event:
	element2.onmouseout = function () {
	
		if (element.classList) {
			element.classList.remove(nameOfClass);
			element2.classList.remove(nameOfClass);
			dropdown.setAttribute("aria-expanded", "false");
		}
	}
}




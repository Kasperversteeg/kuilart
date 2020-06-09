require('./bootstrap');
require('vue-flash-message/dist/vue-flash-message.min.css');

// going to be one main + 4 components
import ModalRes from './components/ModalRes';
import ModalGrp from './components/ModalGrp';
import ModalResEdit from './components/ModalResEdit';
import ModalGrpEdit from './components/ModalGrpEdit';


import FormLine from './components/FormLine'; 
import VueFlashMessage from 'vue-flash-message'; 

window.Vue = require('vue');


Vue.component('res', ModalRes);
Vue.component('grp', ModalGrp);
Vue.component('formline', FormLine);
Vue.component('edit-res', ModalResEdit);
Vue.component('edit-grp', ModalGrpEdit);

Vue.use(VueFlashMessage);


new Vue({
	el: '#app',
	data: {
        resModalShowing: false,
        grpModalShowing: false,
        editGrpShowing: false,
        editResShowing: false,
        count: 0,
        fields: [],
        editId: 0
    },
    methods: {
      toggleRes() {
        this.resModalShowing = !this.resModalShowing;
      },
      toggleGrp(){
      	this.grpModalShowing = !this.grpModalShowing;
      },
      editReservation(reservationId){
      	this.editId = reservationId;
      	this.editResShowing = true;
      },
      closeReservation(){
      	this.editResShowing = false;
      },
      editGroup(reservationId){
      	this.editId = reservationId;
      	this.editGrpShowing = true;
      },
      closeGroup(){
      	this.editGrpShowing = false;
      },
    }
});

window.onload = function() {
	var button = document.getElementById("nav-add");
	var dropdown = document.getElementById("nav-dropdown");
	var dropdownAria = document.getElementById("navbarDropdown");
	var menuBalk = document.getElementById("nav-container");
	var overzicht = document.getElementById("overzicht");
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
		closeHover();
	}
	// declare function for "onMouseOut" event:
	overzicht.onmouseout = function () {
		closeHover();
	}

	function closeHover(){
		if (button.classList) {
			button.classList.remove(nameOfClass);
			dropdown.classList.remove(nameOfClass);
			dropdownAria.setAttribute("aria-expanded", "false");
		}
	}
}




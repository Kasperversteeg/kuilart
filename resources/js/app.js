require('./bootstrap');
// require('vue-flash-message/dist/vue-flash-message.min.css');

import Modal from './components/Modal';
import AddButton from './components/AddButton';
import FormLine from './components/FormLine';

// not mine  
import VueFlashMessage from 'vue-flash-message';
import Datepicker from 'vuejs-datepicker';

window.Vue = require('vue');
Vue.use(VueFlashMessage);

Vue.component('modal', Modal);
Vue.component('add', AddButton);
Vue.component('formline', FormLine);
Vue.component('vuejs-datepicker', Datepicker);

new Vue({
    el: '#app',
    data: {
        modalShowing: false,
        modalObj: {}
    },
    methods: {
        showModal() {
            document.querySelector('body').classList.toggle('modal-open');
            this.modalShowing = true;
        },
        closeModal() {
            document.querySelector('body').classList.toggle('modal-open');
            this.$emit('clearReservation');
            this.modalShowing = false;
        },
        editReservation(id) {
            console.log('editing RESTAURANT reservation with id ' + id);
            this.modalObj.id = id;
            this.modalObj.reservationType = 'RES';
            this.modalObj.editing = true;
            this.modalObj.title = 'Wijzig restaurant reservering';
            this.$emit('setModal', this.modalObj);
            this.showModal();
        },
        editGroup(id) {
            console.log('editing GROEP reservation with id ' + id);
            this.modalObj.id = id;
            this.modalObj.reservationType = 'GRP';
            this.modalObj.editing = true;
            this.modalObj.title = 'Wijzig groep reservering';
            this.$emit('setModal', this.modalObj);
            this.showModal();
        },
        editBowling(id) {
            console.log('editing Bowling reservation with id ' + id);
            this.modalObj.id = id;
            this.modalObj.reservationType = 'BWL';
            this.modalObj.editing = true;
            this.modalObj.title = 'Wijzig bowling reservering';
            this.$emit('setModal', this.modalObj);
            this.showModal();
        }
    },
    watch: {
        modalShowing: function() {
            if (this.modalshowing) {
                document.querySelector('body').classList('modal-open');
            }

        }
    }
});

// window.onload = function() {
// 	var overzicht = document.getElementById("overzicht");
// 	var nameOfClass = "show";
// 	var freeBowlingSlots = document.getElementsByClassName('empty-slot');

// 	var returnId = function(){
// 		var id = this.getAttribute('id');
// 		var split = id.split("-");
// 		setInput(split[0], split[1]);
// 	}

// 	for (var i = 0; freeBowlingSlots.length > i ; i++) {
// 		freeBowlingSlots[i].addEventListener('click', returnId, false);
// 	}
// }


// function setInput(nr, time){
// 	let startTime = document.getElementById('startTime');
// 	startTime.value = time;
// 	let lane = document.getElementById('lane');
// 	lane.value = nr;
// 	setEndTime(time);
// }

// function setEndTime(time){
// 	let spl = time.split(':');
// 	let addHour = parseInt(spl[0]);
// 	addHour++;
// 	// console.log(addHour+':'+spl[1]);

// 	let endTime = document.getElementById('endTime');
// 	endTime.value = addHour+':'+spl[1];
// }
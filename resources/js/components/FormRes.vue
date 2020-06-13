<template>
	<transition name="fade">
		<div>     
			<p>Voor die datum staan er al: <strong>{{ totalReservations }}</strong> reserveringen</p>

			<form method="post" @submit="formSubmit">
				<input type="hidden" name="_token" :value="csrf">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">    
							<label for="name">Name</label>
							<input type="text" id="name" :class="['form-control', {'input-is-invalid' : errors.has('name')}]" name="name" v-model="reservation.name"/>
							<span class="input-invalid-msg">{{ errors.get('name') }}</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">    
							<label for="date">Datum</label>
							<vuejs-datepicker id="date" v-model="reservation.date" :input-class="['form-control' ,{'input-is-invalid' : errors.has('date')}]" typeable></vuejs-datepicker>
							<!-- <input type="date" :class="{'input-is-invalid' : errors.has('date')}" class="form-control" name="date"  v-model="date" @change="getTotal()"/> -->
							<span class="input-invalid-msg">{{ errors.get('date') }}</span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">    
							<label for="startTime">Tijd</label>
							<div :class="{'input-is-invalid' : errors.has('startTime')}" class="form-control p-0" id="startTime">
								<vue-timepicker 
								v-model="reservation.startTime" 
								:minute-interval="15" 
								:hour-range="[11,12,13,14,15,16,17,18,19,20,21,22,23]"
								manual-input 
								close-on-complete  
								>
							</vue-timepicker>
						</div>
						<span class="input-invalid-msg">{{ errors.get('startTime') }}</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">    
						<label for="size">Aantal personen</label>
						<input id="size" type="text" :class="['form-control', {'input-is-invalid' : errors.has('size')}]" name="size" v-model="reservation.size"/>
						<span class="input-invalid-msg">{{ errors.get('size') }}</span>
					</div>
				</div>
			</div>

			<div class="form-group">    
				<label for="notes">Opmerking</label>
				<input id="notes" type="text" :class="{'input-is-invalid' : errors.has('notes')}" class="form-control" name="notes" v-model="reservation.notes"/>
				<span class="input-invalid-msg">{{ errors.get('notes') }}</span>
			</div> 

			<div class="row justify-content-end">
				<div class="col-sm-2">
					<button type="submit" class="btn btn-primary float-right">Voeg toe</button>
				</div>
			</div>
		</form>
	</div>


</transition>
</template>
<script>
	import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue';
	import Datepicker from 'vuejs-datepicker';

	class Errors{

		constructor(){
			this.errors = {};
		}

		get(field){
			if(this.errors[field]){
				return this.errors[field][0];
			}
		}
		has(field){
			if(this.errors[field]){
				return true;
			}
			return false;
		}
		record(errors){
			this.errors = errors.errors;
		}
		reset(){
			this.errors = {};
		}

	}
	class Reservation{
		reset(){
			console.log('clearing reservation');
			var i = 0;
			var keys = Object.keys(this);
			while (i < keys.length)
			{
				this[keys[i]] = '';
				i++;
			}
		}
		record(data){
			var i = 0;
			var keys = Object.keys(data);
			while (i < keys.length)
			{
				this[keys[i]] = data[keys[i]];
				i++;
			}
		}
	}

	export default {
		name: 'res',
		components: {
			VueTimepicker,
			Datepicker
		},
		props: {
			data: Object,
			editing: Boolean
		},
		data: function(){
			return{
				reservation: new Reservation(),
				errors: new Errors(),
				totalReservations: 0,
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			}     
		},
		methods: {
			getTotal(){
				console.log('date changed'+this.date);
				axios.get('/reservations/total/'+this.date)
				.then(response => {
					console.log(response.data.total);
					this.totalReservations = response.data.total;
				})
				.catch(error => {
					this.flash('Er is iets misgegaan bij het ophalen van het totale aantal reserveringen', 'error', {timeout: 3000});
				})
			},
			formSend(){   
				this.flash('Reservering geplaatst!', 'success', {timeout: 3500});
				this.$parent.$emit('close');
			},
			formSubmit(e){
				e.preventDefault();
				let currentObj = this;
				axios.post('/reservations', {
					name: this.reservation.name,
					size: this.reservation.size,
					date: this.reservation.date,
					startTime: this.reservation.startTime,
					notes: this.reservation.notes
				})
				.then(response => {
					this.formSend();
				})
				.catch(error => {
					this.errors.record(error.response.data);
					this.flash('Er zijn invoervelden niet goed ingevuld!', 'error', {timeout: 3000});
				})
			},
			updateFields(){
				this.reservation.record(this.data);
				var i = 0;
				var keys = Object.keys(this.reservation);
				if(this.editing){
					while (i < keys.length){			
						let el = document.getElementById(keys[i]);
						if(el && this.reservation[keys[i]] != null){
							console.log('updating ' + this.reservation[keys[i]])
							el.value = this.reservation[keys[i]];
						}
						i++;
					}
				} 

			},
			clearFields(){
				var i = 0;
				var keys = Object.keys(this.reservation);

				while (i < keys.length){			
					let el = document.getElementById(keys[i]);
					if(el){
						console.log('updating ' + this.reservation[keys[i]])
						el.value = this.reservation[keys[i]];
					}
					i++;
				}
			},
			reset(){
				this.reservation.reset();
				console.log(this.reservation);
				this.clearFields();
			}
		},
		mounted() {
			if(this.editing){
				this.updateFields();
			}
			this.$root.$on('clearReservation', this.reset);
		},
		watch: {
			data: function(){
				this.updateFields();
			}
		}
	};
</script>
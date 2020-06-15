<template>
	<transition name="fade">
		<div>
			<template v-if="!editing">
				<p>Voor die datum staan er al: <strong>{{ totalReservations }}</strong> reserveringen</p>
			</template>

			<form method="post" @submit="formSubmit">
				<input type="hidden" name="_token" :value="csrf">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">    
							<label for="name">Name</label>
							<input type="text" :class="['form-control', {'input-is-invalid' : errors.has('name')}]" name="name" id="name" v-model="reservation.name"/>
							<span class="input-invalid-msg">{{ errors.get('name') }}</span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">    
							<label for="size">Aantal personen</label>
							<input type="text" :class="['form-control', {'input-is-invalid' : errors.has('size')}]" name="size" id="size" v-model="reservation.size"/>
							<span class="input-invalid-msg">{{ errors.get('size') }}</span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">    
							<label for="date">Datum</label>
							<input type="date" :class="['form-control', {'input-is-invalid' : errors.has('date')}]" name="date" id="date" v-model="reservation.date" @change="getTotal()"/>
							<span class="input-invalid-msg">{{ errors.get('date') }}</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">    
							<label for="mail">E-mail</label>
							<input type="text" :class="['form-control', {'input-is-invalid' : errors.has('mail')}]" name="mail" id="mail" placeholder="Optioneel" v-model="reservation.mail"/>
							<span class="input-invalid-msg">{{ errors.get('mail') }}</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">    
							<label for="phoneNr">Telefoon nummer</label>
							<input type="text" :class="['form-control', {'input-is-invalid' : errors.has('phoneNr')}]" name="phoneNr" id="phoneNr" placeholder="Optioneel" v-model="reservation.phoneNr"/>
							<span class="input-invalid-msg">{{ errors.get('phoneNr') }}</span>
						</div>
					</div>
				</div>

				<hr />

				<h5>Activiteiten</h5>
				<div class="row activity-row">
					<div class="col-md-6">
						<div class="form-group">    
							<label for="description">Name</label>
							<input type="text" class="form-control" name="act-description"/>
							<span class="input-invalid-msg">{{ errors.get('act-description') }}</span>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">    
							<label for="startTime">Start</label>
							<input type="text" :class="{'input-is-invalid' : errors.has('startTime')}" class="form-control" id="startTime" name="startTime" v-model="reservation.startTime"/>
							<span class="input-invalid-msg">{{ errors.get('startTime') }}</span>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">    
							<label for="act-endTime">Einde</label>
							<input type="text" class="form-control" name="act-endTime"/>
							<span class="input-invalid-msg">{{ errors.get('act-endTime') }}</span>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">    
							<label for="act-size">Aantal personen</label>
							<input type="text" class="form-control" name="act-size"/>
							<span class="input-invalid-msg">{{ errors.get('act-size') }}</span>
						</div>
					</div>
				</div>


				<formline v-for="item in fields" :key='item.id' :id="item.name"></formline>

				<button type="button" v-on:click="addActivity('testhallo')" class="btn btn-primary">Voeg nog een activiteit toe</button>
				<hr />
				
				<div class="form-group">    
					<label for="notes">Opmerking</label>
					<input type="text" class="form-control" id="notes" v-model="reservation.notes" name="notes"/>
				</div>             
				<div class="row justify-content-end">
					<div class="col-sm-2">
						<button type="submit" class="btn btn-primary float-right">Voeg toe</button>
					</div>
				</div>
			</form>

			<template v-if="this.editing">
				<div class="row">
					<div class="col-sm-2">
						<form method="delete" @submit="destroy">
							<input type="hidden" name="_token" :value="csrf">					
							<button type="submit" class="btn btn-danger">Delete reservation</button>
						</form>
					</div>
					<div class="col-sm-8 col-0"></div>
					<div class="col-sm-2">
					</div>
				</div> 			
			</template>

		</div>
	</transition>
</template>

<script>
	import FormLine from './FormLine'; 

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

	class Activities{

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
		name: 'modalgroup',
		components: {
			FormLine
		},
		props: {
			data: Object,
			editing: Boolean
		},
		data: function(){
			return{
				fields: [], 
				count: 0,
				reservation: new Reservation(),
				errors: new Errors(),
				totalReservations: 0,
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			}     
		},
		methods: {
			addActivity(id){
				this.fields.push({
					name: id,
					id:'act-'+this.count++
				});
			},
			getTotal(){
				if(this.reservation.date){
					axios.get('/reservations/total/'+this.reservation.date)
					.then(response => {
						this.totalReservations = response.data.total;
					})
					.catch(error => {
						this.flash('Er is iets misgegaan bij het ophalen van het totale aantal reserveringen', 'error', {timeout: 3000});
					})
				}
			},
			formSubmit(e){
				e.preventDefault();
				// when editing bool is false(new reservation) then post new axios request
				if(!this.editing) {
					console.log('posting fresh reservation');
					axios.post('/groups/store/', {
						name: this.reservation.name,
						size: this.reservation.size,
						date: this.reservation.date,
						startTime: this.reservation.startTime,
						notes: this.reservation.notes,
						phoneNr: this.reservation.phoneNr,
						mail: this.reservation.mail
					})
					.then(response => {
						this.flash('Reservering toegevoegd', 'success', {timeout: 3000});
						this.$parent.$emit('close');
					})
					.catch(error => {
						this.errors.record(error.response.data);
						this.flash('Er zijn invoervelden niet goed ingevuld!', 'error', {timeout: 3000});
					})
				// otherwise update the existing reservation
				} else {
					this.updateReservation();
				}
			},
			// reservering wijzigen
			updateReservation(){
				axios.patch('/groups/'+this.reservation.id, {				
						name: this.reservation.name,
						size: this.reservation.size,
						date: this.reservation.date,
						startTime: this.reservation.startTime,
						notes: this.reservation.notes,
						phoneNr: this.reservation.phoneNr,
						mail: this.reservation.mail
				})
				.then(response => {
					console.log(response.data.msg);
					this.flash(response.data.msg, 'success', {timeout: 3000});
					this.$parent.$emit('close');
				})
				.catch(error => {
					this.errors.record(error.response.data);
					this.flash('Er zijn invoervelden niet correct ingevuld!', 'error', {timeout: 3000});
				})
			},
			destroy(e){
				e.preventDefault();
				console.log('deleting reservation with id ' + this.reservation.id);
				axios.delete('/groups/'+ this.reservation.id)
				.then(response => {
					this.flash('Reservering verwijderd!', 'success', {timeout: 3500});
					this.$parent.$emit('close');
				})
				.catch(error => {
					this.errors.record(error.response.data);
					this.flash('Kon de reservering niet verwijderen!', 'error', {timeout: 3000});
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
							el.value = this.reservation[keys[i]];
						}
						i++;
					}
				} 
			},
			clearFields(){
				console.log ('clearing old reservation input');
				var i = 0;
				var keys = Object.keys(this.reservation);

				while (i < keys.length){			
					let el = document.getElementById(keys[i]);
					if(el){
						el.value = this.reservation[keys[i]];
					}
					i++;
				}
			},
			reset(){
				this.reservation.reset();
				this.clearFields();
			}
		},
		mounted() {
			if(this.editing){
				this.reservation.record(this.data);
				this.updateFields();
			}
			this.$root.$on('clearReservation', this.reset);

		},
		watch: {
			data: function(){
				if(this.data){
					this.updateFields();
				}
			}
		}
	};

</script>


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
							<input type="text" :class="{'input-is-invalid' : errors.has('name')}" class="form-control" name="name" id="name" v-model="reservation.name"/>
							<span class="input-invalid-msg">{{ errors.get('name') }}</span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">    
							<label for="size">Aantal personen</label>
							<input type="text" :class="{'input-is-invalid' : errors.has('size')}" class="form-control" name="size" id="size" v-model="reservation.size"/>
							<span class="input-invalid-msg">{{ errors.get('size') }}</span>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">    
							<label for="date">Datum</label>
							<input type="date" :class="{'input-is-invalid' : errors.has('date')}" class="form-control" name="date" id="date" v-model="reservation.date" @change="getTotal()"/>
							<span class="input-invalid-msg">{{ errors.get('date') }}</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">    
							<label for="mail">E-mail</label>
							<input type="text" :class="{'input-is-invalid' : errors.has('mail')}" class="form-control" name="mail" id="mail" placeholder="Optioneel" v-model="reservation.mail"/>
							<span class="input-invalid-msg">{{ errors.get('mail') }}</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">    
							<label for="phoneNr">Telefoon nummer</label>
							<input type="text" :class="{'input-is-invalid' : errors.has('phoneNr')}" class="form-control" name="phoneNr" id="phoneNr" placeholder="Optioneel" v-model="reservation.phoneNr"/>
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
				axios.post('/reservations/'+this.reservation.id, {
					name: this.reservation.name,
					size: this.reservation.size,
					date: this.reservation.date,
					startTime: this.reservation.startTime,
					notes: this.reservation.notes,
					type: this.reservation.type,
					_method: "patch"
				})
				.then(response => {
					this.flash('Reservering gewijzigd', 'success', {timeout: 3000});
					this.$parent.$emit('close');
				})
				.catch(error => {
					this.errors.record(error.response.data);
					this.flash('Er zijn invoervelden niet correct ingevuld!', 'error', {timeout: 3000});
				})
			},
			updateFields(){
				console.log ('updating reservation');
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
				console.log ('clearing old reservation input');
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
				this.reservation.record(this.data);
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


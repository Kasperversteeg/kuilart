<template>
	<div class="position-relative">
	<form method="post" @submit="formSubmit">
		<input type="hidden" name="_token" :value="csrf">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">    
					<label for="name">Naam</label>
					<input type="text" :class="['form-control', {'input-is-invalid' : errors.has('name')}]" name="name" id="name" v-model="bowling.name"/>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">    
					<label for="lane">Baan nummer</label>
					<select :class="['form-control', {'input-is-invalid' : errors.has('lane')}]" name="lane" id="lane" v-model="bowling.lane">
						<option  disabled>Baan nummer</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
					<span class="input-invalid-msg">{{ errors.get('lane') }}</span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">    
					<label for="date">Datum</label>
					<vuejs-datepicker id="date" v-model="bowling.date" :input-class="['form-control' ,{'input-is-invalid' : errors.has('date')}]" typeable></vuejs-datepicker>
					<span class="input-invalid-msg">{{ errors.get('date') }}</span>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">    
					<label for="startTime">Start tijd</label>
					<select :class="['form-control', {'input-is-invalid' : errors.has('startTime')}]" name="startTime" id="startTime" v-model="bowling.startTime">
						<option disabled>Start-tijd</option>
						<option value="17:00">17:00</option>
						<option value="18:00">18:00</option>
						<option value="19:00">19:00</option>
						<option value="20:00">20:00</option>
						<option value="21:00">21:00</option>
					</select>
					<span class="input-invalid-msg">{{ errors.get('startTime') }}</span>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">    
					<label for="endTime">Eind tijd</label>
					<select :class="['form-control', {'input-is-invalid' : errors.has('endTime')}]" name="endTime" id="endTime" v-model="bowling.endTime">
						<option disabled>Eind-tijd</option>
						<option value="18:00">18:00</option>
						<option value="19:00">19:00</option>
						<option value="20:00">20:00</option>
						<option value="21:00">21:00</option>
						<option value="22:00">22:00</option>
					</select>
					<span class="input-invalid-msg">{{ errors.get('endTime') }}</span>
				</div>
			</div>
		</div>				

		<div class="row justify-content-end">
			<div class="col-sm-2">
				<button type="submit" class="btn btn-primary float-right" v-text="this.editing ? 'Wijzig' : 'Voeg toe' "></button>
			</div>
		</div>
	</form>
	<template v-if="this.editing">
		<div class="col-sm-2 btn-delete">
			<form method="delete" @submit="destroy">
				<input type="hidden" name="_token" :value="csrf">					
				<button type="submit" class="btn btn-danger">Verwijder</button>
			</form>
		</div>	
	</template>
</div>
</template>
<script>
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
	class Bowling{
		reset(){
			console.log('clearing bowling reservation');
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
		props: {
			data: Object,
			editing: Boolean
		},
		data() {
			return {
				bowling : {},
				bowling: new Bowling(),
				errors: new Errors(),
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			}
		},
		methods:{
			formSubmit(e){
				e.preventDefault();
				if(!this.editing){
					axios.post('/bowling', {
						name: this.bowling.name,
						lane: this.bowling.lane,
						date: this.bowling.date,
						startTime: this.bowling.startTime,
						endTime: this.bowling.endTime
					})
					.then(response => {
						this.flash(response.data.msg, 'success', {timeout: 3000});
						this.$parent.$emit('close');
					})
					.catch(error => {
						this.errors.record(error.response.data);
						this.flash('Er zijn invoervelden niet goed ingevuld!', 'error', {timeout: 3000});
					})
				}
			},
			updateFields(){
				this.bowling.record(this.data);
				var i = 0;
				var keys = Object.keys(this.bowling);
				if(this.editing){
					while (i < keys.length){			
						let el = document.getElementById(keys[i]);
						if(el && this.bowling[keys[i]] != null){
							el.value = this.bowling[keys[i]];
						}
						i++;
					}
				} 
			},
			clearFields(){
				console.log ('clearing old reservation input');
				var i = 0;
				var keys = Object.keys(this.bowling);

				while (i < keys.length){			
					let el = document.getElementById(keys[i]);
					if(el){
						el.value = this.bowling[keys[i]];
					}
					i++;
				}
			},
			reset(){
				this.bowling.reset();
				this.clearFields();
			},
			destroy(e){
				e.preventDefault();
				axios.delete('/bowling/'+ this.bowling.id)
				.then(response => {
					this.flash(response.data.msg, 'success', {timeout: 3500});
					this.$parent.$emit('close');
				})
				.catch(error => {
					this.errors.record(error.response.data);
					this.flash('Kon de reservering niet verwijderen!', 'error', {timeout: 3000});
				})
			}
		},
		mounted() {
			if(this.editing){
				this.bowling.record(this.data);
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
	}
</script>

<template>
	<transition name="fade">
		<div class="modal-backdrop">
			<div class="modal container" role="modal"
			aria-labelledby="modalTitle"
			aria-describedby="modalDescription"
			>
				<div class="modal-header row" id="modalTitle">			
					<div class="col-11">
						<h1>{{ title }}</h1>
					</div>			
					<div class="col-1 d-flex justify-content-end">
						<button type="button" class="btn-close" @click="close" aria-label="Close modal" >
							&times;
						</button>
					</div>        
				</div>

				<div class="modal-content container py-4"> 
					<template v-if="editing">
						<component :is="component" :data="reservation" :editing="editing"></component>
					</template>

					<template v-else>
						<component :is="component" :editing="editing"></component>
					</template>

				</div>
			</div>
		</div>
	</transition>
</template>
<script>
	import FormRes from './FormRes';
	import FormGrp from './FormGrp';
	import FormBowling from './FormBowling';
	export default {
		components:{
			FormRes,
			FormGrp,
			FormBowling
		},
		data: function(){
			return{
				component: null,
				title:  null,
				id: null, 
				editing: false,
				reservation: {}
			}     
		},
		methods: {
			close() {
				console.log('closing modal '+this.editing);
				this.$emit('close');
				this.editing = false;
				
			},
			set(object){
				this.title = object.title;
				if(object.editing){	
					this.getReservation(object.id, object);
				} else {
					this.component = this.getType(object.reservationType);
				}
			},
			getReservation(id, object){
				if (object.reservationType === 'BWL'){
					console.log('type = bowling');
					axios.get('/bowling/'+id+'/edit')
					.then(response => {
						this.reservation = response.data.bowling;
						this.updateComponent(object);
						console.log(object.reservationType);
					})
					.catch(error =>{
						this.flash('Kon geen reservering met die ID ophalen', 'error', {timeout: 3000});
					})
				} else {
					axios.get('/reservations/'+id+'/edit')
					.then(response => {
						this.reservation = response.data.reservation;
						console.log(this.reservation);
						this.updateComponent(object);
					})
					.catch(error =>{
						this.flash('Kon geen reservering met die ID ophalen', 'error', {timeout: 3000});
					})
				}
			},
			getType(type){
				console.log('setting compontenttype for: '+ type);
				if(type === 'GRP'){
					return 'FormGrp';
				} else if(type === 'BWL') {
					return 'FormBowling';
				}
				return 'FormRes';
			},
			updateComponent(object){
				console.log()
				this.component = this.getType(object.reservationType);
				this.editing = object.editing;
				this.id = object.id;
			}
		},
		mounted(){
			this.$root.$on('setModal', this.set);
		}
	}
</script>


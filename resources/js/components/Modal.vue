<template>
	<transition name="fade">
		<div class="my-modal-backdrop">
			<div class="my-modal container p-4" role="modal"
			aria-labelledby="modalTitle"
			aria-describedby="modalDescription"
			>
				<div class="my-modal-header row border-bottom" id="modalTitle">			
					<div class="col-11">
						<h2>{{ title }}</h2>
					</div>			
					<div class="col-1 d-flex justify-content-end">
						<a class="my-modal-close" href="#" @click="close">
							<svg height="25px"  width="25px" viewBox="0 0 365.696 365.696" xmlns="http://www.w3.org/2000/svg">
							<path d="m243.1875 182.859375 113.132812-113.132813c12.5-12.5 12.5-32.765624 0-45.246093l-15.082031-15.082031c-12.503906-12.503907-32.769531-12.503907-45.25 0l-113.128906 113.128906-113.132813-113.152344c-12.5-12.5-32.765624-12.5-45.246093 0l-15.105469 15.082031c-12.5 12.503907-12.5 32.769531 0 45.25l113.152344 113.152344-113.128906 113.128906c-12.503907 12.503907-12.503907 32.769531 0 45.25l15.082031 15.082031c12.5 12.5 32.765625 12.5 45.246093 0l113.132813-113.132812 113.128906 113.132812c12.503907 12.5 32.769531 12.5 45.25 0l15.082031-15.082031c12.5-12.503906 12.5-32.769531 0-45.25zm0 0"/></svg>
						</a>
					</div>        
				</div>

				<div class="my-modal-content pt-3"> 
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


<template>
	<div class="container">
		<div class="row justify-content-end">
			<a class="btn-add btn-add-fixed" href="#" @click='click'>
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				 viewBox="0 0 210 210" enable-background="new 0 0 210 210" xml:space="preserve" width="40px" height="40px">
				<path d="M210,100.23v9.54c0,7.9-6.41,14.32-14.32,14.32h-71.59v71.59c0,7.9-6.41,14.32-14.32,14.32h-9.54
					c-7.9,0-14.32-6.41-14.32-14.32v-71.59H14.32c-7.9,0-14.32-6.41-14.32-14.32v-9.54c0-7.9,6.41-14.32,14.32-14.32h71.59V14.32
					C85.91,6.41,92.32,0,100.23,0h9.54c7.9,0,14.32,6.41,14.32,14.32v71.59h71.59C203.59,85.91,210,92.32,210,100.23z"/>
			</svg>
		</a>
		<div class="submenu" v-show="toggleSubMenu">
			<ul>
				<li><a href="#" @click='addGroup'>Groepen</a></li>
				<li><a href="#" @click='addRes'>Restaurant</a></li>
			</ul>
		</div>
		</div>
		
	</div>
</template>

<script>
	class Modal {
		set(title, reservationType, editing, id){
			this.reservationType = reservationType;
			this.title = title;
			this.editing = editing;
			this.id = id;
		}
	}

	export default {
		props: {
			reservationType: String,
			title: String,
			editing: {type: Boolean, default: false},
			id:{type: Number, default: 0}
		},
		components: {
		},
		data: function(){
			return{
				modal: new Modal(),
				toggleSubMenu: false
			}     
		},
		methods: {
			addGroup(){
				this.modal.set('Voeg groepsreservering toe', 'GRP', this.editing, this.id);
				this.$root.$emit('setModal', this.modal);
				this.toggleSubMenu = false;
				this.$emit('open');
			},
			addRes(){
				this.modal.set('Voeg restaurant reservering toe', 'RES', this.editing, this.id);
				this.$root.$emit('setModal', this.modal);
				this.toggleSubMenu = false;
				this.$emit('open');
			},
			click(){
				if(this.reservationType === 'ALL'){
					console.log('all');
					this.toggleSubMenu = !this.toggleSubMenu;
					console.log('clicked with ' + this.title+ this.reservationType+ this.editing+ this.id );
				} else {
					console.log('clicked with ' + this.title+ this.reservationType+ this.editing+ this.id );
					this.modal.set(this.title, this.reservationType, this.editing, this.id);
					this.$root.$emit('setModal', this.modal);
					this.$emit('open');
				}
			}
		},
	}
</script>

<style>
	.add-enter { 
		transform: translateY(150px);
	}

	.add-enter-to {
		transform: translateY(0px);
	} 

	.add-enter-active {
	 	transition: all 300ms ease; 
	}
</style>
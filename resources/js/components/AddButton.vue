<template>
	<div>
		<a class="btn btn-add btn-add-fixed" href="#" @click='click'>
			<img src="/img/plusje.svg" height='34px' width="34px">
		</a>
		<div class="submenu" v-show="toggleSubMenu">
			<ul>
				<li><a href="#" @click='addGroup'>Groepen</a></li>
				<li><a href="#" @click='addRes'>Restaurant</a></li>
			</ul>
		</div>
	</div>
</template>
<script>
	import AddSubMenu from './AddSubMenu';
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
			reservationType: String ,
			title: String,
			editing: {type: Boolean, default: false},
			id:{type: Number, default: 0}
		},
		components: {
			AddSubMenu
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


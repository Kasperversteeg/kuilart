<template>
  <div v-if="showing" class="cardModal container-fluid h-100">
      <div class="row h-100 justify-content-center">
  		<div class="col-md-8 bg-white">
       		 <button aria-label="close" class="" @click.prevent="close">×</button>
  			<slot />
  		</div>
  	</div>
  </div>
</template>

<script>
export default {
  props: {
    showing: {
      required: true,
      type: Boolean
    }
  },
  methods: {
  	close(){
  		this.$emit('close');
  	}
  }
};
</script>

<style>
	.cardModal {
	position: absolute;
	top:0;
	background-color: rgba(0, 0, 0, 1);
}
</style>
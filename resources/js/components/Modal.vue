<script>
  export default {
    name: 'modal',
    data: function(){
    		return{
          isGroup : true
        }      
    },
    methods: {
      setGrp() {
        if(!this.isGroup){
          this.isGroup = true;
          console.log('changed to ' + this.isGroup)
        }
      },
      setRes(){
        if(this.isGroup){
          this.isGroup = false;
        console.log('changed to ' + this.isGroup)
        }
      },
      close() {
        this.$emit('close');
      },
    },
  };
</script>
<template>
   <transition name="fade">
    <div class="modal-backdrop">
      <div class="modal container" role="modal"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >

			<div class="modal-header row" id="modalTitle">			
          	<div class="col-11">

	          	<slot name="header-title">This is the default title!</slot>

          	</div>			
          	<div class="col-1 d-flex justify-content-end">
	          		<button type="button" class="btn-close" @click="close" aria-label="Close modal" >
		            &times;
		         </button>
          	</div>        

			</div>
			<div class="modal-selector row" id="modalTitle">			
          	<div class="col-12">

	          	<slot name="selector-buttons">
    						<p> Default buttons:</p>
	          	</slot>

          	</div>	       

			</div>
			<div class="modal-content row" id="modalDescription">
				<div class="col-12">	
					<slot name="body">
		            I'm the default body!
	          </slot>
				</div>
			</div>


      </div>
    </div>

    </transition>
</template>
<style>

  .modal-backdrop {
    background-color: rgba(0, 0, 0, 0.3);
  }

  .modal {
  	margin-top: 5%;
    background: #FFFFFF;
  }

  .btn-close {
    border: 1px solid #ced4da;
    font-size: 30px;
    padding:0 10px;
    cursor: pointer;
    font-weight: bold;
    background: transparent;
  }



  .fade-enter-active, .fade-leave-active {
    transition: opacity .3s;
    }

    /*
    you set the css property before transition starts
    */
    .fade-enter, .fade-leave-to {
    opacity: 0;
    }

    /*
    you set the css property it will be when transition ends
    */
    .fade-enter-to, .fade-leave {
    opacity: 1;
    }

</style>
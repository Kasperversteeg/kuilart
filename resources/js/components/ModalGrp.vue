<template>
   <transition name="fade">
     <div class="modal-backdrop">
       <div class="modal container" role="modal"
       aria-labelledby="modalTitle"
       aria-describedby="modalDescription"
       >

       <div class="modal-header row" id="modalTitle">			
         <div class="col-11">
           <h1>Voeg groep toe</h1>
         </div>			
         <div class="col-1 d-flex justify-content-end">
           <button type="button" class="btn-close" @click="close" aria-label="Close modal" >
           &times;
           </button>
         </div>        
       </div>
    
      <div class="modal-content container py-4">  
        
          <p>Voor die datum staan er al: <strong>{{ totalReservations }}</strong> reserveringen</p>
          
         <form method="post" @submit="formSubmit">
            <input type="hidden" name="_token" :value="csrf">
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">    
                      <label for="name">Name</label>
                      <input type="text" class="form-control" name="name"/>
                     <span>{{ errors.get('name') }}</span>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">    
                      <label for="size">Aantal personen</label>
                      <input type="text" class="form-control" name="size"/>
                     <span>{{ errors.get('size') }}</span>
                  </div>
              </div>
            </div>

            <div class="row">
               <div class="col-md-6">
               <div class="form-group">    
                   <label for="date">Datum</label>
                   <input type="date" class="form-control" name="date" v-model="date" @change="getTotal()"/>
                     <span>{{ errors.get('date') }}</span>
               </div>
              </div>
                  <div class="col-md-6">
                  <div class="form-group">    
                      <label for="startTime">Tijd</label>
                      <input type="text" class="form-control" name="startTime"/>
                     <span>{{ errors.get('startTime') }}</span>
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
                     <span>{{ errors.get('act-description') }}</span>
                  </div>
              </div>

               <div class="col-md-2">
                  <div class="form-group">    
                      <label for="act-startTime">Start</label>
                      <input type="text" class="form-control" name="act-startTime"/>
                     <span>{{ errors.get('act-startTime') }}</span>
                  </div>
              </div>
               <div class="col-md-2">
                  <div class="form-group">    
                      <label for="act-endTime">Einde</label>
                      <input type="text" class="form-control" name="act-endTime"/>
                     <span>{{ errors.get('act-endTime') }}</span>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">    
                      <label for="act-size">Aantal personen</label>
                      <input type="text" class="form-control" name="act-size"/>
                     <span>{{ errors.get('act-size') }}</span>
                  </div>
               </div>
               </div>
                

                <formline v-for="item in fields" :key='item.id' v-bind:id="item.name">

                </formline>
               <button type="button" v-on:click="addActivity('test')" class="btn btn-primary">Voeg nog een activiteit toe</button>
            <hr />
            
                <div class="form-group">    
                    <label for="notes">Opmerking</label>
                    <input type="text" class="form-control" name="notes"/>
                </div>             
                <div class="row justify-content-end">
                  <div class="col-sm-2">
                  <button type="submit" class="btn btn-primary float-right">Add reservation</button>
                </div>
                </div>
            </form>

         </div>
        </div>
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

  export default {
    name: 'modalgroup',
    components: {
      FormLine
    },
    data: function(){
      return{
         fields: [], 
         count: 0,
         name: '',
         size: '',
         date: '',
         startTime: '',
         notes: '',
         errors: new Errors(),
         totalReservations: 0,
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }     
    },
    methods: {
      close() {
        this.errors.reset();
        this.$emit('close');
      },
      addActivity(id){
         this.fields.push({
            name: id,
            id:'act-'+this.count++
         });
      },
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
          this.close();         
          this.flash('Reservering geplaatst!', 'success', {timeout: 3500});
          this.name = '';
          this.size = '';
          this.date = '';
          this.startTime = '';
          this.notes = '';
      },
      formSubmit(e){
        e.preventDefault();
        let currentObj = this;
        axios.post('/groups/store', {
          name: this.name,
          size: this.size,
          date: this.date,
          startTime: this.startTime,
          notes: this.notes
        })
        .then(response => {
            this.formSend();
        })
        .catch(error => {
          this.errors.record(error.response.data);
          this.flash('Er zijn invoervelden niet goed ingevuld!', 'error', {timeout: 3000});
        })
      }
    },
  };
</script>


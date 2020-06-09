<template>
   <transition name="fade">
     <div class="modal-backdrop">
       <div class="modal container" role="modal"
       aria-labelledby="modalTitle"
       aria-describedby="modalDescription"
       >

       <div class="modal-header row" id="modalTitle">     
         <div class="col-11">
           <h1>Pas groep aan</h1>
         </div>     
         <div class="col-1 d-flex justify-content-end">
           <button type="button" class="btn-close" @click="close" aria-label="Close modal" >
           &times;
           </button>
         </div>        
       </div>
    
      <div class="modal-content container py-4">  
        
         <form method="post" @submit="updateReservation">
            <input type="hidden" name="_token" :value="csrf">
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">    
                      <label for="name">Name</label>
                      <input type="text" class="form-control" name="name" v-model="name"/>
                     <span>{{ errors.get('name') }}</span>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">    
                      <label for="size">Aantal personen</label>
                      <input type="text" class="form-control" name="size" v-model="size"/>
                     <span>{{ errors.get('size') }}</span>
                  </div>
              </div>
            </div>

            <div class="row">
               <div class="col-md-6">
               <div class="form-group">    
                   <label for="date">Datum</label>
                   <input type="text" class="form-control" name="date" v-model="date"/>
                     <span>{{ errors.get('date') }}</span>
               </div>
              </div>
                  <div class="col-md-6">
                  <div class="form-group">    
                      <label for="startTime">Tijd</label>
                      <input type="text" class="form-control" name="startTime"  v-model="startTime"/>
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
              
                <formline v-for="item in fields" :key='item.id' v-bind:id="item.name"></formline>
               <button type="button" v-on:click="addActivity('test')" class="btn btn-primary">Voeg nog een activiteit toe</button>
                <hr />
            
                <div class="form-group">    
                    <label for="notes">Opmerking</label>
                    <input type="text" class="form-control" name="notes"  v-model="notes"/>
                </div>             
                <div class="row justify-content-end">
                  <div class="col-sm-2">
                  <button type="submit" class="btn btn-primary float-right">Wijzig</button>
                </div>
                </div>
            </form>

         </div>
        </div>
      </div>
   </transition>
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

  export default {
   props:{
      id: Number
   },
   data(){
      return{
        fields: [], 
         count: 0,
         reservation: {},
         name: '',
         size: '',
         date: '',
         startTime: '',
         notes: '',
         errors: new Errors(),
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
   },
   methods: {
      close() {
         this.$emit('close');
      },
      updateForm(){
         this.name = this.reservation.name;
         this.size = this.reservation.size;
         this.date = this.reservation.date;
         this.startTime = this.reservation.startTime;
         this.notes = this.reservation.notes;
      },
      resetInput(){
          this.name = '';
          this.size = '';
          this.date = '';
          this.startTime = '';
          this.notes = '';
      },
      getReservation(){
         axios.get('/groups/'+this.id+'/edit')
         .then(response => {
            this.reservation = response.data.reservation;
            console.log(this.reservation.name);
            this.updateForm();
         })
         .catch(error =>{
            this.flash('Kon geen reservering met die ID ophalen', 'error', {timeout: 3000});

         })
      },
      updateReservation(e){
        e.preventDefault();
        let currentObj = this;
        console.log(currentObj);
        axios.post('/reservations/'+this.reservation.id, {
          name: currentObj.name,
          size: currentObj.size,
          date: currentObj.date,
          startTime: currentObj.startTime,
          notes: currentObj.notes,
          type: this.reservation.type,
          _method: "patch"
        })
        .then(response => {
          this.close();         
            this.flash('Reservering gewijzigd!', 'success', {timeout: 3500});
        })
        .catch(error => {
            this.errors.record(error.response.data);
            this.flash('Er zijn invoervelden niet correct ingevuld!', 'error', {timeout: 3000});
        })
      },
   },
   watch:{
      id: function(){
         this.resetInput();
         this.getReservation();
      }
   }
  };
    
</script>




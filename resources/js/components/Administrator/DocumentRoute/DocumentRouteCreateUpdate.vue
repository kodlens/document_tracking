<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6-desktop">
                    <div class="box box-table">
                        <div class="box-header">

                        </div>
                        <div class="box-body">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Route Name">
                                        <b-input type="text" 
                                            v-model="fields.route_name"
                                            placeholder="Route Name"
                                        >
                                        </b-input>
                                    </b-field>
                                </div>
                            </div><!--cols-->

                            <div v-for="(item, index) in fields.route_details" :key="index">
                                <div class="route-details">
                                    <b-field label="Order No.">
                                        <b-numberinput :controls="false" v-model="item.order_no"></b-numberinput>
                                    </b-field>
                                    <b-field label="Select Office">
                                        <b-select :controls="false" v-model="item.office_id">
                                            <option v-for="(item, index) in offices"
                                                :key="index" :value="item.office_id">{{ item.office }}</option>
                                        </b-select>
                                    </b-field>
                                    <b-field>
                                        <b-checkbox v-model="item.is_origin"
                                            true-value="1"
                                            false-value="0">
                                                Origin
                                        </b-checkbox>

                                        <b-checkbox v-model="item.is_last"
                                            true-value="1"
                                            false-value="0"
                                        >
                                            Last
                                        </b-checkbox>

                                    </b-field>
                                </div>
                                
                            </div>
                            
                            <div class="buttons">
                                <b-button type="is-primary"
                                    icon-left="plus"
                                    @click="addRouteDetail"
                                    label=""></b-button>
                            </div>

                            <hr>

                            <div class="buttons">
                                <b-button label="Save Route" 
                                    type="is-primary"
                                    @click="submitRoute"></b-button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default{
    data(){
        return {
            fields: {
                route_details: [],
            },

            
            offices: [],


        }
    },

    methods: {

        addRouteDetail(index){
            this.fields.route_details.push({
                route_id: 0,
                order_no: 0,
                office_id: 0,
                is_origin: 0,
                is_last: 0
            });
        },

        removeRouteDetail(index){
            this.fields.route_details.splice(index, 1);
        },


        loadOffices(){
            axios.get('/get-offices-for-routes').then(res=>{
                this.offices = res.data
            })
        },

        submitRoute(){
            axios.post('/document-routes', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'SAVED!',
                        message: 'Successfully saved.',
                        type: 'is-success',
                        confirmText: 'OK',
                        onConfirm: () => {
                           window.location = '/document-routes'
                        }
                    })
                }
            }).catch(err=>{
            
            })
        }
    },

    mounted(){
        this.loadOffices();
    }
}
</script>


<style scoped>
    .route-details{
        margin: 15px 0;
    }
</style>
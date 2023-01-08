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

                            </div>
                            
                            <div class="buttons">
                                <b-button type="is-primary" @click="addRouteDetail"
                                    label=""></b-button>
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
        }
    },

    mounted(){

    }
}
</script>
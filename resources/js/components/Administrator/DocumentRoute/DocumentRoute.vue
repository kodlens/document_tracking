<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6-desktop is-8-tablet">
                    <div class="box box-table">

                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">LIST OF DOCUMENT ROUTES</div>

                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                    <b-select v-model="sortOrder" @input="loadAsyncData">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>

                                    </b-select>
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                                 v-model="search.route" placeholder="Search Route"
                                                 @keyup.native.enter="loadAsyncData"/>
                                        <p class="control">
                                             <b-tooltip label="Search" type="is-success">
                                            <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                             </b-tooltip>
                                        </p>
                                    </b-field>
                                </div>
                            </div>
                        </div>

                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            backend-pagination
                            :total="total"
                            detailed
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="route_id" label="ID" v-slot="props">
                                {{ props.row.route_id }}
                            </b-table-column>

                            <b-table-column field="route_name" label="Route Name" v-slot="props">
                                {{ props.row.route_name }}
                            </b-table-column>

                            <b-table-column field="created_at" label="Created" v-slot="props">
                                {{ props.row.created_at | formatDateTime }}
                            </b-table-column>
                         

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <!-- <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small is-warning mr-1" tag="a" icon-right="pencil" @click="getData(props.row.route_id)"></b-button>
                                    </b-tooltip> -->
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="delete" @click="confirmDelete(props.row.route_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>

                            <template #detail="props">
                                <div v-if="props.row.route_details">
                                    <tr>
                                        <th>Order No</th>
                                        <th>Office</th>
                                        <th>Origin/Last</th>
                                        <th>ACtion</th>
                                    </tr>
                                    <tr v-for="(i,ix) in props.row.route_details" :key="ix">
                                        <td style="text-align: center;">{{ i.order_no }}</td>
                                        <td>{{ i.office }}</td>
                                        <td>
                                            <span v-if="i.is_origin == 1">
                                                ORIGIN
                                            </span>
                                            <span v-if="i.is_last == 1">
                                                END
                                            </span>
                                        </td>
                                        <td>
                                            <b-tooltip label="Edit" type="is-info">
                                                <b-button class="button is-small is-warning mr-1" icon-right="pencil" @click="confirmDeleteRouteDetail(i.route_detail_id)"></b-button>
                                            </b-tooltip>
                                            <b-tooltip label="Delete" type="is-danger">
                                                <b-button class="button is-small is-danger mr-1" icon-right="delete" @click="editROuteDetail(i.route_detail_id)"></b-button>
                                            </b-tooltip>
                                        </td>
                                    </tr>
                                </div>
                            </template>
                            
                        </b-table>

                        <div class="float-button">
                            <b-button tag="a"
                                :href="`/document-routes/create`"
                                icon-right="plus-circle-outline" 
                                class="is-success is-rounded is-large">
                            </b-button>
                        </div>
                        
                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->


    </div>
</template>

<script>

export default{
    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'route_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            global_id : 0,

            search: {
                route: '',
            },

            isModalCreate: false,

            fields: {
                office: ''
            },

            errors: {},
         

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `route=${this.search.route}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-admin-document-routes?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },

        openModal(){
            this.isModalCreate=true;
            this.fields = {};
            this.errors = {};
        },



        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/document-routes/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/document-routes', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });


            }
        },


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/document-routes/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        clearFields(){
            this.fields = {
                office: '',
            };
        },


        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;


            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/document-routes/'+data_id).then(res=>{
                this.fields = res.data;
            });
        },





        //Route Detail
        //alert box ask for deletion
        confirmDeleteRouteDetail(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete office?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteRouteDetail(delete_id)
            });
        },
        //execute delete after confirming
        deleteRouteDetail(delete_id) {
            axios.delete('/document-route-details/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },



    },

    mounted() {
        this.loadAsyncData();
    }
}
</script>


<style>


</style>

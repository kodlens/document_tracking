<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-desktop is-10-tablet">
                    <div class="box box-table">

                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">LIST OF DOCUMENTS</div>

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
                                                 v-model="search.document" placeholder="Search document"
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
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="document_id" label="ID" v-slot="props">
                                {{ props.row.document_id }}
                            </b-table-column>

                            <b-table-column field="tracking_no" label="Tracking No." v-slot="props">
                                {{ props.row.tracking_no }}
                            </b-table-column>

                            <b-table-column field="document_name" label="Document Name" v-slot="props">
                                {{ props.row.document_name }}
                            </b-table-column>

                            <b-table-column field="route" label="Route" v-slot="props">
                                {{ props.row.route.route_name }}
                            </b-table-column>
                         

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Forward" type="is-warning">
                                        <b-button class="button is-small is-warning mr-1" tag="a" icon-right="arrow-right" @click="forwardDoc(props.row.document_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="delete" @click="confirmDelete(props.row.document_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>
                        </b-table>

                        <div class="float-button">
                            <b-button @click="openModal" 
                                icon-right="plus-circle-outline" 
                                class="is-success is-rounded is-large">
                            </b-button>
                        </div>
                        
                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Document Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Document" label-position="on-border"
                                             :type="this.errors.document_name ? 'is-danger':''"
                                             :message="this.errors.document_name ? this.errors.document_name[0] : ''">
                                        <b-input v-model="fields.document_name"
                                            placeholder="Document Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Document Route" label-position="on-border"
                                             :type="this.errors.route_id ? 'is-danger':''"
                                             :message="this.errors.route_id ? this.errors.route_id[0] : ''">
                                        <b-select v-model="fields.route_id"
                                            placeholder="Document Route">

                                            <option v-for="(item, index) in document_routes" 
                                                :key="index"
                                                :value="item.route_id">
                                                {{ item.route_name }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                        
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


    </div>
</template>

<script>
import { toSJIS } from '@chenfengyuan/vue-qrcode'


export default{
    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'document_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                document: '',
            },

            isModalCreate: false,

            fields: {},

            errors: {},
            
            document_routes: [],

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
                `document=${this.search.document}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-documents?${params}`)
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

        loadDocumentRoutes(){
            axios.get('/get-document-routes').then(res=>{
                this.document_routes = res.data
            })
        },

        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/documents/'+this.global_id, this.fields).then(res=>{
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
                axios.post('/documents', this.fields).then(res=>{
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
            axios.delete('/documents/' + delete_id).then(res => {
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
            axios.get('/documents/'+data_id).then(res=>{
                this.fields = res.data;
            });
        },

        forwardDoc(docId){
            this.$buefy.dialog.confirm({
                title: 'Forward?',
                type: 'is-info',
                message: 'Are you sure you want forward the document now?',
                cancelText: 'Cancel',
                confirmText: 'Forward',
                onConfirm: () => {
                    axios.post('/document-forward/' + docId).then(res=>{
                        if(res.data.status === 'forwarded'){
                            this.$buefy.toast.open({
                                duration: 5000,
                                message: `Document successfully <b>forwarded</b>.`,
                                position: 'is-top',
                                type: 'is-success'
                            })
                        }
                    })

                    this.loadAsyncData()
                }
            });
        }



    },

    mounted() {
        this.loadAsyncData();
        this.loadDocumentRoutes()
    }
}
</script>


<style>


</style>

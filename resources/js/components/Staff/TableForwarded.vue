<template>
    <div>

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
                            v-model="search.track_no" placeholder="Tracking No."
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
            detailed
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
                {{ props.row.document.tracking_no }}
            </b-table-column>

            <b-table-column field="document_name" label="Document Name" v-slot="props">
                {{ props.row.document.document_name }}
            </b-table-column>
            
            <b-table-column field="is_received" label="Received Status" v-slot="props">
                <span v-if="props.row.is_received === 1" class="process">
                    Received
                </span>
            </b-table-column>

            <b-table-column field="datetime_received" label="Date Received" v-slot="props">
                {{ props.row.datetime_received | formatDateTime }}
            </b-table-column>
            

            <b-table-column label="Action" v-slot="props">
                <div class="is-flex">

                    <b-dropdown aria-role="list">
                        <template #trigger="{ active }">
                            <b-button
                                label="Option"
                                type="is-primary"
                                class="is-small"
                                :icon-right="active ? 'menu-up' : 'menu-down'" />
                        </template>


                        <b-dropdown-item aria-role="listitem" v-if="props.row.is_origin === 0" @click="receivedDocument(props.row)">Receive</b-dropdown-item>
                        <b-dropdown-item aria-role="listitem" v-if="props.row.is_origin === 0" @click="processDocument(props.row)">Process</b-dropdown-item>
                        <b-dropdown-item aria-role="listitem" @click="forwardDocument(props.row)">Forward</b-dropdown-item>
                    </b-dropdown>
                </div>
            </b-table-column>



            <template slot="detail" slot-scope="props">
                <tr>
                    <th>Process Status</th>
                    <th>Process Date Time</th>

                    <th>Forward Status</th>
                    <th>Forward Date Time</th>

                </tr>
                <tr>
                    <td v-if="props.row.is_process === 1">
                        <span class="process">Processing</span>
                    </td>
                    <td v-if="props.row.is_process === 1">{{ props.row.datetime_process | formatDateTime }}</td> 

                    <td v-if="props.row.is_forwarded === 1">
                        <span class="process">Forwarded</span>
                    </td>
                    <td v-if="props.row.is_forwarded === 1">{{ props.row.datetime_forwarded | formatDateTime }}</td>

                </tr>
            </template>


        </b-table>

        <div class="float-button">
            <b-button @click="openModal" 
                icon-right="plus-circle-outline" 
                class="is-success is-rounded is-large">
            </b-button>
        </div>
                        


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

export default{
    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'document_track_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                track_no: '',
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
                
                `trackno=${this.search.track_no}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-forwarded-documents?${params}`)
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


        receivedDocument(row){
            this.$buefy.dialog.confirm({
                title: 'Receive?',
                type: 'is-info',
                message: 'Are you sure you want receive the document now?',
                cancelText: 'Cancel',
                confirmText: 'Yes',
                onConfirm: () => {
                    axios.post('/document-receive/' + row.document_track_id).then(res=>{
                        if(res.data.status === 'done'){
                            this.$buefy.toast.open({
                                duration: 5000,
                                message: `<b>Done.</b>`,
                                position: 'is-top',
                                type: 'is-success'
                            })
                        this.loadAsyncData()
                        }
                    })
                }
            });
        },
        processDocument(row){
            this.$buefy.dialog.confirm({
                title: 'Process.',
                type: 'is-info',
                message: 'Mark document as process?',
                cancelText: 'Cancel',
                confirmText: 'Yes',
                onConfirm: () => {
                    axios.post('/document-process/' + row.document_track_id).then(res=>{
                        if(res.data.status === 'done'){
                            this.$buefy.toast.open({
                                duration: 5000,
                                message: `<b>Done.</b>`,
                                position: 'is-top',
                                type: 'is-success'
                            })
                            this.loadAsyncData()
                        }
                    })
                    
                }
            });
        },

        forwardDocument(row){
            this.$buefy.dialog.confirm({
                title: 'Forward?',
                type: 'is-info',
                message: 'Are you sure you want forward the document now?',
                cancelText: 'Cancel',
                confirmText: 'Forward',
                onConfirm: () => {
                    axios.post('/document-forward/' + row.document_track_id + '/' + row.document_id).then(res=>{
                        this.$buefy.toast.open({
                            duration: 5000,
                            message: `<b>Done.</b>`,
                            position: 'is-top',
                            type: 'is-success'
                        })
                        this.loadAsyncData()
                    })
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


<style scoped>
    .process{
        padding: 10px;
        background-color: green;
        color: white;
    }

</style>

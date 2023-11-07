<template>
    <div>
        <div class="box box-table">
            <div class="box-header">
                <div class="box-header-text">
                    Track Document
                </div>
            </div>
            <div class="box-body">
                <div>
                    <b-field label="Tracking No." expanded>
                        <b-input type="text" expanded
                            v-model="fields.tracking_no"
                            placeholder="Tracking No."
                        ></b-input>
                        <p class="control">
                            <b-button icon-left="file-document-multiple-outline"
                                type="is-primary" @click="searchDocTrack"></b-button>
                        </p>
                    </b-field>
                    <hr>

                    <div class="result-container">
                        <div v-for="(item, ix) in results.document_tracks" :key="ix">
                            <div class="office-container">
                                <strong>{{ item.office.office }}</strong> 

                                <div v-if="item.is_origin == 0">
                                    <div>
                                        Received: 
                                        <span v-if="item.is_received == 1">
                                            <span class="yes">Yes</span> | 
                                            <span>{{ item.datetime_received | formatDateTime }}</span>
                                        </span>
                                    </div>
                                    <div>
                                        Process: 
                                        <span v-if="item.is_process == 1">
                                            <span class="yes">Yes</span> | 
                                            <span>{{ item.datetime_process | formatDateTime}}</span>
                                        </span>
                                    </div>
                                    
                                </div>
                                
                                <div v-if="item.is_last == 1">
                                    Done: 
                                    <span v-if="item.is_done == 1">
                                        <span class="yes">Yes</span> | 
                                        <span>{{ item.datetime_done | formatDateTime }}</span>
                                    </span>
                                </div>
                                <div v-else>
                                    Forwarded: 
                                    <span v-if="item.is_forwarded == 1">
                                        <span class="yes">Yes</span> | 
                                        <span>{{ item.datetime_forwarded | formatDateTime }}</span>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div><!--bod body-->
        </div>
    </div>
</template>

<script>
export default{
    data(){
        return {
            fields: {
                tracking_no: '',
            },

            results: {
                document_tracks: []
            },

        }
    },

    methods: {
        searchDocTrack(){
            axios.get('/search-track-no?trackno=' + this.fields.tracking_no).then(res=>{
                this.results = res.data

                console.log(this.results.document_tracks);
            })
        }

    },

    mounted(){

    }
}
</script>

<style>
    .result-container{
        /* border: 1px solid red; */
    }

    .office-container{
        margin-bottom: 25px;
    }

    .yes{
        padding: 5px;
        background-color: green;
        color: white;
    }
</style>
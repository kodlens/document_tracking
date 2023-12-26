<template>
    <div>

        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <b v-if="user.office_id > 0">
                        {{ user.role }}
                        {{ (user.office.office) }}
                    </b>
                </b-navbar-item>
            </template>

            <template #start>
               
               
            </template>

            <template #end>
                <b-navbar-item href="/admin-home">
                        Home
                </b-navbar-item>
                <b-navbar-item href="/offices">
                    Office
                </b-navbar-item>
                <b-navbar-item href="/document-routes">
                    Route
                </b-navbar-item>
                <b-navbar-item href="/document-logs">
                    Document Logs
                </b-navbar-item>
                <b-navbar-item href="/users">
                    User
                </b-navbar-item>
                <b-navbar-item tag="div">
                    <div class="buttons">
                     
                        <b-button 
                            @click="logout"
                            icon-left="logout"
                            class="button is-primary" outlined>
                        </b-button>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>



        


    </div>
</template>

<script>

export default{
    data(){
        return {

            open: true,
            expandWithDelay: false,

            user: {},
           
        }
    },

    methods: {
        logout(){
            axios.post('/logout').then(res=>{
                window.location = '/'
            }).catch(err=>{
            
            })
        },

        loadUser(){
            axios.get('/get-user').then(res=>{
                this.user = res.data;
            })
        }
    },

    mounted(){
        this.loadUser()
    }
}
</script>

<template>
    <div>

        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <img
                        src=""
                        alt=""
                    >
                </b-navbar-item>
            </template>
            <template #start>
                <b-navbar-item href="/admin-home">
                    Home
                </b-navbar-item>
                <b-navbar-item href="/offices">
                    Office
                </b-navbar-item>
                <b-navbar-item href="/document-routes">
                    Route
                </b-navbar-item>
                <b-navbar-item href="/users">
                    User
                </b-navbar-item>
                <!-- <b-navbar-dropdown label="Info">
                    <b-navbar-item href="#">
                        About
                    </b-navbar-item>
                    <b-navbar-item href="#">
                        Contact
                    </b-navbar-item>
                </b-navbar-dropdown> -->
            </template>

            <template #end>
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
            expandWithDelay: false
           
        }
    },

    methods: {
        logout(){
            axios.post('/logout').then(res=>{
                window.location = '/'
            }).catch(err=>{
            
            })
        }
    },

    mounted(){

    }
}
</script>

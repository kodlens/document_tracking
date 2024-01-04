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
             
                <b-navbar-item href="/staff-home">
                    Home
                </b-navbar-item>

                <b-navbar-item href="/staff-documents">
                    Documents <span v-if="count > 0" class="count">{{ count }}</span>
                </b-navbar-item>

                <b-navbar-item href="#">
                    {{ firstName }}
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

            user: {
                fname: '',
            },

            count: 0,

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
        },

        countForwardedDoc(){
            axios.get('/count-forwarded-doc').then(res=>{
                this.count = res.data
            })
        }
    },

    mounted(){
        this.loadUser()
        this.countForwardedDoc()
    },

    computed: {
        firstName(){
            return this.user.fname.toUpperCase()
        }
    }
}
</script>


<style scoped>
    .count{
        background-color: red;
        color: white;
        font-weight: bold;
        font-size: 12px;
        width: 20px;
        margin-left: 5px;
        text-align: center;
        border-radius: 50%;
    }
</style>

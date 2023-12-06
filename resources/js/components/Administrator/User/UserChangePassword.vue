<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-4">
                    <div class="panel is-primary">

                        <div class="panel-heading is-size-6">
                            CHANGE PASSWORD
                        </div>


                        <div class="p-4">

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Old Password" label-position="on-border"
                                        :type="this.errors.old_password ? 'is-danger':''"
                                        :message="this.errors.old_password ? this.errors.old_password[0] : ''">
                                        <b-input type="password" v-model="fields.old_password" password-reveal
                                            placeholder="Password" required>
                                        </b-input>
                                    </b-field>
                                    <b-field label="Password" label-position="on-border"
                                        :type="this.errors.password ? 'is-danger':''"
                                        :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-input type="password" v-model="fields.password" password-reveal
                                            placeholder="Password" required>
                                        </b-input>
                                    </b-field>
                                    <b-field label="Confirm Password" label-position="on-border"
                                             :type="this.errors.password_confirmation ? 'is-danger':''"
                                             :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                        <b-input type="password" v-model="fields.password_confirmation"
                                            password-reveal
                                            placeholder="Confirm Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="buttons">
                                <b-button
                                    :class="btnClass"
                                    label="Update password"
                                    @click="submit"
                                    icon-left="lock-reset"
                                >Change Password</b-button>
                            </div>
                        </div> <!--panel body-->

                    </div> <!--panel-->
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->


    </div>
</template>

<script>

export default{

    data() {
        return{

            fields: {
                password: '',
                password_confirmation: ''
            },

            errors: {},
           

            btnClass: {
                'is-primary': true,
                'button': true,
                'is-loading':false,
            },

        }

    },

    methods: {
      

        submit: function(){
            axios.post('/user-change-password', this.fields).then(res=>{
                if(res.data.status === 'updated'){
                    this.$buefy.dialog.alert({
                        title: 'Updated!',
                        message: 'Password change successfully.',
                        type: 'is-success',
                        confirmText: 'OK'
                    })

                    this.fields = {}
                    this.errors = {}
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            });
        },


        //alert box ask for deletion
       
        clearFields(){
            this.fields.password = '';
            this.fields.password_confirmation = '';
        },

    },


}
</script>

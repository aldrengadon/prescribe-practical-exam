<template>
    <div class="modal fade" id="delete-user-modal" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="glyph-icon icon-trash"></i> Delete User</h4>
                </div>
                <div class="modal-body center-div mrg25A">
                    <h4 class="font-bold font-size-16 mrg25A" v-if="!alert.notif && !alert.success && !alert.fail">
                        Do you really want to Delete User {{this.user.first_name+" "+this.user.last_name}}?
                    </h4>
                    <transition name="fade" v-if="alert.notif">
                        <notification-notice 
                            title="SUCCESS!"
                            :message="alert.message">
                        </notification-notice>
                    </transition>
                    <transition name="fade" v-if="alert.success">
                        <notification-success 
                            title="SUCCESS!"
                            :message="alert.message">
                        </notification-success>
                    </transition>
                    <transition name="fade" v-if="alert.fail">
                        <notification-fail
                            title="FAILED!"
                            :message="alert.message">
                        </notification-fail>
                    </transition>
                </div>
                <div class="modal-footer">
                    <div class="col-md-3">
                        <button
                            v-if="!alert.success"
                            :disabled="alert.notif"
                            type="button"
                            class="btn btn-block btn-default"
                            data-dismiss="modal">
                            <i class="glyph-icon icon-times-circle"></i>
                            &nbsp;&nbsp;Close
                        </button>
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-3">
                        <button v-if="alert.success"                            
                            :disabled="alert.notif"
                            type="button"
                            class="btn btn-block btn-default"
                            data-dismiss="modal">
                            Okay&nbsp;&nbsp;
                            <i class="glyph-icon icon-check-circle"></i>                                
                        </button>
                        <button v-else
                            :disabled="alert.notif || alert.success"
                            type="button"
                            class="btn btn-block btn-success"
                            v-on:click="deleteUser()">
                            Delete User&nbsp;&nbsp;
                            <i class="glyph-icon icon-check-circle"></i>                                
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import VueProgressBar from 'vue-progressbar';
    Vue.use(VueProgressBar, {
        color: 'red',
        failedColor: 'red',
        height: '20px'
    });

    export default {
        props: [
            'user'
        ],
        data () {
            return {
                alert: {
                    notif: false,
                    success: false,
                    fail: false,
                    message: "",
                    errors: {}
                },
            }
        },
        methods:{
            deleteUser(){
                this.$Progress.start();
                this.alert.notif = true;
                this.alert.success = false;
                this.alert.fail = false;
                this.alert.message = "Deleting User!";
                var data = {
                    id: this.user.id
                }
                axios.post('delete-user', data)
                .then((response) => {
                    if(response.data.success === true){
                        this.alert.success = true;
                        this.alert.fail = false;
                        this.alert.notif = false;
                        this.alert.message = response.data.message;
                        this.$Progress.finish(); 
                        this.$emit('refresh-users');
                    }else{
                        this.alert.success = false;
                        this.alert.fail = true;
                        this.alert.notif = false;
                        this.alert.message = response.data.message;
                        this.$Progress.fail();                            
                    };                    
                })
                .catch( error => {
                    this.alert.success = false;
                    this.alert.fail = true;
                    this.alert.notif = false;
                    this.alert.message = "Something went wrong, please try again!";
                    this.alert.errors = {};
                    this.$Progress.fail();  
                });
            },
        }
    }
</script>
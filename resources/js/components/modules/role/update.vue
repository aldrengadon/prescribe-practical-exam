<template>
    <div class="modal fade" id="update-role-modal" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="glyph-icon icon-save"></i> Update Role</h4>
                </div>
                <div class="modal-body row">
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
                    <div class="content-box-wrapper pad0T pad0B">
                        <div class="form-group" :class="{'has-error': errors.has('Role Name') }">
                            <label class="control-label">Role Name <i class="font-red">*</i></label>
                            <input type="text"
                                :disabled="alert.notif || alert.success"
                                class="form-control"
                                name="Role Name"
                                v-model="roleData.name"
                                data-vv-validate-on="none"
                                v-validate="'required'"
                                maxlength="128">
                            <span v-if="errors.has('Role Name')" class="font-red font-size-11">
                                {{errors.first('Role Name')}}
                            </span>
                        </div>
                    </div>
                    <div class="content-box-wrapper pad0T pad0B">
                        <div class="form-group" :class="{'has-error': errors.has('Role Code') }">
                            <label class="control-label">Role Code <i class="font-red">*</i></label>
                            <input type="text"
                                :disabled="alert.notif || alert.success"
                                class="form-control"
                                name="Role Code"
                                v-model="roleData.code"
                                data-vv-validate-on="none"
                                v-validate="'required'"
                                maxlength="128">
                            <span v-if="errors.has('Role Code')" class="font-red font-size-11">
                                {{errors.first('Role Code')}}
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="content-box-wrapper pad0T pad0B">
                        <transition name="fade">
                            <table class="table table-condensed tableLayout">
                                <thead>
                                    <tr class="font-size-12">
                                        <th>Modules</th>
                                        <th class="center-div">View</th>
                                        <th class="center-div">Add</th>
                                        <th class="center-div">Edit</th>
                                        <th class="center-div">Delete</th>
                                    </tr>
                                </thead>                                
                                <tbody style="background-color: rgb(251, 251, 251);">
                                    <tr v-for="m in modules" :key="m.id" class="font-size-13 tdWrap">
                                        <td>
                                            <label class="control-label pull-left" :for="m.label+m.id" style="font-size: 12px;">
                                                <input
                                                    :id="m.label+m.id"
                                                    type="checkbox"
                                                    v-model="m.is_selected"
                                                    :true-value="true"
                                                    :false-value="false">
                                                &nbsp;&nbsp;&nbsp;{{m.label}}
                                            </label>
                                        </td>
                                        <td class="center-div">
                                            <input
                                                :disabled="!m.is_selected"
                                                type="checkbox"
                                                v-model="m.view"
                                                :true-value="true"
                                                :false-value="false">
                                        </td>
                                        <td class="center-div">
                                            <input
                                                :disabled="!m.is_selected"
                                                type="checkbox"
                                                v-model="m.add"
                                                :true-value="true"
                                                :false-value="false">
                                        </td>
                                        <td class="center-div">
                                            <input
                                                :disabled="!m.is_selected"
                                                type="checkbox"
                                                v-model="m.edit"
                                                :true-value="true"
                                                :false-value="false">
                                        </td>
                                        <td class="center-div">
                                            <input
                                                :disabled="!m.is_selected"
                                                type="checkbox"
                                                v-model="m.delete"
                                                :true-value="true"
                                                :false-value="false">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </transition>
                    </div>
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
                            data-dismiss="modal"
                            v-on:click="resetForm()">
                            Okay&nbsp;&nbsp;
                            <i class="glyph-icon icon-check-circle"></i>                                
                        </button>
                        <button v-else
                            :disabled="alert.notif || alert.success"
                            type="button"
                            class="btn btn-block btn-success"
                            v-on:click="updateRole()">
                            Update Role&nbsp;&nbsp;
                            <i class="glyph-icon icon-check-circle"></i>                                
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VeeValidate from 'vee-validate';
    import VueProgressBar from 'vue-progressbar';
    import axios from 'axios';

    Vue.use(VeeValidate);
    Vue.use(VueProgressBar, {
        color: 'red',
        failedColor: 'red',
        height: '20px'
    });

    export default {
        props: [
            'roleData',
            'modules'
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
            resetForm(){
                this.$validator.reset();
                this.alert.success = false;
                this.alert.fail = false;
                this.alert.notif = false;
            },
            updateRole(){
                this.$Progress.start();
                this.alert.notif = true;
                this.alert.success = false;
                this.alert.fail = false;
                this.alert.message = "Updating Role!";
                var data = {
                    modules: this.modules,
                    role_id: this.roleData.id
                }
                axios.post('update-role', data)
                .then((response) => {
                    if(response.data.success === true){
                        this.alert.success = true;
                        this.alert.fail = false;
                        this.alert.notif = false;
                        this.alert.message = response.data.message;
                        this.$Progress.finish(); 
                    }                   
                })
                .catch( error => {
                    this.alert.success = false;
                    this.alert.fail = true;
                    this.alert.notif = false;
                    this.alert.message = "Something went wrong, please try again!";
                    this.alert.errors = {};
                    this.$Progress.fail();  
                });
            }
        },
        watch: {
            modules: {
                handler(val){
                    for(var i in this.modules)
                        if(this.modules[i].is_selected === false){
                            this.modules[i].view   = false;
                            this.modules[i].add    = false;
                            this.modules[i].edit   = false;
                            this.modules[i].delete = false;
                        }
                },
                deep: true
            }
        }
    }
</script>
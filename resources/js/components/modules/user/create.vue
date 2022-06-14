<template>
    <div class="modal fade" id="create-user-modal" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="glyph-icon icon-plus"></i> Create New User</h4>
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
                        <div class="form-group" :class="{'has-error': errors.has('Email') }">
                            <label class="control-label">Email <i class="font-red">*</i></label>
                            <input type="text"
                                :disabled="alert.notif || alert.success"
                                class="form-control"
                                name="Email"
                                v-model="user.email"
                                data-vv-validate-on="none"
                                v-validate="'required|email'"
                                maxlength="128">
                            <span v-if="errors.has('Email')" class="font-red font-size-11">
                                {{errors.first('Email')}}
                            </span>
                        </div>
                    </div>
                    <div class="content-box-wrapper pad0T pad0B">
                        <div class="form-group" :class="{'has-error': errors.has('First Name') }">
                            <label class="control-label">First Name <i class="font-red">*</i></label>
                            <input type="text"
                                :disabled="alert.notif || alert.success"
                                class="form-control"
                                name="First Name"
                                v-model="user.first_name"
                                data-vv-validate-on="none"
                                v-validate="'required'"
                                maxlength="128">
                            <span v-if="errors.has('First Name')" class="font-red font-size-11">
                                {{errors.first('First Name')}}
                            </span>
                        </div>
                    </div>
                    <div class="content-box-wrapper pad0T pad0B">
                        <div class="form-group" :class="{'has-error': errors.has('Last Name') }">
                            <label class="control-label">Last Name <i class="font-red">*</i></label>
                            <input type="text"
                                :disabled="alert.notif || alert.success"
                                class="form-control"
                                name="Last Name"
                                v-model="user.last_name"
                                data-vv-validate-on="none"
                                v-validate="'required'"
                                maxlength="128">
                            <span v-if="errors.has('Last Name')" class="font-red font-size-11">
                                {{errors.first('Last Name')}}
                            </span>
                        </div>
                    </div>
                    <div class="content-box-wrapper pad0T pad0B">
                        <div class="form-group" :class="{'has-error': errors.has('Role') }">
                            <label class="control-label">Role <i class="font-red">*</i></label>
                            <select class="form-control"
                                :disabled="alert.notif || alert.success"
                                name="Role"
                                v-validate="'required'"
                                data-vv-validate-on="none"
                                v-model="user.role_id">
                                <option v-for="roles in userRoles" :value="roles.id" :key="roles.id">
                                    {{roles.name}}
                                </option>
                            </select>
                            <span v-if="errors.has('Role')" class="font-red font-size-11">
                                {{errors.first('Role')}}
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="content-box-wrapper pad0T pad0B">
                        <button
                            :disabled="alert.notif || alert.success"
                            v-on:click="clickAttach('userCreateFiles')"
                            class="btn btn-sm btn-block btn-blue-alt">
                            <span v-if="!userFiles.length">Attach Image</span>
                            <span v-else>Attach New Image</span>
                            &nbsp;&nbsp;
                            <i class="glyph-icon icon-paperclip"></i>
                        </button>                                        
                        <input 
                            type="file"
                            id="userCreateFiles"
                            ref="userCreateFiles"
                            style="display: none" 
                            v-on:change="attachFiles($refs.userCreateFiles.files)"/>
                        <span v-if="imageIsRequired" class="font-red font-size-11">
                            Please attach Image!
                        </span>
                    </div>
                    <div class="content-box-wrapper pad0T pad0B">
                        <transition name="fade" v-if="userFiles.length">
                            <table class="table table-condensed tableLayout">
                                <thead>
                                    <tr class="font-size-12">
                                        <th>File Name</th>
                                        <th>Size</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>                                
                                <tbody style="background-color: rgb(251, 251, 251);">
                                    <tr v-for="file in userFiles" :key="file.id" class="font-size-13 tdWrap">
                                        <td>{{file.name}}</td>
                                        <td>{{fileSize(file.size)}}</td>
                                        <td>{{file.type}}</td>
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
                            v-on:click="resetForm()"
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
                            v-on:click="resetForm()">
                            Okay&nbsp;&nbsp;
                            <i class="glyph-icon icon-check-circle"></i>                                
                        </button>
                        <button v-else
                            :disabled="alert.notif || alert.success"
                            type="button"
                            class="btn btn-block btn-success"
                            v-on:click="validateUser()">
                            Save User&nbsp;&nbsp;
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
            'userRoles'
        ],
        data () {
            return {
                user: {},
                userFiles: [],
                alert: {
                    notif: false,
                    success: false,
                    fail: false,
                    message: "",
                    errors: {}
                },
                imageIsRequired: false
            }
        },
        methods:{
            createUser(){
                this.$Progress.start();
                this.alert.notif = true;
                this.alert.success = false;
                this.alert.fail = false;
                this.alert.message = "Creating User!";
                axios.post('create-user', this.user)
                .then((response) => {
                    if(response.data.success === true){
                        this.uploadImage(response.data.userId);
                    }else{
                        this.alert.success = false;
                        this.alert.fail = true;
                        this.alert.notif = false;
                        this.alert.message = response.data.message;
                        this.alert.errors = {};
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
            uploadImage(userId){
                this.$Progress.start();
                let formData = new FormData();                
                formData.append('userId', userId);
                for(var i in this.userFiles)
                    formData.append('userFiles['+i+']', this.userFiles[i]);

                axios.post('upload-file', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(
                    (response) => {
                        if(response.data.success === true){           
                            this.$Progress.finish();
                            this.alert.success = true;
                            this.alert.fail = false;
                            this.alert.notif = false;
                            this.alert.message = response.data.message;
                            this.$emit('refresh-users');
                        }else{      
                            this.alert.success = false;
                            this.alert.fail = true;
                            this.alert.notif = false;
                            this.alert.message = response.data.message;
                            this.alert.errors = {};
                            this.$Progress.fail();  
                        }
                    }, (error) => {
                        this.alert.success = false;
                        this.alert.fail = true;
                        this.alert.notif = false;
                        this.alert.message = "Something went wrong, please try again";
                    }
                );
            },
            validateUser(){
                this.$validator.validateAll().then((validate) => {
                    if(validate){
                        if(!this.userFiles.length)
                            this.imageIsRequired = true;
                        else{
                            this.imageIsRequired = false;
                            this.createUser();
                        }
                    }
                });
            },
            resetForm(){
                this.$validator.reset();
                this.user = {};
                this.userFiles = [];
                this.alert.success = false;
                this.alert.fail = false;
                this.alert.notif = false;
            },
            clickAttach(id){
                document.getElementById(id).click();
            },
            attachFiles(filesName){
                for(var i in filesName){
                    if(!this.getFile(this.userFiles, filesName[i].name) && filesName[i].size && this.fileIsImage(filesName[i].type)){
                        this.userFiles = [];
                        this.userFiles.push(filesName[i]);
                    }
                }
            },
            fileIsImage(fileType){
                if(fileType == 'image/png' || fileType == 'image/jpeg')
                    return true;

                return false;
            },
            getFile(tableName, fileName){
                return tableName.filter(function(file) {
                    return file.name == fileName;
                }).length;
            },
            fileSize(size){
				var i = Math.floor(Math.log(size) / Math.log(1024))
				return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
			},
        }
    }
</script>
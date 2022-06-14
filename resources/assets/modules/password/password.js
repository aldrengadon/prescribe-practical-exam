
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap.js')

// window.Vue = require('vue')
Vue.config.productionTip = false
// Vue.config.silent = true

import Vue from 'vue';
import axios from 'axios';
import VeeValidate from 'vee-validate';
import VueProgressBar from 'vue-progressbar';

Vue.use(VeeValidate);
Vue.use(VueProgressBar, { color: 'red', failedColor: 'red', height: '8px' });

VeeValidate.Validator.extend( 'verifyPassword', {
   getMessage: field => `The password must contain at least: 1 uppercase letter, 1 lowercase letter, 1 number, and one special character (E.g. ! @ # $ etc)`,
   validate: value => {
      var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()])(?=.{8,})");
      return strongRegex.test(value);
   }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.component('notification-fail', require('../../../js/components/notification/notificationFail.vue').default);
 Vue.component('notification-success', require('../../../js/components/notification/notificationSuccess.vue').default);
 Vue.component('notification-notice', require('../../../js/components/notification/notificationNotice.vue').default);

// custom header of axios
axios.defaults.headers['X-axios'] = true;

var app = new Vue({
   el: '#change-password-modal',
   name: 'ChangePassword',
   data () {
      return {
         newPassword: '',
         confirmPassword: '',

         alert: {
            notif: false,
            success: false,
            fail: false,
            message: "",
            errors: {}
         },

         showNewPassword: false,
         showConfirmNewPassword: false,

         changePasswordValidations: [
            "validateOldPassword"
         ],

        
      }
   },
   mounted: function () {

   },
   methods: {
      savePassword(){
         this.$validator.validateAll().then((validate) => {
            if(validate){
               this.$Progress.start();
               this.alert.notif = true;
               this.alert.success = false;
               this.alert.fail = false;
               this.alert.message = "Saving Password";
               axios.get('save-password/'+this.newPassword).then(
                  (response) => {
                     if(response.data.success === true){
                        this.alert.notif = false;
                        this.alert.success = true;
                        this.alert.fail = false;
                        this.alert.message = response.data.message;
                     }
                  }, (error) => {
                     this.$Progress.fail();
                     this.alert.notif = false;
                     this.alert.success = false;
                     this.alert.fail = true;
                     this.alert.message = "Something went wrong, please try again!";
                  }
               );
            }
         });
      },
   }
})

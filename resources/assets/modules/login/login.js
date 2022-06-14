
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue').default;

import axios from 'axios';
import VeeValidate from 'vee-validate';
import VueProgressBar from 'vue-progressbar';

Vue.component('notification-fail', require('../../../js/components/notification/notificationFail.vue').default);
Vue.component('notification-success', require('../../../js/components/notification/notificationSuccess.vue').default);
Vue.component('notification-notice', require('../../../js/components/notification/notificationNotice.vue').default);

Vue.use(VeeValidate);
Vue.use(VueProgressBar, {
    color: 'red',
    failedColor: 'red',
    height: '20px'
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// custom header of axios
// axios.defaults.headers['X-axios'] = true;

var app = new Vue({
    el: '#app',
    data () {
        return {
            loginDisabled: false,
            email: '',
            password: '',
            alert: {
                success: false,
                fail: false,
                message: "",
                errors: {}
            },
            loginFailedMessage: "",
            loginFailed: false

        }
    },
    created(){
        const urlParams = new URLSearchParams(window.location.search);
        var userStatus  = urlParams.get("status");
        if(userStatus !== null)
            if(userStatus == "sessionExpired")
                this.setSessionExpiredLoginNotification();
    },
    methods: {
        setSessionExpiredLoginNotification(){
            this.loginFailedMessage = "You were idle for too long. Session has expired.";
            this.loginFailed = true;
        },
        login(){
            this.loginFailed = false;
            this.alert.success = false;
            this.alert.fail = false;
            this.$validator.validateAll('login').then((validate) => {
                if(validate){
                    this.$Progress.start();
                    var data = {
                        email   : this.email,
                        password   : this.password,
                    };
                    this.loginDisabled = true;
                    axios.post('authenticate', data)
                    .then((response) => {
                        if(response.data.success === true){
                            this.$Progress.finish();
                            this.alert.success = true;
                            this.alert.fail = false;
                            this.alert.message = response.data.message;
                            window.location.href = 'welcome';
                        }else{
                            this.alert.success = false;
                            this.alert.fail = true;
                            this.alert.message = response.data.message;
                            this.alert.errors = {};
                            this.loginDisabled = false;
                            this.$Progress.fail();                            
                        };                    
                    })
                    .catch( error => {
                        this.alert.success = false;
                        this.alert.fail = true;
                        this.alert.message = "Something went wrong, please try again!";
                        this.alert.errors = {};
                        this.loginDisabled = false;
                        this.$Progress.fail();  
                    });
                }
            });            
        },
    },
})

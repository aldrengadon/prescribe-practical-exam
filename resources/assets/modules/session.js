Vue.config.productionTip = false

import Vue from 'vue';

const eventsHub = new Vue();
import IdleVue from 'idle-vue';
import axios from 'axios';
 
Vue.use(IdleVue, {
  eventEmitter: eventsHub,
  idleTime: sessionLifetime
});

var app = new Vue({
    el: '#session-timer',
    data () {
        return {
            isIdle: false,
            timerCountdown: 0
        }
    },
    onIdle(){
        this.isIdle = true;
        this.timerCountdown = 59; //1 minute countdown
        $("#session-timer-modal").modal("show");
    },
    onActive(){
        // this.isIdle = false;
        // $("#session-timer-modal").modal("hide");
    },
    methods:{
        continueSession(){
            this.isIdle = false;
            this.timerCountdown = 0;
            $("#session-timer-modal").modal("hide");
        },
        logout(){
            axios.get('logout').then(
                (response) => {                        
                    window.location.href = "login?status=sessionExpired";
                },(error) => {
                    window.location.href = "login?status=sessionExpired";
                }
            );
        },
    },
    watch:{
        timerCountdown(value){
            if(value > 0 && this.isIdle){
                setTimeout(function(){
                    this.timerCountdown--;
                }.bind(this), 1000);
            }

            if(this.isIdle && value === 0){
                window.onbeforeunload = null;
                // window.location.reload(1);
                this.logout();
            }
        }
    }
})
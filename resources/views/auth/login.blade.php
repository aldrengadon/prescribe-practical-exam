<html lang="en">
	<head>
        <title>Prescribe Digital Practical Exam</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <style media="screen">
            [v-cloak] {
                display: none;
            }
        </style>
	</head>

    <img src="{{ asset('images/blurred-bg/blurred-bg-5.jpg') }}" class="login-img wow fadeIn" alt="">
    <div class="center-vertical" id="app">
    <vue-progress-bar></vue-progress-bar>
        <div class="center-content row">
            <div class="col-md-4 clearfix center-margin">
                <div class="row">
                    <div class="col-md-12 mrg25T mrg25B">
                        {{ csrf_field() }}
                        <div class="content-box">
                            <h3 class="content-box-header content-box-header-alt bg-default">
                                <span class="icon-separator">
                                    <img src="{{ asset('images/prescribe-logo.png') }}" alt="" style="height: 30px; width: 30px;">
                                </span>
                                <span class="header-wrapper">
                                    Prescribe Practical Exam |
                                    <span class="font-yellow">{{ config('app.env') }}</span>
                                    <small>Use the form below to login to your account.</small>
                                </span>
                            </h3>
                            <div class="content-box-wrapper">
                            <transition name="fade">
                                <div
                                    v-if="loginFailed"
                                    class="alert alert-danger text-center"
                                    v-cloak>
                                    @{{ loginFailedMessage }}
                                </div>
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
                                <form class="mrg20B mrg10T" v-on:submit.prevent="login()"  data-vv-scope="login">
                                    <div class="form-group col-md-10 center-margin" :class="{'has-error': errors.has('login.Email')}">
                                        <div class="input-group">
                                            <input class="form-control" 
                                                v-model="email"
                                                :disabled="loginDisabled"
                                                @keydown.space.prevent
                                                type="text"
                                                placeholder="Enter your email"
                                                v-on:keyup.enter="login()"
                                                style="text-align: center;"
                                                name="Email"
                                                data-vv-validate-on="none"                                    
                                                v-validate="'required|email'">
                                            </input>
                                            <span class="input-group-addon bg-blue">
                                                <i class="glyph-icon icon-envelope-o"></i>
                                            </span>
                                        </div>
                                        <span v-if="errors.has('login.Email')" class="font-red font-size-11">
                                            @{{errors.first('login.Email')}}
                                        </span>
                                    </div>
                                    <div class="form-group col-md-10 center-margin" :class="{'has-error': errors.has('login.Password')}">
                                        <div class="input-group">
                                            <input class="form-control" v-model="password"
                                                :disabled="loginDisabled"
                                                @keydown.space.prevent
                                                type="password"
                                                placeholder="Enter your password"
                                                v-on:keyup.enter="login()"
                                                style="text-align: center;"
                                                name="Password"
                                                data-vv-validate-on="none"                                    
                                                v-validate="'required'">
                                            </input>
                                            <span class="input-group-addon bg-blue">
                                                <i class="glyph-icon icon-unlock-alt"></i>
                                            </span>
                                        </div>
                                        <span v-if="errors.has('login.Password')" class="font-red font-size-11">
                                            @{{errors.first('login.Password')}}
                                        </span>
                                    </div>
                                </form>
                                
                                <div class="col-md-10 center-margin mrg5B">
                                    <button 
                                        :disabled="loginDisabled"
                                        type="button"
                                        v-on:click="login()"
                                        class="btn btn-sm btn-blue-alt btn-block">
                                        Sign In
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
    </script>
    <script src="{{ asset('js/login.js') }}"></script>    
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="{{ asset('images/prescribe-logo.png') }}">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- page title -->
	<title>Prescribe Practical Exam</title>

	<!-- APP CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

	<!-- MAIN CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

	<script>
		var dateCreated = {!! json_encode($dateCreated) !!};
		var dateUpdated = {!! json_encode($dateUpdated) !!};
		var sessionLifetime = {!! json_encode($sessionLifetime) !!};
	</script>

</head>
<body>
<div id="sb-site" >
	<div id="page-wrapper">
		@include('layouts.header')
		@include('layouts.sidebar')
		<div id="page-content-wrapper">
			<div id="page-content">
				<div class="container" style="width: 1500px;" id="app">
					<vue-progress-bar></vue-progress-bar>
					@yield('content')
				</div>
			</div>
		</div>
	</div>	

	<div class="modal fade in" tabindex="-1" id="change-password-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<vue-progress-bar></vue-progress-bar>
		<div class="modal-dialog modal-md">
			<div id="modal" class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><i class="glyph-icon icon-edit"></i> Insert Password</h4>
					</div>
					<div class="modal-body" id="password">
						<div class="row">
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
							<div class="form-group col-md-12" :class="{'has-error': errors.has('New Password')}">
								<div class="col-md-12">
									<label class="control-label">New Password <i class="font-red">*</i></label>
									<div class="input-group">										
										<input
											:disabled="alert.notif || alert.success"
											ref="newPassword"
											:type="showNewPassword ? '' : 'password'"
											name="New Password"
											class="form-control"
											v-validate="'required|min:12|verifyPassword'"
											v-model="newPassword"
											@click.right.prevent @copy.prevent @paste.prevent>
										<span class="input-group-addon btn-info" v-on:click="showNewPassword = !showNewPassword">
											<i class="glyph-icon" :class="showNewPassword ? 'icon-eye-slash' : 'icon-eye'"></i>
										</span>
									</div>
									<span v-if="errors.has('New Password')" class="font-red font-size-11">
										@{{ errors.first('New Password') }}
									</span>
								</div>
							</div>
							<div class="form-group col-md-12" :class="{'has-error': errors.has('Password')}">
								<div class="col-md-12">
									<label class="control-label">Confirm New Password <i class="font-red">*</i></label>
									<div class="input-group">
										<input
											:disabled="alert.notif || alert.success"
											:type="showConfirmNewPassword ? '' : 'password'"
											name="Password"
											class="form-control"
											v-validate="'required|confirmed:newPassword|verifyPassword'"
											v-model="confirmPassword"
											@click.right.prevent @copy.prevent @paste.prevent>
										<span class="input-group-addon btn-info" v-on:click="showConfirmNewPassword = !showConfirmNewPassword">
											<i class="glyph-icon" :class="showConfirmNewPassword ? 'icon-eye-slash' : 'icon-eye'"></i>
										</span>
									</div>
									<span v-if="errors.has('Password')" class="font-red font-size-11">
										@{{ errors.first('Password') }}
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-3">
							<button
								v-if="!alert.success"
								:disabled="alert.notif"
								type="button"
								class="btn btn-block btn-success"
								v-on:click="savePassword()">
								Save&nbsp;&nbsp;&nbsp;
								<i class="glyph-icon icon-save"></i>
							</button>
							<button
								v-else
								type="button"
								class="btn btn-block btn-default"
								data-dismiss="modal">
								<i class="glyph-icon icon-times-circle"></i>
								&nbsp;&nbsp;&nbsp;Close
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SESSION EXPIRATION MODAL -->
	<div class="modal fade" id="session-timer-modal" role="dialog" data-backdrop="static">
		<div class="modal-dialog" id="session-timer">
			<div class="modal-content">
				<div class="modal-header no-border">
					<br>
				</div>
				<div class="modal-body mrg25A pad25A mrg0T pad0T">
					<div class="col-md-10 center-margin">
						<center>
							<h2>Are you still there?</h2>
							<br>
							<p class="font-size-14">
								If not, you will be logged out in:
							</p>
							<p class="font-size-23 font-bold">
								00 :
								@{{timerCountdown > 9 ?
									timerCountdown :
									'0'+timerCountdown
								}}
								<!-- @{{timerCountdown}} -->
							</p>
							<br>
							<br>
							<button
								v-on:click="continueSession()"
								class="btn btn-blue-alt btn-block">
								I'm still here
							</button>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- brighten the color of input,
    this is position here to overwrite the vendor libraries input css-->
	<style>
		.input-border-bright,
		textarea,
		.text-area,
		.input-sm,
		.chosen-select,
		.chosen-container {
			border: 1px solid #bbbbbb;
		}

		[v-cloak] {
			display: none;

		}
	</style>

	<!-- SESSION JS -->
	<script src="{{ asset('js/session.js') }}"></script>

	<!-- MAIN JS -->
	<script src="{{ asset('js/main.js') }}"></script>

	<!-- APP JS -->
	<script src="{{ asset('js/app.js') }}"></script>

	<!-- PASSWORD JS -->
	<script src="{{ asset('js/password.js') }}"></script>

	<script>
		if(dateCreated == dateUpdated){
			$( "#change-password-modal" ).modal( "show" );
            $( '#change-password-modal' ).appendTo( "body" );
		}
		window.Laravel = <?php echo json_encode([
				'csrfToken' => csrf_token(),
		]); ?>
	</script>
</div>
</body>
</html>

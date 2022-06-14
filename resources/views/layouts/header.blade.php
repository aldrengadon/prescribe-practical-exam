<div id="page-header" class="bg-gradient-8 font-inverse" style="">
	<div id="mobile-navigation">
		<button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button>
		<a href=" {{ url('welcome') }} " onclick="if (confirm('Do you want to proceed to Welcome?')){return true;}else{event.stopPropagation(); event.preventDefault();};" class="logo-content-small" title="Prescribe Practical Exam"></a>
	</div>
	<div id="header-logo" class="logo-bg">
		<a href=" {{ url('welcome') }} " class="logo-content-big" onclick="if (confirm('Do you want to proceed to Welcome?')){return true;}else{event.stopPropagation(); event.preventDefault();};" title="Prescribe Practical Exam"></a>
		<a href=" {{ url('welcome') }} " class="logo-content-small" onclick="if (confirm('Do you want to proceed to Welcome?')){return true;}else{event.stopPropagation(); event.preventDefault();};" title="Prescribe Practical Exam"></a>
		<a id="close-sidebar" href="#" title="Close sidebar">
			<i class="glyph-icon icon-angle-left"></i>
		</a>
	</div>
	<!-- #header-nav-left -->
	<div id="header-nav-left">
		<div class="user-account-btn dropdown">
			<a href="#" title="My Account" class="user-profile clearfix" data-toggle="dropdown">
				<img width="28" height="28" src="{{'storage/images/'.$imageName}}" alt="pic" style="object-fit: contain;">
				<span> {{ ucwords($userFullName) }} </span>
				<i class="glyph-icon icon-angle-down"></i>
			</a>
			<div class="dropdown-menu float-left">
				<div class="box-sm">
					<div class="login-box">
						<div class="user-img">
							<img style="object-fit: contain;" src="{{'storage/images/'.$imageName}}" alt="pic">
						</div>
						<div class="user-info">
                            <a>{{ ucwords($userFullName) }}</a></br>							
							<a>{{ strtoupper($userRole) }}</a></br>
						</div>
					</div>
					<ul class="row reset-ul mrg5B">
						&nbsp;
					</ul>
					<div class="pad5A button-pane button-pane-alt text-center">
						<a href="{{ url('logout') }}" onclick="if (confirm('Are you sure you want to logout?')){return true;}else{event.stopPropagation(); event.preventDefault();};" class="btn display-block font-normal btn-danger">
							<i class="glyph-icon icon-power-off"></i>
							Logout
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



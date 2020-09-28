<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<li class="sidebar-search">
				<div class="input-group custom-search-form"> <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn"> <button class="btn btn-primary" type="button"> <i class="fa fa-search"></i> </button> </span> </div>
				<!-- /input-group -->
			</li>
			<li>
				<a href="{{ route('dashboard.index') }}" class="{{ set_active('dashboard.index') }}"><i class="fa fa-dashboard mr-2"></i> Dashboard</a>
			</li>
			<li>
				<a href="{{ route('cek-koneksi.index') }}" class="{{ set_active('cek-koneksi.index') }}"><i class="fa fa-exchange mr-2"></i> Cek Koneksi Mesin</a>
			</li>
			{{-- <li>
				<a href="{{ route('upload-log-mesin.index') }}" class="{{ set_active('upload-log-mesin.index') }}"><i class="fa fa-grav mr-2"></i>Upload Log Mesin</a>
			</li>
			<li>
				<a href="{{ route('upload-log-user.index') }}" class="{{ set_active('upload-log-user.index') }}"><i class="fa fa-users mr-2"></i>Upload Log User</a>
			</li>
			<li>
				<a href="{{ route('register-mesin.index') }}" class="{{ set_active('register-mesin.index') }}"><i class="fa fa-microchip mr-2"></i>Register Mesin</a>
			</li> --}}
		</ul>
	</div>
</div>
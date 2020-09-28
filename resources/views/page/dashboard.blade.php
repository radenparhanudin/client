@extends('app')
@section('container')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Dashboard</h1>
		</div>
	</div>
	<div class="row">
		@if (!session()->get('token'))
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading font-weight-bold"> <i class="fa fa-info fa-fw"></i>Form Login</div>
				@if (Session::has('err_msg'))
					<h3 class="text-danger text-center">{{ Session::get('err_msg') }}</h3>
				@endif
				<form action="{{ route('dashboard.store') }}" method="POST">
					{{ csrf_field() }}
					<div class="panel-body">
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="username" class="form-control" placeholder="Username" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="text" name="password" class="form-control" placeholder="Password" required>
						</div>
					</div>
					<div class="panel-footer">
						<button type="submit" class="btn btn-danger">Login</button>
					</div>
				</form>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		@endif
		<div class="col-lg-8">
			@if (Session::has('scs_msg'))
				<h3 class="text-info text-center">{{ Session::get('scs_msg') }}</h3>
			@endif
			<div class="panel panel-default">
				<div class="panel-heading font-weight-bold"> <i class="fa fa-info fa-fw"></i>Selamat Datang Pengguna {{ config('app.name') }}!</div>
				<div class="panel-body">
					<p>
						Jika anda mengalami kendala silahkan hubungi : <strong>WA / Telegram : 082 342 788 059</strong>
					</p>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
</div>
@endsection
@extends('app')
@section('container')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Register Mesin</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading font-weight-bold"> <i class="fa fa-exchange mr-2"></i>Cek Koneksi</div>
				<form id="formRegisterMesin" method="POST" action="{{ route('register-mesin.store') }}">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>IP Mesin Finger Print (<small class="text-danger">Ketikkan IP Address Finger Print yang benar!</small>)</label>
									<input name="ip" id="ip" class="form-control" placeholder="192.168.1.201">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Nama Mesin</label>
									<input name="nama" id="nama" class="form-control" placeholder="192.168.1.201">
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<button type="submit" class="btn btn-danger">Get Info Mesin</button>
						<button type="reset" class="btn btn-warning">Clear IP Address</button>
					</div>
				</form>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading font-weight-bold"> <i class="fa fa-exchange mr-2"></i>Mesin Register</div>
				<div class="panel-body table-responsive">
					<table class="table table-striped" id="tableMesinRegister">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>IP Address</th>
								<th>Nama Mesin</th>
								<th>SN</th>
								<th>Vendor</th>
								<th>Platform</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('script')
	<script>
		$(document).ready(function() {
			const Toast = Swal.mixin({
		        toast: true,
		        position: 'middle-center',
		        showConfirmButton: false,
		        timer: 100000
		    });

			$('#formRegisterMesin').submit(function (event) {
		        event.preventDefault();
		        action = $('#formRegisterMesin').attr('action');
		        method = $('#formRegisterMesin').attr('method');
		        data = $('#formRegisterMesin').serialize();

		        $('#formRegisterMesin').find('.help-block').remove();
		        $('#formRegisterMesin').find('.form-group').removeClass('has-error');

		        $.ajax({
		            url: action,
		            type: method,
		            data: data,
		            beforeSend: function () {
		                Swal.fire({
		                    html: 'Sedang memproses permintaan ... .!',
		                    onBeforeOpen: () => {
		                        Swal.showLoading()
		                    }
		                })
		            },
		            success: function (response) {
		                if (response.success) {
		                    Toast.fire({
		                        type: 'success',
		                        title: response.message
		                    })

		                    $.each(response.data, function(index, val) {
		                    	$('#' + index).html(val)
		                    });
		                }
		                if (response.errors) {
		                    Toast.fire({
		                        type: 'error',
		                        title: response.message
		                    })
		                }
		            },
		            error: function (xhr) {
		                var res = xhr.responseJSON;
		                if ($.isEmptyObject(res) == false) {
		                    Toast.fire({
		                        type: 'error',
		                        title: res.message
		                    })
		                    $.each(res.errors, function (key, value) {
		                        $('#' + key)
		                            .closest('.form-group')
		                            .addClass('has-error')
		                            .append('<span class="help-block">' + value + '</span>');
		                    });
		                }
		            }
		        })
		    });

		    var tableMesinRegister = $('#tableMesinRegister').DataTable({
                processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('register-mesin.data') }}"
				},
				columns: [
					{data: 'DT_RowIndex', name: 'id', className: 'w-5 text-center'},
					{data: 'nama', name: 'nama', className: 'text-nowrap' },
					{data: 'ip', name: 'ip', className: 'text-nowrap' },
					{data: 'device_name', name: 'device_name', className: 'text-nowrap' },
					{data: 'serial_number', name: 'serial_number', className: 'text-nowrap' },
					{data: 'oem_vendor', name: 'oem_vendor', className: 'text-nowrap' },
					{data: 'platform', name: 'platform', className: 'text-nowrap' },
					{data: 'action', name: 'action', className: 'w-15 text-center text-nowrap'}, 
				],
				"initComplete": function(settings, json) {
					$('#tableMesinRegister_filter input').unbind();
					$('#tableMesinRegister_filter input').bind('keyup', function(e) {
						if (this.value == "" || e.keyCode == 13) {
							$('#tableMesinRegister').DataTable().search(this.value).draw();
						}
					});
				},
            });
		});
	</script>
@endpush
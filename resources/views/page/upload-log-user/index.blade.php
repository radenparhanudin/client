@extends('app')
@section('container')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Upload Log User</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading font-weight-bold"> <i class="fa fa-exchange mr-2"></i>Cek Koneksi</div>
				<form id="formUploadLog" method="POST" action="{{ route('upload-log-user.store') }}">
					<div class="panel-body">
						<div class="form-group">
							<label>IP Mesin Finger Print</label>
							<input name="ip" id="ip" class="form-control" placeholder="192.168.1.201">
							<p class="help-block">Ketikkan IP Address Finger Print yang benar!</p>
						</div>
					</div>
					<div class="panel-footer">
						<button type="submit" class="btn btn-danger">Cek Koneksi</button>
						<button type="reset" class="btn btn-warning">Clear IP Address</button>
					</div>
				</form>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
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
		        timer: 3000
		    });

			$('#formUploadLog').submit(function (event) {
		        event.preventDefault();
		        action = $('#formUploadLog').attr('action');
		        method = $('#formUploadLog').attr('method');
		        data = $('#formUploadLog').serialize();

		        $('#formUploadLog').find('.help-block').remove();
		        $('#formUploadLog').find('.form-group').removeClass('has-error');

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
		});
	</script>
@endpush
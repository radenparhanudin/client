@extends('app')
@section('container')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Cek Koneksi Mesin</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading font-weight-bold"> <i class="fa fa-exchange mr-2"></i>Cek Koneksi</div>
				<form id="formCekKoneksi" method="POST" action="{{ route('cek-koneksi.store') }}">
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
			<div class="panel panel-default">
				<div class="panel-heading font-weight-bold"> <i class="fa fa-exchange mr-2"></i>Result Koneksi</div>
				<div class="panel-body">
					<table class="table table-striped w-100">
						@php
							$data = array(
								'device_name'      => "Nama Mesin", 
								'serial_number'    => "Serial Number", 
								'manufacture_time' => "Manufactur", 
								'mac_address'      => "Mac Address", 
								'platform'         => "Platform", 
								'oem_vendor'       => "OEM Vendor", 
								'firmware_version' => "Firmware Version", 
					        );
						@endphp
						<tbody>
							@foreach ($data as $key => $value)
							<tr>
								<td class="font-weight-bold text-nowrap">{{ $value }}</td>
								<td width="2px">:</td>
								<td id="{{ $key }}"></td>
							</tr>
							@endforeach
					  </tbody>
					</table>
				</div>
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

			$('#formCekKoneksi').submit(function (event) {
		        event.preventDefault();
		        action = $('#formCekKoneksi').attr('action');
		        method = $('#formCekKoneksi').attr('method');
		        data = $('#formCekKoneksi').serialize();

		        $('#formCekKoneksi').find('.help-block').remove();
		        $('#formCekKoneksi').find('.form-group').removeClass('has-error');

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
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'middle-center',
        showConfirmButton: false,
        timer: 3000
    });

    // $.extend(true, $.fn.dataTable.defaults, {
    //     language: {
    //         "decimal": "",
    //         "emptyTable": "Tidak ada data tersedia",
    //         "info": "Menampilkan  _START_ sampai _END_ dari <strong>_TOTAL_</strong> data",
    //         "infoEmpty": "Menampilkan  0 sampai 0 dari <strong>0</strong> data",
    //         "infoFiltered": "(Tampilkan _MAX_ data)",
    //         "infoPostFix": "",
    //         "thousands": ",",
    //         "lengthMenu": "Tampilkan _MENU_ data",
    //         "loadingRecords": "Sedang memuat...",
    //         "processing": "Sedang proses...",
    //         "search": "Cari Data",
    //         "searchPlaceholder": "Kata kunci pencarian",
    //         "zeroRecords": "Tidak ada data yang ditemukan",
    //         "paginate": {
    //             "first": "Pertama",
    //             "last": "Terakhir",
    //             "next": "Selanjutnya",
    //             "previous": "Sebelumnya"
    //         }
    //     },
    //     dom: "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
    // });

    toastr.options = {
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "showDuration": "300",
        "hideDuration": "500",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $('.select2').select2();

    $('.select2-allowClear').select2({
        allowClear: true
    });

    var
        delay             = 2000,
        modalDefault      = $('#modalDefault'),
        modalDefaultTitle = $('#modalDefault .modal-title'),
        modalImport       = $('#modalImport'),
        
        dataTableDefault  = $('#dataTableDefault'),
        
        formDefault       = $('#formDefault')
        formImport        = $('#formImport');


    $('body').on('click', '.btn-add', function (event) {
        event.preventDefault();
        modalDefaultTitle.text($(this).attr('title'));
        modalDefault.modal('show');
    });

    formDefault.submit(function (event) {
        event.preventDefault();
        action = formDefault.attr('action');
        method = formDefault.attr('method');
        data = formDefault.serialize();

        formDefault.find('.help-block').remove();
        formDefault.find('.form-group').removeClass('has-error');

        $.ajax({
            url: action,
            type: method,
            data: data,
            beforeSend: function () {
                Swal.fire({
                    title: 'Mohon Menunggu ... .!',
                    html: 'Sedang memverifikasi data anda ... .',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })
            },
            success: function (response) {
                Swal.close()
                if (response.success) {
                    Toast.fire({
                        type: 'success',
                        title: response.message
                    })
                    modalDefault.modal("hide");
                    resetForm()
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

    dataTableDefault.on('click', '.btn-delete', function (event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan lagi!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak!',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'DELETE',
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Mohon Menunggu ... .!',
                            html: 'Sedang menghapus data dari database ... .!',
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            }
                        })
                    },
                    success:function (response) {
                        Swal.close()
                        if (response.success) {
                            Toast.fire({
                                type: 'success',
                                title: response.message
                            })
                            reload_datatable()
                        }
                        if (response.errors) {
                            Toast.fire({
                                type: 'error',
                                title: response.message
                            })
                        }
                    }
                })
            }
        })
    });

    formImport.submit(function (event) {
        event.preventDefault()
        action = formImport.attr('action');
        method = formImport.attr('method');
        data = new FormData(formImport[0]);

        formImport.find('.help-block').remove();
        formImport.find('.form-group').removeClass('has-error');

        $.ajax({
            url: action,
            type: method,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                Swal.fire({
                    title: 'Mohon Menunggu ... .!',
                    html: 'Proses Import data sedang berjalan ... .',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })
            },
            success: function (response) {
                if (response.success) {
                    Swal.close()
                    Toast.fire({
                        type: 'success',
                        title: response.message
                    })
                    reload_datatable()
                    modalImport.modal("hide");
                }

                if (response.errors) {
                    Swal.close()
                    Swal.fire({
                        icon: 'error',
                        title: response.message
                    })
                }
            },
            error: function (xhr) {
                var res = xhr.responseJSON;
                Swal.close()
                if (res.errors == null) {
                    Toast.fire({
                        type: 'error',
                        title: res.message
                    })
                }
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key, value) {
                        $('#' + key)
                            .closest('.form-group')
                            .addClass('has-error')
                            .append('<span class="help-block">' + value + '</span>');
                    });
                }
            }
        });
    });

    modalDefault.on('hidden.bs.modal', function () {
        resetForm()
        reload_datatable()
    });

    function resetForm() {
        formDefault.trigger('reset')
        $('.select2').val(null).trigger('change')
        $('.select2-search3').val(null).trigger('change')
        $('.select2-search5').val(null).trigger('change')
        $('.select2-allowClear').val(null).trigger('change')

        formDefault.find('.help-block').remove();
        formDefault.find('.form-group').removeClass('has-error');
    }

    function reload_datatable() {
        $('#dataTableDefault').DataTable().ajax.reload(null, false);
    }

});

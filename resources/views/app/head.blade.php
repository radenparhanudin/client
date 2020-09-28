<head>
   <meta charset="utf-8">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
   <meta name="{{ config('app.name') }}" content="yes">
   <meta name="{{ config('app.name') }}" content="black">
   <meta content="{{ config('app.name') }} by Raden Parhanudin" name="description" />
   <meta content="Raden Parhanudin" name="author" />
   <title>{{ config('app.name') }}</title>
   <!-- Bootstrap Core CSS -->
   <link href="{{ asset('public/startmin') }}/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('public/startmin/css/bs4.css') }}">
   <!-- MetisMenu CSS -->
   <link href="{{ asset('public/startmin') }}/css/metisMenu.min.css" rel="stylesheet">
   <!-- Timeline CSS -->
   <link href="{{ asset('public/startmin') }}/css/timeline.css" rel="stylesheet">
   <!-- Custom CSS -->
   <link href="{{ asset('public/startmin') }}/css/startmin.css" rel="stylesheet">
   <!-- Morris Charts CSS -->
   <link href="{{ asset('public/startmin') }}/css/morris.css" rel="stylesheet">
   <!-- Custom Fonts -->
   <link href="{{ asset('public/startmin') }}/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   <!-- DataTables CSS -->
     <link href="{{ asset('public/startmin') }}/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
     <!-- DataTables Responsive CSS -->
     <link href="{{ asset('public/startmin') }}/css/dataTables/dataTables.responsive.css" rel="stylesheet">
        
   <link rel="stylesheet" href="{{ asset('public/startmin/plugins/select2/dist/css/select2.min.css') }}">
   <link rel="stylesheet" href="{{ asset('public/startmin/plugins/toastr/toastr.min.css') }}">
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --> <!-- WARNING: Respond.js doesn't work if you view the page via file:// --> <!--[if lt IE 9]>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script> <![endif]-->
   <style>
      .swal2-popup {
         font-size: 1.3rem !important;
     }
   </style>
   <base href="{{ url('/') }}">
</head>
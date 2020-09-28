<!DOCTYPE html>
<html lang="en">
   @include('app.head')
   <body>
      <div id="wrapper">
         <!-- Navigation -->
         <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            @include('app.navbar')
            <!-- /.navbar-top-links -->
            @include('app.sidebar')
         </nav>
         <div id="page-wrapper">
            @yield('container')
            <!-- /.container-fluid -->
         </div>
         <!-- /#page-wrapper -->
      </div>
      @include('app.foot')
   </body>
</html>
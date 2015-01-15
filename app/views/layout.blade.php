<!DOCTYPE html>
<html lang="en">
    @include('head')
  <body>
    <div class="container">
       @include('top_nav')
	   @yield('content')
    </div><!-- /.container -->
       @include('footer')
	   @include('footer_js')
  </body>
</html>

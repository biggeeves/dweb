<!DOCTYPE html>
<html lang="en">
    @include('head')
  <body>
    <div class="container">
       @include('top_nav')
	   @yield('content')
       @include('footer')
    </div><!-- /.container -->
	   @include('footer_js')
  </body>
</html>

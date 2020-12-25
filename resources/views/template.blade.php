<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Siswaku</title>
{{-- Memanggil Bootstrap
  Komentar ini tidak akan ditampilkan di browser --}}
<link rel="stylesheet" href="{{ asset('bootstrap_3_3_6/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('../../../../css/style.css') }}">
</head>

<body>

  <div class="container">
  @include('navbar')
  @yield('main')
  </div>

  @yield('footer')

<script src="{{ asset('js/jquery_2_2_1.min.js') }}"></script>
<script src="{{ asset('bootstrap_3_3_6/js/bootstrap.min.js') }}"></script>
</body>
</html>
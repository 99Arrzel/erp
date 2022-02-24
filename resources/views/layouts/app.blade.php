<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ErpTruco</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    @yield('content')
</body>
<script src="{{ asset('js/app.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('datatables/datatables.css') }}" />
<script type="text/javascript" src="{{ asset('datatables/datatables.js') }}" defer></script>
<script src="{{ asset('dayjs/dayjs.min.js') }}"></script>
@yield('scripts')

</html>

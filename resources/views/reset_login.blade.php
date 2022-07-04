<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.">
    <title>LOGIN RESET | Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.</title>
</head>
@include('components/header')
<body class="bg-light">
<div class="container"   style="min-height: 500px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">VOA+ Login</h3>
                </div>
                <div class="card-body">

                    <div class="alert alert-warning" role="alert">
                        Logout all sessions
                    </div>
                        <a href="{{route('reset_login_state')}}" type="button" class="btn btn-primary col-12">Logout</a>

                </div>
            </div>
        </div>
    </div>
</div>
@include('components/footer')
</body>
</html>

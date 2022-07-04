<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.">
    <title>MY ACCOUNT | Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.</title>
</head>
@include('components/header')
    <body class="">
        <?php $user = session()->get('auth_user'); ?>
        @include('components/navbar')
        @if(isset($_COOKIE['browser_token']))
            <script type="text/javascript">
                window.location = "{{ url('/logged_stream') }}";//here double curly bracket
            </script>
        @elseif($user->stream_token == null || $user->stream_token == 'expired')

            <div class="container  mt-3 p-4"  style="min-height: 400px !important;">
                <div class="row justify-content-evenly bg-dark pt-3 pb-4 p-3" style="--bs-bg-opacity: .5;border-radius: 15px;">
                        <div class="text-center h2 text-white mb-4">CHOOSE A PACKAGE</div>
                        @isset($validation_period_error)
                        <div class="text-danger">
                            {{ $validation_period_error }}
                        </div>
                        @enderror
                        @isset($package_error)
                            <div class="text-danger">
                                {{ $package_error }}
                            </div>
                        @enderror
                        @if(session()->has('expire'))
                            <div class="alert alert-warning " role="alert">
                                {{ session()->get('expire') }}
                            </div>
                        @endif
                       @foreach($packages as $package)
                                <div class="{{ $package->style_class }} col-lg-3 mt-3 mt-lg-0 rounded text-center pt-2">
                                    <h4>{{ $package->name }}</h4>
                                    <p>Number of Devices: <b>{{ $package->device_count }}</b></p>
                                    <p>For 1 Month: <b>{{ '$'.$package->one_month_price }}</b></p>
                                    <p>For 1 Year: <b>{{ '$'.$package->one_year_price }}</b></p>
                                    <form method="post" action="@if($package->status == 'active'){{route('package')}}@endif">
                                        @csrf
                                        <input type="hidden" name="package" value="{{ $package->name }}">
                                        <input type="hidden" name="package_id" value="{{ $package->package_id }}">
                                        <select class="form-select" aria-label="period" required="required" name="validation_period" onchange="showTotal('basic',this.value)" @if($package->status == 'deactive')disabled="disabled" @endif>
                                            <option value="" selected="selected" disabled="disabled"> CHOOSE PERIOD </option>
                                            <option value="1-month">1 Month | {{ '$'.$package->one_month_price }}</option>
                                            <option value="1-year">1 Year | {{ '$'.$package->one_year_price }}</option>
                                        </select>
                                        <input type="submit" name="summit" value="@if($package->status == 'active')BUY NOW @else COMING SOON... @endif " class="btn btn-primary col-12 mb-2 mt-3" id="basic_submit" @if($package->status == 'deactive')disabled="disabled" @endif>
                                    </form>

                                </div>
                        @endforeach
                        </div>
                        </div>
            <!--<div id="toast" style="display: none; top: 10px; right: 10px; " role="alert" class="d-inline-flex rounded p-2 align-items-center text-white bg-primary border-0 position-fixed">-->
            <!--    <h6 id="toastmsg"></h6>-->
            <!--    <button type="button" class="d-inline-flex btn-close btn-close-white me-2 m-auto"  aria-label="Close" onclick="deactivePackageMSGclose()"></button>-->
            <!--</div>-->
            <!--<script>-->
            <!--    function deactivePackageMSG(package) {-->
            <!--        document.getElementById('toastmsg').innerText = package + ' Package will be coming soon...!';-->
            <!--        document.getElementById('toast').style.display = 'block';-->
            <!--    }-->
            <!--    function deactivePackageMSGclose() {-->
            <!--        document.getElementById('toastmsg').innerText = '';-->
            <!--        document.getElementById('toast').style.display = 'none';-->
            <!--    }-->
            <!--</script>-->
                        
        @else
            <div class="container mt-3"  style="min-height: 500px !important;">
                <div class="row justify-content-evenly  pt-3 pb-4 p-3" style="--bs-bg-opacity: .5;border-radius: 15px;">

                    <div class="col-lg-6">
                        <div class="card shadow-lg border-0 rounded-lg bg-dark" style="--bs-bg-opacity: .5;">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-1 text-white">Stream key</h3>
                            </div>

                            <div class="card-body">
                                @if(session()->has('payment_status'))
                                    <div class="alert alert-danger " role="alert">
                                        {{ session()->get('payment_status') }}
                                    </div>
                                @endif
                                @if(session()->has('mail_status_message'))
                                    @if(session()->get('mail_status') == 0)
                                    <div class="alert alert-success " role="alert">
                                        {{ session()->get('mail_status_message') }}
                                    </div>
                                    @elseif(session()->get('mail_status') == 1)
                                        <div class="alert alert-danger " role="alert">
                                            {{ session()->get('mail_status_message') }}
                                        </div>
                                    @endif
                                @endif
                                @if(session()->has('expire'))
                                <div class="alert alert-warning " role="alert">
                                    {{ session()->get('expire') }} | <a href="#" class="text-white ">Renew Plan</a>
                                </div>
                                @endif
                                @if(session()->has('deactivate'))
                                <div class="alert alert-warning " role="alert">
                                    {{ session()->get('deactivate') }}
                                </div>
                                @endif
                                @if(session()->has('system_error'))
                                <div class="alert alert-warning " role="alert">
                                    {{ session()->get('system_error') }} | <a href="{{ route('reset_login_state') }}" class="text-white">logout All device</a>
                                </div>
                                @endif
                                @if(session()->has('verified'))
                                    <div class="alert alert-success " role="alert">
                                        {{ session()->get('verified') }}
                                    </div>
                                @endif
                                @if(session()->has('key_error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session()->get('key_error') }}
                                    </div>
                                @endif
                                @if(session()->has('token_full_error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session()->get('token_full_error') }}
                                    </div>
                                @endif
                                <form method="post" action="{{route('validate_token')}}">
                                    @csrf
                                    <div class="mb-1">
                                        <input type="text" class="form-control mb-3" name="stream_key" minlength="5" placeholder="Stream Key">
                                        <button type="submit" class="btn btn-warning col-12">Submit & Watch Live</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        @endif
        
         @include('components/footer')
    </body>
<script>
    function showTotal(package,value) {
        switch (package) {
            case 'basic':
                if (value == 'month'){
                    document.getElementById('basic_submit').value = 'BUY NOW | $0.99';
                }else if(value == 'year'){
                    document.getElementById('basic_submit').value = 'BUY NOW | $9.99';
                }else{
                    document.getElementById('basic_submit').value = 'BUY NOW';
                }
                break;
            case 'standard':
                if (value == 'month'){
                    document.getElementById('standard_submit').value = 'BUY NOW | $1.99';
                }else if(value == 'year'){
                    document.getElementById('standard_submit').value = 'BUY NOW | $19.99';
                }else{
                    document.getElementById('standard_submit').value = 'BUY NOW';
                }
                break;
            case 'premium':
                if (value == 'month'){
                    document.getElementById('premium_submit').value = 'BUY NOW | $9.99';
                }else if(value == 'year'){
                    document.getElementById('premium_submit').value = 'BUY NOW | $99.99';
                }else{
                    document.getElementById('premium_submit').value = 'BUY NOW';
                }
                break;
        }
    }
</script>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.">
    <title>FORGOT PASSWORD | Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.</title>
</head>
@include('components/header')
<body>
@include('components/navbar')
{{--<script>--}}
{{--    setTimeout(active_resent, 10000);--}}
{{--    function active_resent(){--}}

{{--        let resent= document.getElementById('resent');--}}
{{--        if(resent.disabled == true){--}}
{{--            resent.disabled = false;--}}
{{--        }--}}
{{--    }--}}
{{--    function resent(){--}}
{{--        let resent= document.getElementById('resent');--}}
{{--        if(resent.disabled == false){--}}
{{--            resent.disabled = true;--}}
{{--            window.location = "{{ url('/resent_verification') }}";--}}
{{--            //setTimeout(active_resent, 10000);--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}
<div class="container"  style="min-height: 500px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark" style="--bs-bg-opacity: .5;">
                <div class="card-header justify-content-center">
                    <h3 class="text-center font-weight-light my-1 text-white">Password Reset</h3>
                </div>
                <div class="card-body">
                    @if(session()->has('not_available'))
                        <div class="alert alert-danger " role="alert">
                            {{ session()->get('not_available')  }}
                        </div>
                    @endif
                    @if(session()->has('mail_status_message'))
                        <div class="alert alert-danger " role="alert">
                            {{ session()->get('mail_status_message')  }}
                        </div>
                    @endif
                    @if(session()->has('reset_timeout'))
                    <div class="alert alert-danger " role="alert">
                        {{ session()->get('reset_timeout')  }}
                    </div>
                    @endif
                    <form method="post" action="{{ route('forgot_mail') }}">
                        @csrf
                        <div class="mb-1">
                            <input type="email" class="form-control mb-3" name="email" placeholder="Enter your Email address" required>
                            <button type="submit" class="btn btn-warning col-12">Send Reset Code</button>
                        </div>
                    </form>
{{--                    <button class="btn btn-outline-light col-12 mt-2  float-left " id="resent" onclick="resent()" disabled="true">Resent Verification Code to Email</button>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@include('components/footer')
</body>
</html>

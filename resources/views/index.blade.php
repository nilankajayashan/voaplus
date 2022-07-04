<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.">
    <title>Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network <br> The Largest Media Network in Sri Lanka.</title>
</head>
@include('components/header')
<body>
@include('components/navbar')
<div class="container p-4">
    <div class="row justify-content-center mt-5">

            <div class="card col-12 shadow-lg border-0 rounded-lg mt-0 bg-dark pt-3 pb-3  m-0 text-center" style="--bs-bg-opacity: .5;">
                <h3 class="text-light">The official LIVE STREAMING & VOD platform of Voice of Asia Network <br> The Largest Media Network in Sri Lanka.</h3>
                <form action="{{ route('change-channel') }}" method="post" id="change_channel" class="">
                    @csrf
                    <input type="hidden" name="channel" value="siyatha_tv" id="channel">
                    <div class="row col-lg-12 justify-content-center">
                        <div class=" col-lg-3 mt-3">
                            <img src="{{ asset('/public/assets/siyatha_logo.jpeg') }}" alt="SIYATHA TV" class="w-100" style="border-radius: 25px !important;"  onclick="changeChannel('siyatha_tv')" role="button">
                            <button class="btn btn-warning mt-3 col-12" onclick="changeChannel('siyatha_tv')">WATCH NOW</button>
                        </div>

                        <div class=" col-lg-3 mt-3">
                            <img src="{{ asset('/public/assets/star_logo.jpeg') }}" alt="STAR TV" class="w-100" style="border-radius: 25px !important;">
                            <button class="btn btn-warning mt-3 col-12" disabled="disabled">COMMING SOON...</button>
                        </div>
                    </div>
                </form>
            </div>
        <script>
            function changeChannel(value){
                document.getElementById('channel').value = value;
                document.getElementById('change_channel').submit();

            }
        </script>
    </div>
</div>
{{--packages--}}
@if((isset($packages)) && ((!session()->has('auth_user')) || (session()->get('auth_user')->stream_token == null || session()->get('auth_user')->stream_token == 'expired')))

    <div class="container  p-4" >
        <div class="row justify-content-evenly bg-dark pt-3 p-3" style="--bs-bg-opacity: .5;border-radius: 15px;">
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
                        <div class="{{ $package->style_class }} col-lg-3 mt-3 mt-lg-0 rounded text-center pt-2" @if($package->status == 'deactive')onclick="deactivePackageMSG('{{$package->name}}')"@endif>
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

@endif

<script>
    function deactivePackageMSG(package) {
        alert(package + ' Package will be coming soon...!');
    }
</script>
{{--end packages--}}
{{--fandq--}}

    <div class="container text-center text-white mb-5 mt-3">
        <div class="card text-start shadow-lg border-0 rounded-lg bg-dark p-3">
            <h3>FAQ - Frequently Asked Questions</h3>
            <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            How to Watch Siyatha TV?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Please visit the
                            <a href="{{ route('how-to-watch') }}" class="text-dark text-decoration-none" target="_blank" style="font-weight: bold !important;"> How to Watch page </a>
                            for a detailed description
                        </div>
                    </div>
                </div>
                <br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            How many devices can stream at one time?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Basic stream subscription (01 Device)<br>
                            Standard stream subscription (03 Devices)<br>
                            Premium stream subscription (10 Devices)
                        </div>
                    </div>
                </div>
                <br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Can I share my Login?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Please note that the number of devices you can access the stream at a given time depends on the subscription plan you have purchased. If you login to extra devices, the sessions logged into from other devices will automatically stop streaming.
                        </div>
                    </div>
                </div>
<br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                            Compatible Devices?
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            PC, Laptop Mac, iOS, Android, iPad, Amazon Fire tablets, Windows 10 and 11  and android tablets. More details on How to watch page.
                        </div>
                    </div>
                </div>
<br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                            Price per month?
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Basic stream subscription ($0.99 per month for VOA+ Channels (Siyatha TV)<br>
                            Standard stream subscription ($1.99 per month for VOA+ Channels (Siyatha TV)<br>
                            Premium stream subscription ($9.99 per month for VOA+ Channels (Siyatha TV) [COMING SOON]
                        </div>
                    </div>
                </div>
<br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                            Price per year?
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Basic stream subscription ($9.99 VOA+ Channels (Siyatha TV)<br>
                            Standard stream subscription ($19.99 VOA+ Channels (Siyatha TV)<br>
                            Premium stream subscription ($99.99 VOA+ Channels (Siyatha TV) [COMING SOON]
                        </div>
                    </div>
                </div>
<br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                            Resolutions available?
                        </button>
                    </h2>
                    <div id="flush-collapseSeven" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Basic stream subscription (480p)<br>
                            Standard stream subscription (480p)<br>
                            Premium stream subscription (1080p FULL HD)
                        </div>
                    </div>
                </div>
<br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                            Free trial?
                        </button>
                    </h2>
                    <div id="flush-collapseEight" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Currently we do not offer a free streaming service.
                        </div>
                    </div>
                </div>
<br>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingNine">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
                            What happens when the subscription ends?
                        </button>
                    </h2>
                    <div id="flush-collapseNine" class="accordion-collapse collapse text-dark" aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            After your subscription ends, you don’t have to do anything. If you would like to continue accessing the live streaming, We’ll renew your subscription automatically based on your monthly / yearly plan and process the payment from your account based on details provided to us.
                            <br>
                            There’s no fixed term contract, so you can cancel at any time – just sign in to your account and visit the My Subscription page. You can cancel or upgrade each subscription individually..

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('components/footer')
</body>

</html>

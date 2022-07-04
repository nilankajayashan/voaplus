<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.">
    <title>REGISTER | Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.</title>
</head>
@include('components/header')
<body>
@include('components/navbar')
<div class="container   style="min-height: 400px !important;"">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark" style="--bs-bg-opacity: .5;">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4 text-white">Register Now</h3></div>
                <div class="card-body">
                    @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{session()->get('error')}}
                        </div>
                    @endif
                    <form method="post" action="{{route('register_validate')}}">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="Email" name="email" placeholder="Email address">
                        </div>
{{--                        <div class="mb-3">--}}
{{--                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Mobile Number">--}}
{{--                        </div>--}}
                        <div class="mb-3">
                            <input type="password" class="form-control" id="Password" name="password" placeholder="Password" minlength="8">
                        </div>
                        <button type="submit" class="btn btn-warning col-12">REGISTER</button>
                        <h5 class="mt-3 text-white">If you already have account: &nbsp; <a href="{{route('login')}}" class="text-warning">LOGIN</a></h5>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{--fandq--}}
<div class="container-fluid text-center text-white mt-5 mb-5">
    <div class="container">
        <div class="card text-start shadow-lg border-0 rounded-lg mt-5 bg-dark p-3 ps-5">
            <h3>FAQ - Frequently asked questions</h3>
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
</div>

{{--endfandq--}}
@include('components/footer')
</body>
</html>

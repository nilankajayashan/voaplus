<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.">
    <title>LIVE | Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.</title>
</head>
@include('components/header')
<body  style="background-image: none; background-color: #21618C;">
@include('components/navbar')
<div class="container"  style="min-height: 500px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark" style="--bs-bg-opacity: .5;">
                <div class="card-body">
                    
                    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
                    @if(isset($stream_link) && $stream_link != "")
                    <video id="video" src="{{ $stream_link }}" width="100%" controls autoplay></video>
                    <script>
                        if(Hls.isSupported())
                        {
                            var video = document.getElementById('video');
                            var hls = new Hls();
                            hls.loadSource('{{ $stream_link }}');
                            hls.attachMedia(video);
                            hls.on(Hls.Events.MANIFEST_PARSED,function()
                            {
                                video.play();
                            });
                        }
                        else if (video.canPlayType('application/vnd.apple.mpegurl'))
                        {
                            video.src = '{{ $stream_link }}';
                            video.addEventListener('canplay',function()
                            {
                                video.play();
                            });
                        }
                    </script>
                    @else
                        <div class="alert bg-warning"> Live Stream Coming Soon...!</div>
                    @endif
                </div>
            </div>
            <div class="mt-1 row justify-content-center">
                <form action="{{ route('change-channel') }}" method="post" id="change_channel" class="text-center">
                    @csrf
                    <input type="hidden" name="channel" value="siyatha_tv" id="channel">
                 <div class="row col-12 justify-content-center">
                     <div class=" col-2 " onclick="changeChannel('siyatha_tv')"><img src="{{ asset('/public/assets/siyatha_logo.jpeg') }}" alt="SIYATHA TV" class="w-100 img-fluid rounded-3" role="button"></div>
                     <div class=" col-2" onclick="changeChannel('startamil_tv')"><img src="{{ asset('/public/assets/star_logo.jpeg') }}" alt="STAR TV" class="w-100 img-fluid rounded-3" role="button"></div>
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
</div>
@include('components/footer')
</body>
<script>
    setInterval(function () {
        let ajax_check_available = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        let method = "GET";
        let url = "{{ route('check_stream') }}";
        let asynchronous = true;

        ajax_check_available.open(method,url,asynchronous);
        ajax_check_available.send();

        ajax_check_available.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200){
                let data = JSON.parse(this.responseText);
                if(data == 0){
                    window.location.href = "{{ route('login') }}";
                }
            }
        }
    },60000);
</script>
</html>

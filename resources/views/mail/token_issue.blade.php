<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VOA+ | Stream Token</title>
</head>
<body>
<?php $user=session()->get('auth_user');
$stream_token =session()->get('stream_token');
?>
<div class="container" style="background-color:#ECF0F1;text-align: center; border: 1px solid darkgray;">
    <div style="background-color:#ffc107;padding: 20px;"><h4 style="padding: 0px;margin: 0px;">
            <img src="https://voaplus.apkings.link/public/assets/logo.png" alt="VOA+" style="width: 100px;">
        <h4>
                The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.
        </h4>
    </div>
    <div style="padding-left: 10px;padding-right: 10px; padding-bottom: 10px;">
        <h4 style="text-align: left;">Hi {{$user->name}},</h4>
        <p >
                        Thank you subscribing to VOA+. Please use the following stream token on VOA+ to Watch Siyatha TV Live. Please note that the stream key is only valid for the number of allowed devices on the subscribed plan.
        </p>
        <div style="background-color:#0a4275; width: 100px; text-align: center; border-radius: 15px; margin: 0 auto;width: max-content;padding: 10px 50px; color: #fff;"> {{ $stream_token }}

        </div>
        <div style="text-align: right; padding-top: 10px;">
            <address >
                <p style="margin: 0px; padding: 0px; ">Best Regards,</p>
                <h3 style="margin: 0px; padding: 0px;">Team VOA+</h3>
            </address>
        </div>
    </div>
    <footer class="" style="background-color: #0a4275; text-align: center; ">
        <div class="" style="padding: 20px;">
            <section class="mb-3">
                <img src="https://voaplus.apkings.link/public/assets/tv-logos.png" alt="VOICE OF ASIA" style="width: 25%;">
            </section>
        </div>
        <div  style="background-color: rgba(0, 0, 0, 0.2); padding: 5px;color: white;">
            © <?php echo date("Y"); ?> Copyright | VOA+
        </div>
    </footer>
</div>
</body>
</html>




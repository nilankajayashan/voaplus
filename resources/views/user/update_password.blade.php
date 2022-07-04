<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.">
    <title>UPDATE PASSWORD | Watch Siyatha TV Live on VOA+ The official LIVE STREAMING & VOD platform of Voice of Asia Network - The Largest Media Network in Sri Lanka.</title>
</head>
@include('components/header')
<body>
@include('components/navbar')
<script>
    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#password_conform").val();

        if (password != confirmPassword ) {
            $("#message").html("Password Conform Not Matched");
            $("#submit").prop("disabled", true);

        }else if(password == '' || password == ' '){
            $("#message").html("Please Enter password");
            $("#submit").prop("disabled", true);
        }
        else {
            $("#message").html("Update Password");
            $("#submit").prop("disabled", false);
        }
    }
    $(document).ready(function () {
        $("#message").html("Update Password");
        $("#password, #password_conform").keyup(checkPasswordMatch);
    });
</script>
<div class="container"   style="min-height: 400px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark" style="--bs-bg-opacity: .5;">
                <div class="card-header justify-content-center">
                    <h3 class="text-center font-weight-light my-1 text-white">Update Password</h3>
                </div>
                <div class="card-body">

                    <form method="post" action="{{ route('change_password') }}" id="update_password">
                        @csrf
                        <div class="mb-1">
                            <input type="password" class="form-control mb-3" name="password" id="password" minlength="8" placeholder="Enter new password" required>
                            <input type="password" class="form-control mb-3" name="password_conform" id="password_conform" placeholder="Enter password again" required>
                            <button class="btn btn-warning col-12" type="submit" id="submit"><span id="message">Update Password</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components/footer')
</body>
</html>

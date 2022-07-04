<!DOCTYPE html>
<?php

// unique_order_id|total_amount
$plaintext = '525|10';
$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC9l2HykxDIDVZeyDPJU4pA0imf
3nWsvyJgb3zTsnN8B0mFX6u5squ5NQcnQ03L8uQ56b4/isHBgiyKwfMr4cpEpCTY
/t1WSdJ5EokCI/F7hCM7aSSSY85S7IYOiC6pKR4WbaOYMvAMKn5gCobEPtosmPLz
gh8Lo3b8UsjPq2W26QIDAQAB
-----END PUBLIC KEY-----";
//load public key for encrypting
openssl_public_encrypt($plaintext, $encrypt, $publickey);

//encode for data passing
$payment = base64_encode($encrypt);
//checkout URL
$url = 'https://webxpay.com/index.php?route=checkout/billing';

//custom fields
//cus_1|cus_2|cus_3|cus_4
$custom_fields = base64_encode('cus_1|cus_2|cus_3|cus_4');

?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VOA+</title>
</head>
@include('components/header')
<body class="bg-light">
<?php $user = session()->get('auth_user'); ?>
<nav class="navbar navbar-light bg-primary justify-content-between p-3">
    <a class="navbar-brand text-white ">VOA+</a>
    <a href="{{ route('logout') }}" class="btn btn-danger btn-sm ">logout</a>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark" style="--bs-bg-opacity: .5;">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-1 text-white">Purchase Stream key</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo $url; ?>">
                        @csrf
                        <input type="hidden" name="first_name"  value="<?php
                                $name = explode(" ",$user->name);
                                echo $name[0];
                                ?>" required>
                        <input type="hidden" name="last_name"  value="<?php
                                $name = explode(" ",$user->name);
                                if(count($name) > 1){
                                    echo $name[1];
                                }else{
                                    echo $name[0];
                                }
                                ?>" required>
                        <input type="hidden" name="email" value="{{ $user->email }}" required>
                        <div class="mb-3">
                           <label for="phone" class="form-label text-white">Mobile number</label>
                           <input type="tel" class="form-control" id="phone" name="contact_number" placeholder="Mobile Number">
                       </div>
                        <div class="form-group">
                            <label for="address" class="text-white mb-1">Address:</label>
                            <textarea class="form-control mb-2" id="address_line_one" rows="1" name="address_line_one" required></textarea>
                        </div>
                        <input type="hidden" name="custom_fields" required value="{{$user->id.'|'.$package}}">{{--   <?php echo $custom_fields; ?>--}}
                        <input type="hidden" name="process_currency" value="LKR" required>
                        <input type="hidden" name="cms" value="PHP">
                        <input type="hidden" name="payment" id="order_value" value="<?php 
                        switch($package){
                            case 1:
                                echo base64_encode(100);
                                break;
                            case 2:
                                echo base64_encode(500);
                                break;
                            case 3:
                                echo base64_encode(1000);
                                break;
                            default:
                                echo base64_encode(0);
                                break;
                        }
                        ?>" required>
                        <input type="hidden" name="secret_key" value="630be963-59e2-447a-8f3b-93b3d7a3bf25">
<input type="hidden" name="responce_url" value="{{route('payment_handle')}}">
                        <div class="mb-1">
                            <input type="submit" value="Purchase" class="btn btn-primary col-12 mt-3"/>
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

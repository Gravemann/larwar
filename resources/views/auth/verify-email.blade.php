<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verification mail sent</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="{{ url('css/style.css') }}" rel="stylesheet">

</head>


<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            @include('alerts')
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="image" img src="./storage/confirmail.jpg"></div>
                                    <h4 class="text-center mb-4">Confirm your email address</h4>
                                    <article>
                                        <p class="text-center">A confirmation mail was sent to your e-mail address</p>
                                        <p class="text-center bold" style="color:blue">
                                            {{ $email }}
                                        </p>
                                        <p class="text-center">Check you email and click on the confirmation link to
                                            continue</p>
                                        <p class="text-center">If you have not received it please press "Resend" button
                                            for
                                            the confirmation mail to be sent again</p>
                                        @if (session('message'))
                                            <p class="alert alert-success text-center">{{ session('message') }}</p>
                                        @endif
                                    </article>
                                    <form method="post" action="{{ route('verification.send') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Resend</button>
                                    </form>
                                    <a href="{{ route('logout') }}">
                                        <button type="button" class="btn btn-danger">Logout</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
    Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ url('vendor/global/global.min.js') }}"></script>
    <script src="{{ url('js/quixnav-init.js') }}"></script>
    <script src="{{ url('js/custom.min.js') }}"></script>

</body>

</html>

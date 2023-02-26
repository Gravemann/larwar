<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Email verification success</title>
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
                                    <h4 class="text-center mb-4">Your email <p class="text-center bold"
                                            style="color:blue"> {{ $email }} </p> has
                                        been successfully confirmed!
                                    </h4>
                                    <article>
                                        <p class="text-center">Now you can use complete functionality of this
                                            application</p>
                                    </article>
                                    <a href="{{ route('brands') }}">
                                        <button type="button" class="btn btn-primary btn-block">Try it</button>
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

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Password </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="./css/style.css" rel="stylesheet">

</head>


<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form method="post" action="{{ route('password.update') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden"
                                                class="form-control @error('token') border-red-592.5/35 @enderror"
                                                name="token" value="{{ $token }}">
                                            @error('token')
                                                <p class="text-red-500"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email"
                                                class="form-control @error('email') border-red-592.5/35 @enderror"
                                                name="email" value="{{ $email }}">
                                            @error('email')
                                                <p class="text-red-500"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password"
                                                class="form-control @error('password') border-red-592.5/35 @enderror"
                                                placeholder="*******" name="password">
                                            @error('password')
                                                <p class="text-red-500"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Re-type Password</strong></label>
                                            <input type="password"
                                                class="form-control @error('password_confirmation') border-red-592.5/35 @enderror"
                                                placeholder="*******" name="password_confirmation">
                                            @error('password_confirmation')
                                                <p class="text-red-500"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        </div>
                                    </form>
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
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <!--endRemoveIf(production)-->
</body>

</html>

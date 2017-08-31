
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="{{URL::asset('/public/cms/images/favicon.png')}}">

    <title>SIGN IN</title>

    <!--Core CSS -->
    <link href="{{URL::asset('/public/cms/bs3/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/cms/css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/cms/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{URL::asset('/public/cms/css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/cms/css/style-responsive.css')}}" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="{{URL::asset('/public/cms/js/ie8-responsive-file-warning.js')}}"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

    {!! Form::open(['url'=>PREFIX.'/login/operation/login', 'class'=>'form-signin'])!!}

        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">
            <div class="user-login-info">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Error!</strong> Invalid Username / Password<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {!! Form::text('username','',['class'=>'form-control','placeholder'=>'Username','autofocus' => 'autofocus']) !!}
                {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
            </div>
            {!! Form::submit("Sign In",['class'=>'btn btn-lg btn-login btn-block'])!!}
        </div>

    {!!Form::close() !!}
    
    </div>



    <!-- Placed js at the end of the document so the pages load faster -->

    <!--Core js-->
    <script src="{{URL::asset('/public/cms/js/jquery.js')}}"></script>
    <script src="{{URL::asset('/public/cms/bs3/js/bootstrap.min.js')}}"></script>

  </body>
</html>

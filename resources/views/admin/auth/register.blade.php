<!DOCTYPE html>

<head>
    <title>Đăng kí</title>
    <link rel="shortcut icon" href="{{ url('/frontend') }}/images/logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
        window.scrollTo(0, 1);
    }
    </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{ 'backend/css/bootstrap.min.css' }}">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{ 'backend/css/style.css' }}" rel='stylesheet' type='text/css' />
    <link href="{{ 'backend/css/style-responsive.css' }}" rel="stylesheet" />
    <!-- font CSS -->
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{ 'backend/css/font.css' }}" type="text/css" />
    <link href="{{ 'backend/css/font-awesome.css' }}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <script src="{{ 'backend/js/jquery2.0.3.min.js' }}"></script>
</head>

<body>
    <style>
        .a-button {
            padding: 12px 38px;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: #f0bcb4;
            color: white;
            border: none;
            outline: none;
            display: table;
            cursor: pointer;
            margin: 20px auto;
            transition: 0.5s all;
            -webkit-transition: 0.5s all;
        }

        .a-button:hover {
            background: #8b5c7e;
            transition: 0.5s all;
            -webkit-transition: 0.5s all;
            color: #fff !important;
        }
    </style>
    <div class="log-w3">
        <div class="w3layouts-main">
            <h2>Đăng kí</h2>
            <?php
            
            use Illuminate\Support\Facades\Session;
            
            $message = Session::get('message');
            
            if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
            }
            ?>
            <form action="{{ URL::to('/register') }}" method="post">
                {{ csrf_field() }}
                <input type="text" class="ggg" value="{{ old('admin_name') }}" name="admin_name"
                    placeholder="Name" required="">
                <input type="text" class="ggg" value="{{ old('admin_email') }}" name="admin_email"
                    placeholder="E-MAIL" required="">
                <div>
                    @error('admin_email')
                        <small><strong style="color: red;">{{ $message }}</strong></small>
                    @enderror
                </div>
                <input type="text" class="ggg" value="{{ old('admin_phone') }}" name="admin_phone"
                    placeholder="Phone" required="">
                <input type="password" class="ggg" name="admin_password" placeholder="PASSWORD" required="">
                @error('admin_password')
                    <small><strong style="color: red;">{{ $message }}</strong></small>
                @enderror
                <div class="clearfix"></div>
                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                <br />
                @if ($errors->has('g-recaptcha-response'))
                    <span class="invalid-feedback"
                        style="display:block; width: 100%; color: red;text-align: center;margin-bottom: 15px;">
                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif

                <input type="submit" value="Đăng kí" name="login">
            </form>
            <a href="{{ URL::to('/login-auth') }}" class="a-button">Đăng nhập</a>

        </div>
    </div>
    <script src="{{ 'backend/js/bootstrap.js' }}"></script>
    <script src="{{ 'backend/js/jquery.dcjqaccordion.2.7.js' }}"></script>
    <script src="{{ 'backend/js/scripts.js' }}"></script>
    <script src="{{ 'backend/js/jquery.slimscroll.js' }}"></script>
    <script src="{{ 'backend/js/jquery.nicescroll.js' }}"></script>
    <script src="{{ 'backend/js/jquery.scrollTo.js' }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>

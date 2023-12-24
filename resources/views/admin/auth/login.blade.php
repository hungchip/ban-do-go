<!DOCTYPE html>

<head>
    <title>Đăng nhập</title>
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
    <!-- <link href="{{ 'backend/css/fontawesome.min.css' }}" rel="stylesheet">  -->
    <!-- <link rel="stylesheet" href="{{ 'backend/css/font.css' }}" type="text/css"/> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
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

        .a-button:hover,
        .a-facebook:hover,
        .a-google:hover {
            background: #8b5c7e;
            transition: 0.5s all;
            -webkit-transition: 0.5s all;
            color: #fff !important;
        }

        .a-facebook {
            padding: 15px;
            background: #3B62A3;
            margin: 20px 0px;
            display: inline-block;
            padding-right: 50px;
            padding-left: 50px;
        }

        .a-google {
            padding: 15px;
            background: #DE6262;
            margin: 20px 0px;
            display: inline-block;
            padding-right: 65px;
            padding-left: 65px;
        }
    </style>
    <div class="log-w3">
        <div class="w3layouts-main">
            <h2>Đăng nhập</h2>
            <?php
            
            use Illuminate\Support\Facades\Session;
            
            $message = Session::get('message');
            
            if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
            }
            ?>
            <form action="{{ URL::to('/login') }}" method="post">
                {{ csrf_field() }}
                <input type="text" class="ggg" name="admin_email" placeholder="E-MAIL" required="">
                <input type="password" class="ggg" name="admin_password" placeholder="PASSWORD" required="">
                <!-- <span><input type="checkbox" />Nhớ mật khẩu</span> -->
                <h6><a href="#">Quên mật khẩu</a></h6>
                <div class="clearfix"></div>
                <input type="submit" value="Đăng nhập" name="login">
            </form>
            <a href="{{ URL::to('/register-auth') }}" class="a-button">Đăng kí</a>
            <a href="{{ URL::to('/login-facebook') }}" class="a-facebook"><i class="fab fa-facebook"></i> Facebook</a>
            <a href="{{ URL::to('/login-google') }}" class="a-google"><i class="fab fa-google-plus-g"></i> Google</a>


        </div>
        <script src="{{ 'backend/js/bootstrap.js' }}"></script>
        <script src="{{ 'backend/js/jquery.dcjqaccordion.2.7.js' }}"></script>
        <script src="{{ 'backend/js/scripts.js' }}"></script>
        <script src="{{ 'backend/js/jquery.slimscroll.js' }}"></script>
        <script src="{{ 'backend/js/jquery.nicescroll.js' }}"></script>
        <script src="{{ 'backend/js/jquery.scrollTo.js' }}"></script>

</body>

</html>

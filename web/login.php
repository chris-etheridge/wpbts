<?php

session_start();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WPBTS - Admin Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">Log in</div>

            <?php
            if (isset($_SESSION['alert'])) {
                ?>
                <div class="alert <?php echo $_SESSION['alert']['message_type']; ?> alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <strong><?php echo $_SESSION['alert']["message_title"] ?></strong><?php echo $_SESSION['alert']["message"] ?>
                </div>
                <?php
                $_SESSION['alert'] = null;
            }
            ?>

            <div class="panel-body">
                <form action="php/form-handler-login.php" method="post">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="username" name="USERNAME" type="username"
                                   autofocus="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="password" name="PASSWORD" type="password" value="">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me">Remember Me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-info">Login</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->

<?php require_once('footer.php'); ?>

<script>
    !function ($) {
        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
</body>

</html>

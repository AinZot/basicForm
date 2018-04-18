<!DOCTYPE html>
<html>
    <head>
        <title>Basic form</title>
        <!-- Meta tag Keywords -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- css files -->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
        <link href="resources/css/jquery.toastmessage.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
        <!-- //css files -->
        <!-- online-fonts -->
        <link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'><link href='//fonts.googleapis.com/css?family=Raleway+Dots' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="/javascript/jquery.toastmessage.js"></script>

        <script>
            $(document).ready(function () {
                $('#registerForm').submit(function (e) {

                    $.ajax({
                        type: "POST",
                        url: '/hendler.php',
                        dataType: "json",
                        data: $("#registerForm").serialize(), // serializes the form elements.
                        success: function (data)
                        {
                            if (data.error === undefined && data.database === undefined) {
                                $().toastmessage('showToast', {
                                    text: data.success,
                                    stayTime: 6000,
                                    position: 'top-right',
                                    type: 'success',
                                });
                            } else {
                                var errMsg = '';
                                $.each(data.error, function (index, value) {
                                    if (value.length == 1) {
                                        errMsg = errMsg + value + '</br>';
                                    } else {
                                        $.each(value, function (index, value) {
                                            errMsg = errMsg + value + '</br>';
                                        });
                                    }
                                });

                                $().toastmessage('showToast', {
                                    text: errMsg,
                                    stayTime: 6000,
                                    position: 'top-right',
                                    type: 'error',
                                });


                                //$().toastmessage('showErrorToast', errMsg);
                            }
                        },
                        error: function (error)
                        {
                            alert(error); // show error
                        }
                    });
                    e.preventDefault(); // avoid to execute the actual submit of the form.
                });
            });
        </script>    
    </head>
    <body>
        <!--header-->
        <div class="header-w3l">
            <h1>Basic form</h1>
        </div>
        <!--//header-->
        <!--main-->
        <div class="main-agileits">
            <h2 class="sub-head">Sign Up</h2>
            <div class="sub-main">	
                <form id="registerForm" action="#" method="post">
                    <input placeholder="Name" name="name" class="name" type="text" required="">
                    <span class="icon1"><i class="fa fa-user" aria-hidden="true"></i></span><br>         
                    <input placeholder="Email" name="mail" class="mail" type="text" required="">
                    <span class="icon4"><i class="fa fa-envelope" aria-hidden="true"></i></span><br>
                    <input  placeholder="Password" name="password" class="pass" type="password" required="">
                    <span class="icon5"><i class="fa fa-unlock" aria-hidden="true"></i></span><br>
                    <input  placeholder="Confirm Password" name="rePassword" class="pass" type="password" required="">
                    <span class="icon6"><i class="fa fa-unlock" aria-hidden="true"></i></span><br>

                    <input type="submit" value="sign up">
                </form>
            </div>
            <div class="clear"></div>
        </div>
        <!--//main-->



    </body>
</html>
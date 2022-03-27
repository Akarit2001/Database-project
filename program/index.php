<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Bootstrap 5 Alpha CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style_login.css">
    <style>
        .myinput {
            color: black;
            margin: 13px auto;
            padding:13px 10px;
            width: 78%;
            border: none;
            background-color:#EFFFFD;
            border-radius: 8px;
        }
        .m2{
            background-color: #FDF6EC;
        }
        .card1{
            background-color:#B8FFF9
        }
        .card2{
            background-color: #F3E9DD;
        }

    </style>
</head>

<body>

    <div class="wrap" style="width: 1200px;margin:auto;">

        <div style="display:flex; justify-content:center; ">


            <div style="width:400px; margin:80px 50px; ">
                <div class="card shadow-lg border-0">

                    <div class="card-body card1 " >
                        <div class="text-center">
                            <img class="logo" src="https://cdn3.iconfinder.com/data/icons/galaxy-open-line-gradient-i/200/account-256.png">
                        </div>
                        <h3 class="text-logo">Sign In</h3>
                        <br>
                        <form class="text-center " action="./script/logincustomer.php" method="POST">
                            <input class="myinput" type="text" name="cname" placeholder="Type Your Username" required>
                            <br>
                            <input class="myinput" type="password" name="cpass" placeholder="Type Your Password" required>
                            <br><br>
                            <input class="btn btn-primary btn-sm border-0 " type="submit" name="submituser" value="Customer Sign In"></input>
                            <p class="forgot"><a href="">Forgot Password?</a></p>
                        </form>
                    </div>
                    <div class="nomember">
                        <p class="text-center">Not a member? <a href="register.php">Create an Account</a></p>
                    </div>

                </div>
            </div>



            <div style="width:400px; margin:80px 50px;">
                <div class="card shadow-lg border-0">

                    <div class="card-body card2">
                        <div class="text-center" class="ct">
                            <img class="logo" src="https://cdn3.iconfinder.com/data/icons/galaxy-open-line-gradient-i/200/account-256.png">
                        </div>
                        <h3 class="text-logo">Sign In</h3>
                        <br>
                        <form class="text-center" action="./script/loginseller.php" method="POST">
                            <input class="myinput m2" type="text" name="sname" placeholder="Type Your Username" required>
                            <br>
                            <input class="myinput m2" type="password" name="spass" placeholder="Type Your Password" required>
                            <br>
                            <br>
                            <input class="btn btn-primary btn-sm border-0 sell" type="submit" name="submitseller" value="Seller Sign In" ></input>
                            <p class="forgot"><a href="">Forgot Password?</a></p>
                        </form>
                    </div>
                    <div class="nomember">
                        <p class="text-center">Not a member? <a href="register.php">Create an Account</a></p>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <!-- Bootstrap 5 Alpha JavaScript Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy" crossorigin="anonymous"></script>
</body>

</html>
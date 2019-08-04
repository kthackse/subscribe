<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css?_=1554313746">
    <meta name="theme-color" content="#68a4cc">
    <meta name="author" content="KTHack">
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>
    <link rel="icon" href="favicon.png" type="image/png">
    <meta name="description" content="KTH hackathon, organised by KTH Artificial Intelligence Society">


    <!--FACEBOOK DESCRIPTION -->
    <meta property="og:title" content="Subscribe | KTHack"/>
    <meta property="og:site_name" content="KTHack"/>
    <meta property="og:description" content="KTH hackathon, organised by KTH Artificial Intelligence Society"/>
    <meta property="og:image" content="http://soon.kthack.com/overview.png">
	<meta property="og:image:secure_url" content="https://soon.kthack.com/overview.png">
	<meta property="og:url" content="http://soon.kthack.com">

    <!--TWITTER DESCRIPTION -->
	<meta name="twitter:card" content="summary">

	<meta name="twitter:title" content="Subscribe | KTHack">
	<meta name="twitter:description" content="KTH hackathon, organised by KTH Artificial Intelligence Society">
	<meta name="twitter:image" content="http://soon.kthack.com/overview.png">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <title>Subscribe | KThack</title>
</head>

<body>
<header class="centered">
	<div class="container">
		<div class="row">
	      	<div class="col-sm-3">
            </div>
	      	<div class="col-sm-6">
	      	    <a href=""><img src="assets/img/logo_wh.png" class="logo"></a>
            </div>
	      	<div class="col-sm-3">
            </div>
		</div>
		<div class="row">
	      	<div class="col-sm-3">
            </div>
	      	<div class="col-sm-6">
				<h1 class="white bold text-center">KTHack 2020</h1>
				<p class="white paragraph text-center">Don't miss the oportunity to take part into Sweden's first student hackathon, subscribe to receive updates!</p>
                <?php
                    session_start();
                    if(isset($_SESSION["status"]) && ($_SESSION["status"] == "done")){
                        echo "<p class=\"white bold margin-0 text-center\">Thank-you for registering, remember to check your inbox (and spam) to confirm your email!</p>";
                        $_SESSION["status"] = "initial";
                    }
                    else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "activated")){
                        echo "<p class=\"white bold margin-0 text-center\">Your email has been confirmed, thank-you!</p>";
                    }
                    else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "database")){
                        echo "<p class=\"white bold margin-0 text-center\">Internal error, please write to <a href=\"mailto:contact@kthack.com\" class=\"link-white bold\">contact@kthack.com</a>!</p>";
                    }
                    else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "registered")){
                        echo "<p class=\"white bold margin-0 text-center\">You have already subscribed, but the email hasn't been confirmed yet, check the spam folder!</p>";
                    }
                    else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "confirmed")){
                        echo "<p class=\"white bold margin-0 text-center\">You are already subscribed and confirmed!</p>";
                    }
                    else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "code")){
                        echo "<p class=\"white bold margin-0 text-center\">The link provided is invalid!</p>";
                    }
                    else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "unsubscribed")){
                        echo "<p class=\"white bold margin-0 text-center\">You've been unsubscribed, we are sorry to hear that!</p>";
                    }
                    else{
                ?>
                <form action="register/" method="post" class="submission-form text-center">
		            <div class="row">
	      	            <div class="col-sm-12">
                            <input type="text" name="email" id="email" placeholder="example@kthack.com">
		                </div>
		            </div>
		            <div class="row">
	      	            <div class="col-sm-12 checkbox">
                            <input type="checkbox" name="policies" id="policies" value="accept"><label for="policies" class="white">I read, understand and accept the <a href="policy" class="link-white bold">policy</a>.</label>
                        <?php
                            session_start();
                            if(isset($_SESSION["status"]) && ($_SESSION["status"] == "email")){
                                echo "<p class=\"white bold margin-top-only\">You need to enter an email!</p>";
                            }
                            else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "checkbox")){
                                echo "<p class=\"white bold margin-top-only\">You need to accept the policy!</p>";
                            }
                            else if(isset($_SESSION["status"]) && ($_SESSION["status"] == "format")){
                                echo "<p class=\"white bold margin-top-only\">The email you entered is invalid!</p>";
                            }
                        ?>
		                </div>
		            </div>
		            <div class="row">
	      	            <div class="col-sm-12">
                            <input type="submit" value="Submit">
		                </div>
		            </div>
                </form>
                <?php
                    }
                    $_SESSION["status"] = "initial";
                ?>
            </div>
	      	<div class="col-sm-3">
            </div>
		</div>
	</div>
</header>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
<script src="assets/js/events.js?_=1554313746"></script>


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137575645-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-137575645-1');
    </script>

</body>
</html>


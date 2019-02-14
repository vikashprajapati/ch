<?php
require 'timer.php';
// print_r($timerData);
if ($timerData['status'] == 1) {
    // Event running.
    require 'checkuserstatus.php';
    if ($userStatus == null) {
        // User is logged in and not blocked.
        header('Location: /home.php');
    }
}
// load configurations
$conf = parse_ini_file('./../app.ini.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Chakravyuh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Chakravyuh is the online treasure hunt event of Sankalan-The Annual Tech Fest of Department of Computer Science, University of Delhi." name="description" />
    
    <meta content="Chakravyuh, Chakravyuh 2019, Treasure hunt, Online treasure hunt, events, event list, Sankalan, Online treasure hunt Sankalan, DUCSS, DUCS, Delhi University Computer Science Society, Sankalan 2019, annual fest, Department of Computer Science, University of Delhi, Annual fest of DUCS, Conference Centre, North Campus" name="keywords" />

    <!-- Favicons -->
    <link rel='shortcut icon' type='image/x-icon' href='./favicon.ico' />
    
    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

    <!-- CSS start here -->
    <?php 
    // these are put in php here to hide from html source + keeping them for future
    //    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="screen">
    //    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    //    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    ?>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />

    <link rel="stylesheet" type="text/css" href="css/indexStyle.css" />
    <link rel="stylesheet" type="text/css" href="css/banner.css" />
    <link rel="stylesheet" type="text/css" href="css/leaderboard.css" />
    <!-- CSS end here -->
    
    <!-- Google fonts start here -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css">
    <!-- Google fonts end here -->

</head>

<body class="ux">
    <div class="bg-overlay"></div>

    <!-- Preloader start here -->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Preloader end here -->
    
    <!-- About Icon start here -->
    <div class="about-us">
        <a href="#" class="fa fa-file-text-o tool-tip" data-toggle="modal" data-target=".bs-example-modal-lg" data-placement="right" title="Rules"></a>
    </div>
    <!-- About Icon end here -->
    
    <!-- Contact Icon start here -->
    <div class="contact-us">
        <a href="#" class="fa fa-envelope-o tool-tip" data-toggle="modal" data-target=".bs-example-modal-lg2" data-placement="right" title="Contact Us"></a>
    </div>   
    <!-- Contact Icon end here -->

    <?php 
    // these are put in php here to hide from html source + keeping them for future
    // <!-- Leaderboard Icon start here -->
    // <div class="index-leaderboard">
    //     <a href="#" class="fa fa-trophy tool-tip" data-toggle="modal" data-target=".bs-example-modal-lg3" data-placement="right" title="Leaderboard"></a>
    // </div>
    // <!-- Leaderboard Icon end here -->
    ?>
    
    <!-- Main container start here -->
    <section class="container main-wrapper">

        <!-- Logo start here -->
        <section id="logo" class="fade-down">
            <a href="#" title="Chakravyuh">
                <div class="grid__item color-11">
                    <a class="link link--yaku" href="#">
                        <span>C</span><span>H</span><span>A</span><span>K</span><span>R</span><span>A</span><span>V</span><span>Y</span><span>U</span><span>H</span>
                    </a>
                </div>
            </a>
        </section>
        <!-- Logo end here -->

        <!-- Slogan start here -->
        <section class="slogan fade-down">
            <h1 class="headingIndex" id="gameStatus">THE GAME HAS ENDED</h1>
        </section>
        <!-- Slogan end here -->

        <!-- Count Down start here -->
        <section class="count-down-wrapper fade-down">
            <ul class="row count-down">
                <li class="col-md-3 col-sm-6">
                    <input class="knob days" data-readonly="true" data-min="0" data-max="365" data-width="260" data-height="260" data-thickness="0.07" data-fgcolor="#34aadc" data-bgcolor="#e1e2e6" data-angleoffset="180">
                    <span id="days-title">days</span>
                </li>
                <li class="col-md-3 col-sm-6">
                    <input class="knob hour" data-readonly="true" data-min="0" data-max="24" data-width="260" data-height="260" data-thickness="0.07" data-fgcolor="#4cd964" data-bgcolor="#e1e2e6" data-angleoffset="180">
                    <span id="hours-title">hours</span>
                </li>
                <li class="col-md-3 col-sm-6">
                    <input class="knob minute" data-readonly="true" data-min="0" data-max="60" data-width="260" data-height="260" data-thickness="0.07" data-fgcolor="#ff9500" data-bgcolor="#e1e2e6" data-angleoffset="180">
                    <span id="mins-title">minutes</span>
                </li>
                <li class="col-md-3 col-sm-6">
                    <input class="knob second" data-readonly="true" data-min="0" data-max="60" data-width="260" data-height="260" data-thickness="0.07" data-fgcolor="#ff3b30" data-bgcolor="#e1e2e6" data-angleoffset="180">
                    <span id="secs-title">seconds</span>
                </li>
            </ul>
        </section>
        <!-- Count Down end here -->

        <!-- Social icons start here -->
        <ul class="connect-us row fade-down">
            <div class="alert alert-success collapse" id="login-success" role="alert"><strong>Success!</strong> Welcome to the game.</div>
            <div class="alert alert-danger collapse" id="login-error" role="alert"></div>
            <div class="alert alert-info collapse" id="login-event-info" role="alert"></div>
            <li><img class="img-responsive" alt="Login using Facebook" id="facebook-login-button" src="img/LoginWithFacebook.png" onclick="loginWithFacebook()" title="Login using Facebook"></li>
            <br><br>
            <li><a href="https://www.facebook.com/ducs.chakravyuh" class="fb tool-tip" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/sankalan_ducs" class="twitter tool-tip" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
        </ul>
        <!-- Social icons end here -->
        
        <!-- Footer start here -->
        <footer class="fade-down">
            <!--                <p class="footer-text">&copy; Chakravyuh 2019, All Rights Reserved.</p>-->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; <a href="index.php" target="_blank" class="tool-tip" title="Chakravyuh">Chakravyuh</a> -
                        <a href="http://ducs.in" target="_blank" title="Sankalan 2019" class="tool-tip">Sankalan 2019</a>,
                        <a href="http://cs.du.ac.in/" target="_blank" title="DUCS" class="tool-tip"> DUCS</a>, University of Delhi </div>
                </div>
            </div>
        </footer>
        <!-- Footer end here -->

    </section>


    <!-- Rules start here -->
    <div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true" data-keyboard="true" data-backdrop="static" tabindex="-1">
        <a href="#" class="fa fa-times cls-pop" data-dismiss="modal"></a>
        <div class="modal-dialog modal-lg clearfix">
            <div class="modal-content pop-up">
                <h3 class="headingIndex">Chakravyuh Rules</h3>
                <div class="clearfix">
                    <div class="chkRules">
                        <ol>
                            <li>Facebook login is required.</li>
                            <li>Submit answer in textbox or do whatsoever you can do to go to the next level.</li>
                            <li>Questions can be in any form pictorial, video, text or anything.</li>
                            <li>For interaction with the organizers there would be organizer managed Facebook page.</li>
                            <li>Only alphabets and numbers are allowed.
                                <br>a) No special characters like @, _, are allowed EXCEPT "." and "-", however you can use whitespace between two words but answer without whitespace is also acceptable (for e.g. Hello world is same as helloworld , HeLloWorlD , HELLO WORLD).
                                <br>b) Acceptable date format is “1 Jan 2000” for an answer.
                            </li>
                            <li>Any attempt of hacking will lead to automatic disqualification.</li>
                            <li>If admin realizes that any participant has used any kind of unfair means to clear any level then the admin is liable to block the user without any prior notice to anyone and admin will be unquestionable.</li>
                            <li>Hint Scheme will be as follows:
                                <br>a) Hints will be available on the website itself to every participant privately as per their level when they are eligible for it.
                                <br>b) Any mail asking for answers or hints shall not be entertained.
                                <br>c) Answers may relate to the hint in any complex form.
                                <br>d) Participants can also look for hints of an answer anywhere on the page also. (Image, Video, Text Source code, URL, Current Page).
                                <br>e) Bonus Hints will be provided on Facebook Page of Chakravyuh. </li>
                            <li>Point Scheme will be as follows:
                                <br>a) First 20 players to clear the level will get 10 points.
                                <br>b) Next 30 players that are from 21 to 50 for that level will get 9 points.
                                <br>c) Remaining players to clear that level will get 8 points.</li>
                            <li>The first person to clear a level has split time 0. Any other person to clear that level will have split time which is calculated as follows:
                                <br>a) Submit time of current user – Submit time of first person to clear that level.
                            </li>
                            <li>Split time explanation:
                            <br>It shows the time difference of correct answer submission between you and the 1st participant to complete that level. For example, if your split time is +0:10:13.0000, you were 10 minutes and 13 seconds late in submitting the correct answer to your previous level as compared to the 1st participant completing that same level. If your split time is +0:0:0.0000, you were the first one to submit the correct answer to your previous level.
                            </li>
                            <li>Only one prize will be awarded:
                                <br>a) The prize will go to the first player completing all the levels irrespective of points and split time.
                                <br>b) If no one is able to complete all the levels and the event ends, the player with maximum level will win. If levels are same then points will be considered and if points are same then split time will be considered in deciding the winner.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Rules end here -->
    
    <!-- Contact start here -->
    <div class="modal fade bs-example-modal-lg2" role="dialog" aria-hidden="true" data-keyboard="true" data-backdrop="static" tabindex="-1">
        <a href="#" class="fa fa-times cls-pop" data-dismiss="modal"></a>
        <div class="modal-dialog modal-lg">
            <div class="modal-content pop-up pop-up-cnt">
                <h3 class="headingIndex">Contact us</h3>
                <div class="clearfix cnt-wrap">
                    <div class="col-md-4 col-sm-4">
                        <i class="fa fa-phone"></i>
                        <h4 class="headingIndex">Phone</h4>
                        <p>Avinash Prasad: (+91) 9555138871
                            <br />Sushmita Yadav: (+91) 8826391168</p>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <i class="fa fa-envelope-o"></i>
                        <h4 class="headingIndex"><a href="https://www.facebook.com/ducs.chakravyuh" target="_blank">Facebook Page</a></h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <i class="fa fa-map-marker"></i>
                        <h4 class="headingIndex">Address</h4>
                        <p>Department of Computer Science, Faculty of Mathematical Sciences
                            <br />University of Delhi
                            <br />Delhi - 110007
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact end here -->
    <?php 
    // <!-- Leaderboard start here -->
    // <div class="modal fade bs-example-modal-lg3" role="dialog" aria-hidden="true" data-keyboard="true" data-backdrop="static" tabindex="-1">
    //     <a href="#" class="fa fa-times cls-pop" data-dismiss="modal"></a>
    //     <div class="modal-dialog modal-lg clearfix">
    //         <div class="modal-content pop-up">
    //             <h3 class="headingIndex">Chakravyuh Rules</h3>
    //             <div class="clearfix">
    //                 <div class="table-responsive col-lg-12">
    //                     <table class="table table-hover leaderboardTable table-condensed text-center">
    //                         <thead>
    //                             <tr>
    //                                 <th class="text-center">Rank</th>
    //                                 <th class="text-center">Player</th>
    //                                 <th class="text-center">Level</th>
    //                                 <th class="text-center">Points</th>
    //                             </tr>
    //                         </thead>
    //                         <tbody>
    //                         </tbody>
    //                     </table>
    //                 </div>
    //             </div>
    //         </div>
    //     </div>

    // </div>
    // <!-- Leaderboard end here -->
    ?>
    <!-- Main container end here -->
    
    <!-- Javascript framework and plugins start here -->
    <?php 
    // <script type="text/javascript" src="js/jquery.js"></script>
    // <script type="text/javascript" src="js/bootstrap.min.js"></script>
    // <script src="js/modernizr.js"></script>
    // <script src="js/jquery.knob.js"></script>
    ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <script>

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function handleLoginStatus(response) {
            if (response.status === 'connected') {
                
                FB.api('/me?fields=id,name,email,picture{url}', function (response) {
                    $.ajax({
                        type: 'POST',
                        url: 'login.php',
                        data: 'id=' + response.id + '&name=' + response.name + '&email=' + response.email + '&pictureUrl=' + encodeURIComponent(response.picture.data.url),
                        success: function (msg) {
                            if (msg == 1) {
                                // Success.
                                
                                $('#login-success').show(300);
                                // redirection
                                setTimeout(function () {
                                    window.location = 'home.php';
                                }, 1000);
                            } else if (msg == 'USER_REG_ERROR' || msg == 'LOGIN_DATA_MISSING') {
                                $('#login-error').html("<strong>Something went wrong!</strong> Unable to login/register you. Please try again after some time.").show(300);
                            } else if (msg == 'USER_BLOCKED') {
                                $('#login-error').html("<strong>Oops!</strong> It seems you're blocked from this event.").show(300);
                            } else if (msg == 'THE GAME IS ABOUT TO BEGIN. ARE YOU READY?') {
                                $('#login-event-info').html("Hello, <strong>" + response.name + ".</strong> You've successfully registered for the event. You'll be able to login once the event is running. Stay tuned!").show(300);
                            } else if (msg == 'THE GAME HAS ENDED') {
                                $('#login-event-info').html("<strong>The event has ended.</strong> Thank you for playing!").show(300);
                            } else if (msg == 'ERROR_CONNECTION_FAILURE') {
                                alert('Oops! It seems there was a connection failure with the server. Please try again after some time.');
                            } else if (msg == 'USER_REG_CLOSE') {
                            $('#login-error').html("<strong>Registrations closed!</strong> Thank you for showing interest in the event. We look forward to seeing you next year.").show(300);
                            }
                        },
                        error: function (msg) {
                            console.log(msg);
                        }
                    });
                });

            } else if (response.status === 'not_authorized') {
                $('#login-error').html('<strong>Oops!</strong> Please log into the app to continue.').show(300);
            } else {
                $('#login-error').html('<strong>Oops!</strong> Please log into Facebook to continue.').show(300);
            }
        }


        function loginWithFacebook() {
            FB.login(function (response) {
                handleLoginStatus(response);
            }, {
                scope: 'public_profile, email'
            });
        }

        window.fbAsyncInit = function() {
            // app id for analytics
            FB.init({
                appId      : <?php echo "'" . $conf['snishal_appid'] . "'" ?>, 
                cookie     : true,
                xfbml      : true,
                version    : 'v3.2'
            });
            
            FB.AppEvents.logPageView();    

        };    
        
            console.log('%cStop! You are not as smart as you think', 'color: red; font-size: 30px; font-weight: bold;');

    </script>

    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script type="text/javascript" src="js/appear.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
    <script src="js/jquery.ccountdown.js"></script>
    <script src="js/general.js"></script>
    <!-- Javascript framework and plugins end here -->



</body>

</html>

<?php
// here as comments
// todo
// this link - https://stackoverflow.com/a/7068835
// will help reduce data index php

// todo - see why old fb login function was not working

// function loginWithFacebook() {
//     FB.getLoginStatus(function (response) {
//         // console.log(response);
//         if (response.status === 'connected') {
//             handleLoginStatus(response);
//         } else {
//             FB.login(function (response) {
//                 handleLoginStatus(response);
//             }, {
//                 scope: 'public_profile, email'
//             });
//         }
//     }, true);
// }
?>

<?php
require 'timer.php';

if ($timerData['status'] != 1) {
    header('Location: index.php');
}

require 'checkuserstatus.php';

if ($userStatus != null) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Chakravyuh Contest</title>

    <!-- Favicons -->
    <link rel='shortcut icon' type='image/x-icon' href='./favicon.ico' />
        
    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">
    <link href="css/banner.css" rel="stylesheet">
    <link href="css/smallTimer_jquery.countdown.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
    < <!-- Custom Fonts -->
        <!--        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #252525;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Chakravyuh</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#home"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#answer">Answer it!</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#hint" onclick="getHints()">Hint</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#leaderboard" onclick="updateLeaderboard()">Leaderboard</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#rules" data-toggle="modal">Rules</a>
                    </li>
                    <li class="page-scroll">
                        <a href="logout.php" onclick="return facebookLogout();">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!--                    <img class="img-responsive" src="img/profile.png" alt="">-->
                    <div class="intro-text">
                        <!--                        <span class="name">Start Bootstrap</span>-->
                        <!-- <div class="grid__item color-11">
                            <a class="link link--yaku" href="#">
                                <span>C</span><span>H</span><span>A</span><span>K</span><span>R</span><span>A</span><span>V</span><span>Y</span><span>U</span><span>H</span>
                            </a>
                        </div> -->
                        <hr class="star-light" style = "margin-top: 200px;">
                        <span class="skills">Hello, <strong><?php echo $_SESSION['name'] ?></strong>. Scroll down to see the question.</span>
                        <br><span class="skills">* This event is only for DUCS students. Inter-college Chakravyuh will also be announced in a few weeks.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Question Grid Section -->
    <section id="answer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center" style = "color: #1eabcb;">
                    <h2>Question: <span id="level-number"></span></h2>
                    <hr class="star-primary" style = "border-color: #1eabcb;">
                </div>
            </div>
            <!--Countdown-->
            <!-- <div id="countdown" class=".col-sm-4"></div> -->
            <!--Countdown-->
            <!--            <div class="container">-->
            <!--            <div class="row">-->
            <div class="col-sm-4 reply text-center">
                <!--                    <img class="img-responsive" src="reply/yes.png" alt="incorrect">-->
                <i class="fa fa-thumbs-down text-center fa-3x" id="incorrect"></i>
            </div>

            <div class="col-sm-4 portfolio-item ques">
                <br>
                <div class="alert alert-success collapse" id="event-completed" role="alert"><strong>Congratulations!</strong> You've successfully completed the game. See your ranking in the leaderboard.</div>
                <div class="alert alert-success collapse" id="event-completed-winner" role="alert"><strong>Congratulations, <?php echo $_SESSION['name'] ?>!</strong> You're the winner of Chakravyuh 2019</div>
                <a href="#enlargeImage" id="ques-image" class="portfolio-link" data-toggle="modal" style="display: none;">
                    <img src="" class="img-responsive img-centered" alt="question">
                    <!-- <div class="caption">
                        <div class="caption-content">
                            <i class="fa fa-search-plus fa-3x"></i>
                        </div>
                    </div> -->
                </a>

                <p id="ques-text" style="display: none;"></p>

                <audio controls id="ques-audio" style="display: none;">
                    Your browser does not support the audio element.
                </audio>

                <video controls id="ques-video" style="display: none;">
                    Your browser does not support HTML5 video.
                </video>
                <br>
                <br>

                <!--            </div>-->
                <!--            </div>-->
                <!--            <div class="row">-->
                <!--            <div class="col-md-4 portfolio-item">-->
                <input type="text" id="input-answer" class="form-control" placeholder="Enter your answer...">
                <br/>
                <!--            </div>-->
                <!-- </div>
        <div class="row">-->
                <!--            <div class="col-md-4 portfolio-item">-->
                <button type="button" id="button-answer" class="btn btn-primary" onclick="submitAnswer()" style = "background-color: #1eabcb;">Submit answer</button>
                <!--                <button type="button" class="btn btn-primary btn-lg btn-block">Enter Answer</button>-->
            </div>
            <!--            </div>-->
            <!--            </div>-->

            <div class="col-sm-4 reply text-center">
                <!--                    <img class="img-responsive" src="reply/no.jpg" alt="correct" </div>-->
                <i class="fa fa-thumbs-up fa-3x" id="correct"></i>
            </div>
    </section>

    <!-- Hint Section -->
    <section class="success" id="hint">
        <div class="container">
            <div class="row">
            <div class="row">
                    <div class="alert alert-warning col-md-12 col-md-offset-0" align="center">
                        <h3>
                        Welcome to the Rush Hour. The bonus hints will now be in boost mode. Lookout for them on the facebook page.
                        </h3>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <h2 class="hinth2">Hint<i class="fa fa-refresh" id="refresh-hints" onclick="getHints()" data-toggle="tooltip" title="Refresh" data-placement="top"></i></h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table hintTable">
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Leaderboard Section -->
    <section id="leaderboard">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center" style = "color: #1eabcb;">
                    <h2 class="ldrbrdh2">Leaderboard<i class="fa fa-refresh" id="refresh-leaderboard" onclick="updateLeaderboard()" data-toggle="tooltip" title="Refresh" data-placement="bottom"></i></h2>
                    <hr class="star-primary" style = "border-color: #1eabcb;">
                </div>
            </div>
            <div class="row">
            <div class="row">
                    <div class="alert alert-warning col-md-12 col-md-offset-0" align="center">
                        <h3>
                        Hello Juniors! The contest is being extended by one hour. We call it the Rush Hour. Hints come in at super speed giving you the power to change the leaderboard. May the best one Win!
                        </h3>
                    </div>
                </div>
                <div class="table-responsive col-lg-12">
                    <table class="table table-hover leaderboardTable table-condensed text-center">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th colspan="2">Player</th>
                                <th>Level</th>
                                <th>Points</th>
                                <th>Split Time</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above" style="background-color: #252525;">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Location</h3>
                        <p>Department of Computer Science, Faculty of Mathematical Sciences
                            <br />University of Delhi
                            <br />Delhi - 110007
                        </p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="https://www.facebook.com/ducs.chakravyuh" class="btn-social btn-outline tool-tip" target="_blank" title="Facebook"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/sankalan_ducs" class="btn-social btn-outline tool-tip" target="_blank" title="Twitter"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Contact Us</h3>
                        <p>Avinash Prasad: (+91) 9555138871
                                <br />Sushmita Yadav: (+91) 8826391168</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below" style="background-color: #101010;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; <a href="index.php">Chakravyuh</a> -
                        <a href="http://ducs.in/" target="_blank">Sankalan 2019</a>,
                        <a href="http://cs.du.ac.in/" target="_blank"> DUCS</a>, University of Delhi </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up" style="position: relative; left: -12%; top: -10%;"></i>
        </a>
    </div>

    <!-- Image and Rules Modals -->

    <div class="portfolio-modal modal fade" id="enlargeImage" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Question</h2>
                            <hr class="star-primary">
                            <!--                            <img src="img/portfolio/cake.png" class="img-responsive img-centered" alt="">-->
                            <img src="" id="ques-image-enlarged" class="img-responsive img-centered" alt="">
                            <p>You can also save the image locally on your system if something is not clear.
                                <br>(<strong>Right click > Save image as</strong>).</p>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Image Modal End-->
    <!--Rules Modal Start-->
    <div class="portfolio-modal modal fade" id="rules" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modal-body chkRules">
                            <h2>RULES</h2>
                            <hr class="star-primary">
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
                                    <br>It shows the time difference of correct answer submission between you and the 1st participant to complete that level. For example, if your split time is + 0:10:13.0000, you were 10 minutes and 13 seconds late in submitting the correct answer to your previous level as compared to the 1st participant completing that same level. If your split time is + 0:0:0.0000, you were the first one to submit the correct answer to your previous level.
                                </li>
                                <li>Only one prize will be awarded:
                                    <br>a) The prize will go to the first player completing all the levels irrespective of points and split time.
                                    <br>b) If no one is able to complete all the levels and the event ends, the player with maximum level will win. If levels are same then points will be considered and if points are same then split time will be considered in deciding the winner.</li>
                            </ol>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Rules Modal End-->
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <script>
    $(document).keypress(function(e) {
        if (e.which == 13) {
            submitAnswer();
        }
    });

    function facebookLogout() {
        FB.logout(function(response) {});
        return true;
    }

    function submitAnswer() {
        var value = $('#input-answer').val();
        if (!value) {
            return;
        }
        $('#input-answer').val('');
        $.ajax({
            type: 'POST',
            url: 'submitanswer.php',
            data: 'value=' + value,
            success: function(response) {
                
                switch (response.trim()) {
                    case 'USER_BLOCKED':
                    case 'THE GAME HAS ENDED':
                    case 'USER_NOT_LOGGED_IN':
                    case 'USER_STATUS_UNREACHABLE':
                        window.location = "index.php";
                        break;

                    case 'ERROR_CONNECTION_FAILURE':
                        alert('Oops! It seems there was a connection failure with the server. Please try again after some time.');
                        break;

                    case 'ERROR_SUBMITTING_ANSWER':
                        alert('Oops! There was an error submitting your answer. Please try again after some time.');
                        break;

                    case 'CORRECT_ANSWER_ERROR_UPDATING':
                        alert('Correct answer! Unfortunately, we faced an issue updating the content. Please try again. Thank you.');
                        break;

                    case 'INCORRECT_ANSWER':
                        $("#incorrect").finish().fadeIn(750).delay(1000).fadeOut(750);
                        break;

                    case '1':
                        $("#incorrect").finish();
                        $("#correct").fadeIn(750).delay(1000).fadeOut(750);
                        updateLeaderboard();
                        setTimeout(getQuestion, 1000);
                        break;
                }
            }
        });
    }

    function clearQuestionArea() {
        $('#level-number').text('');
        $('#ques-text, #ques-image, #ques-audio, #ques-video').css('display', 'none');
    }

    function getQuestion() {
        clearHints();
        clearQuestionArea();

        $.ajax({
            type: 'GET',
            url: 'getquestion.php',
            success: function(response) {
                switch (response) {
                    case 'USER_BLOCKED':
                    case 'THE GAME HAS ENDED':
                    case 'USER_NOT_LOGGED_IN':
                    case 'USER_STATUS_UNREACHABLE':
                        window.location = "index.php";
                        break;

                    case 'ERROR_RETRIEVING_QUESTION':
                        alert('Oops! We were unable to fetch your question. Please refresh your home page after some time.');
                        break;

                    case 'ERROR_CONNECTION_FAILURE':
                        alert('Oops! It seems there was a connection failure with the server. Please try again after some time.');
                        break;

                    case 'EVENT_COMPLETED_WINNER':
                        clearQuestionArea();
                        $('#input-answer').hide();
                        $('#button-answer').hide();
                        $('#event-completed-winner').show(500);
                        break;

                    case 'EVENT_COMPLETED_CONGRATS':
                        clearQuestionArea();
                        $('#input-answer').hide();
                        $('#button-answer').hide();
                        $('#event-completed').show(500);
                        break;

                    default:

                        var quesObj = JSON.parse(response);
                        // var quesObj = response;
                        $('#level-number').text(quesObj['level']);

                        switch (quesObj['type']) {
                            case 'text':
                                $('#ques-text').text(quesObj['data']).css('display', 'inline');
                                break;

                            case 'image':
                                $('#ques-image img').attr('src', quesObj['data']);
                                $('#ques-image-enlarged').attr('src', quesObj['data']);
                                $('#ques-image').css('display', 'inline');
                                break;

                            case 'audio':
                                $('#ques-audio').attr('src', quesObj['data']).css('display', 'inline');
                                break;

                            case 'video':
                                $('#ques-video').attr('src', quesObj['data']).css('display', 'inline');
                                break;
                        }

                        break;
                }
            }
        });
    }

    function getHints() {
        var refreshBtn = $('#refresh-hints');
        refreshBtn.addClass('fa-spin');

        $.ajax({
            type: 'GET',
            url: 'gethint.php',
            success: function(response) {
                switch (response) {
                    case 'USER_BLOCKED':
                    case 'THE GAME HAS ENDED':
                    case 'USER_NOT_LOGGED_IN':
                    case 'USER_STATUS_UNREACHABLE':
                        window.location = "index.php";
                        break;

                    case 'ERROR_RETRIEVING_HINTS':
                        alert('Oops! It seems there was an error while retrieving your hints. Please try again after some time.');
                        break;

                    case 'ERROR_CONNECTION_FAILURE':
                        alert('Oops! It seems there was a connection failure with the server. Please try again after some time.');
                        break;

                    default:
                        // Remove previous hints.
                        clearHints();
                        var obj = JSON.parse(response);
                        var tbody = $('#hint table > tbody');
                        var i;
                        for (i = 0; i < obj.length - 1; i++) {
                            tbody.append('<tr><td>' + (i + 1) + ". " + obj[i] + '</td></tr>');
                        }

                        tbody.append('<tr><td><strong>' + obj[i] + '</strong></td></tr>')
                }

                setTimeout(function() {
                    refreshBtn.removeClass('fa-spin');
                }, 1000);
            }
        });
    }

    function clearHints() {
        $('#hint table > tbody > tr').remove();
    }

    function updateLeaderboard() {
        var refreshBtn = $('#refresh-leaderboard');
        refreshBtn.addClass('fa-spin');

        $.ajax({
            type: 'GET',
            url: 'leaderboard.php',
            success: function(response) {

                switch (response) {
                    case 'USER_BLOCKED':
                    case 'THE GAME HAS ENDED':
                    case 'USER_NOT_LOGGED_IN':
                    case 'USER_STATUS_UNREACHABLE':
                        window.location = "index.php";
                        break;

                    case 'ERROR_UPDATING_LEADERBOARD':
                        alert('Oops! It seems there was an error while updating the leaderboard. Please try again after some time.');
                        break;

                    case 'ERROR_CONNECTION_FAILURE':
                        alert('Oops! It seems there was a connection failure with the server. Please try again after some time.');
                        break;

                    default:
                        // Clear leaderboard.
                        $('#leaderboard table > thead > tr:nth-of-type(2)').remove();
                        $('#leaderboard table > tbody > tr').remove();

                        var ranksArray = JSON.parse(response);

                        // Set current user rank status.
                        var currRankData = ranksArray[0];
                        $('#leaderboard table > thead').append('<tr style="background-color: rgba(196, 205, 207, 0.3);" class="currRow"><th>' + currRankData.rank + '</th><th><img src="' + currRankData.url + '" class="img-responsive" alt="User picture"></th><th> ' + currRankData.name + '</th><th>' + currRankData.level + '</th><th>' + currRankData.points + "</th><th><i class='fa fa-plus'></i>  " + currRankData.splitTime + '</th></tr>')

                        var tbody = $('#leaderboard table > tbody');

                        // Set current 1st rank user.
                        if (ranksArray[1].level > 50) {
                            tbody.append("<tr style=\"background-color: rgba(196, 205, 207, 0.3);\" class=\"colorGreen\"><td data-label='Rank'>" + ranksArray[1].rank + "</td><td data-label='Player'>" + '<img src="' + ranksArray[1].url + '" class="img-responsive" alt="User picture"></td><td><strong>' + ranksArray[1].name + ' [WINNER]' + "</strong></td><td data-label='Level'>" + ranksArray[1].level + "</td><td data-label='Points'>" + ranksArray[1].points + "</td><td class='colorRed' data-label='Split Time'><i class='fa fa-plus'></i>  " + ranksArray[1].splitTime + '</td></tr>');
                        } else {
                            tbody.append("<tr><td data-label='Rank'>" + ranksArray[1].rank + "</td><td data-label='Player'>" + '<img src="' + ranksArray[1].url + '" class="img-responsive" alt="User picture"></td><td>  ' + ranksArray[1].name + "</td><td data-label='Level'>" + ranksArray[1].level + "</td><td data-label='Points'>" + ranksArray[1].points + "</td><td class='colorRed' data-label='Split Time'><i class='fa fa-plus'></i>  " + ranksArray[1].splitTime + '</td></tr>');
                        }


                        // Time to update the remaining leaderboard.
                        for (var i = 2; i < ranksArray.length; i++) {
                            tbody.append("<tr><td data-label='Rank'>" + ranksArray[i].rank + "</td><td data-label='Player'>" + '<img src="' + ranksArray[i].url + '" class="img-responsive" alt="User picture"></td><td>  ' + ranksArray[i].name + "</td><td data-label='Level'>" + ranksArray[i].level + "</td><td data-label='Points'>" + ranksArray[i].points + "</td><td class='colorRed' data-label='Split Time'><i class='fa fa-plus'></i>  " + ranksArray[i].splitTime + '</td></tr>');
                        }
                }

                setTimeout(function() {
                    refreshBtn.removeClass('fa-spin');
                }, 1000);
            }
        });
    }

    getQuestion();
    getHints();
    updateLeaderboard();
    </script>

    <!--   Countdown JavaScript-->
    <script src="js/smallTimer_jquery.countdown.js"></script>
    <script src="js/smallTimer_start.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/freelancer.js"></script>
    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>

</body>

</html>
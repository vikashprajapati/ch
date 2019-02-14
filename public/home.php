<?php include_once("static/_partials/header.php") ?>
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
    <title>Home | Chakravyuh</title>
</head>
<body class="min-h-screen flex flex-col bg-blue-darker">
    <!-- navigation starts here -->
    <?php include_once("static/_partials/nav.php")?>
    <!-- navigation ends here -->

    <!-- main content starts here -->
        <main class="flex-1 flex flex-col">
            <div class="cover h-64 bg-blue-darkest m-10 ">

            </div>
            <div class="question-section flex mb-4 sm:mb-10 flex-col md:flex-row">
                <div class="question px-2  w-full my-8 md:w-1/2 md:px-8 md:border-r md:py-4">
                    <h2 class="text-yellow"><i class="fas fa-question mr-4"></i>Question: <span id="level-number"></span></h2>
                    <div class="image-container flex mt-10 lg:mx-8 flex-wrap  justify-center">
                        <div id = "ques-image" class="w-32 h-32 border border-white mt-2 mx-1 flex-no-shrink"></div>
                    </div>
                    <div class="flex justify-center">
                        <form class="mt-12 pb-4 flex-col md:flex-row items-center">
                            <input id = "input-answer" type="text" class="p-2 w-full md:w-64 focus:border focus:border-yellow" placeholder="Enter your answer">
                            <div class="flex justify-center mt-4">
                                <button id = "button-answer" type="button" class="p-2 bg-yellow" onclick="submitAnswer()" value="submit">submit </button>
                                <span class="flex items-center text-xl text-white"><i id = "status" class="fas mx-4 animated hidden"></i></span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="hints flex flex-col items-center justify-center  px-8 my-8 md:py-4 w-full md:w-1/2">
                    <h1 class="text-yellow"><i class="fas fa-shoe-prints mr-4"></i>Hints<i class="fa fa-refresh mr-4" id="refresh-hints" onclick="getHints()" data-toggle="tooltip" title="Refresh" data-placement="top"></i></h1>
                    <div id = "hint" class="flex justify-center">
                        <table class="">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="leaderboard px-16 mb-16">
                <h1 class="text-yellow my-5">Leaderboard<i class="fa fa-refresh" id="refresh-leaderboard" onclick="updateLeaderboard()" data-toggle="tooltip" title="Refresh" data-placement="bottom"></i></h1>
                <div id = "leaderboard" class="w-full flex justify-center overflow-x-auto">
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
        </main>
    <!-- main content ends here -->

    <!-- footer starts here -->
    <div class=" xl:mt-0 bg-blue-darkest">
        <div class="flex text-center flex-col sm:flex-row">
            <div class="footer-card">
                <h2 class="m-5 text-yellow">Location</h2>
                <p class="m-4 text-white lg:text-left leading-normal" >
                    Department of Computer Science<br>
                    Faculty of Mathematical Science<br>
                    University of Delhi<br>
                    Delhi-110007
                </p>
            </div>
            <div class="footer-card">
                <h2 class="m-5 text-yellow">Around the web</h2>
                <div class="social-links text-2xl">
                    <a href="#" class="fb hover:text-indigo-light"><i class="fab fa-facebook-f mx-2"></i></a>
                    <a href="#" class="twitter "><i class="fab fa-twitter mx-2"></i></a>
                </div>
            </div>
            <div class="footer-card">
                <h2 class="m-5 text-yellow">Contact us</h2>
                <p class="text-white leading-normal">Name1 & contact1</p>
                <p class="text-white leading-normal">Name2 & contact2</p>
            </div>
        </div>
        <?php include_once("static/_partials/footer.php") ?>
    </div>
    <!-- footer ends here -->
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/game.js"></script>

</html>
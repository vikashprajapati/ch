<?php include_once("static/_partials/header.php") ?>
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
    <title>Chakravyuh</title>
</head>
<body class="min-h-screen flex flex-col bg-blue-darker">
    <!-- main content starts here -->
        <main class="flex-1 flex items-center">
            <div class="content flex flex-1 flex-wrap md:flex-row">
                <div class="title-section flex-1 flex flex-col items-center justify-around px-1 sm:px-10">
                    <div class="title-header">
                        <h1 class="title font-display text-yellow-dark text-5xl md:text-8xl relative mt-12 tracking-wide ">Chakravyuh</h1>
                        <p class="font-sans text-center text-white italic mb-12 md:mb-16">Tagline goes here</p>
                    </div>
                    <div class="text-lg mb-4 sm:mb-6 md:mb-8">
                    <div class="alert alert-success collapse" id="login-success" style = "display: none;" role="alert"><strong>Success!</strong> Welcome to the game.</div>
                        <div class="alert alert-danger collapse" id="login-error" role="alert"></div>
                        <div class="alert alert-info collapse" id="login-event-info" role="alert"></div>
                        <a onclick = "loginWithFacebook()" class="fb-login py-3 px-6 font-bold inline-block hover:text-yellow "><i class="fab fa-facebook-f mr-2 font-normal"></i>Login</a>
                    </div>
                    <div class="social-links text-2xl ">
                        <a href="#" class="fb hover:text-indigo-light"><i class="fab fa-facebook-f mx-2"></i></a>
                        <a href="#" class="twitter "><i class="fab fa-twitter mx-2"></i></a>
                    </div>
                    <div class="links mt-8 mb-12 md:mb-12 text-lg font-bold">
                        <a href="#" class="mx-4 text-yellow underline">rules</a>
                        <a href="#" class="mx-4 text-yellow underline">contact</a>
                    </div>
                </div>
                <div class="illustration-section flex-1 flex justify-center">
                    <div class="image text-white hidden md:flex items-center">
                        <svg class="w-normal" data-name="Layer 1" version="1.1" viewBox="0 0 989.05 989.27" xmlns="http://www.w3.org/2000/svg">
                        <title>maze_stroke</title>
                        <g fill="none" stroke="currentColor" stroke-width="10px" stroke-linecap="round" stroke-linejoin="round"> 
                            <path transform="translate(-467.46 -53.44)" d="M1441.43,453.94c7.73,7.41,7.39,18,8.13,26.93,2.67,32.15,6.36,64.16,3.26,96.83-2.72,28.63-6,57-12.56,84.9a477.24,477.24,0,0,1-56.9,139.87A490.74,490.74,0,0,1,1245.79,950a497.67,497.67,0,0,1-168,77,429.69,429.69,0,0,1-60.13,10.37c-13.29,1.38-26.75,3.49-39.81,2.38-20.52-1.74-40.91,2.16-61.36-.55-31.93-4.24-63.81-9.21-94.58-18.61-57.33-17.52-110.46-43.63-158.27-80.35a496.68,496.68,0,0,1-129-147.46c-7.62-13.23-16.12-26.18-20.23-40.94-5.23-18.81-16.77-34.86-21.83-53.7-4.89-18.24-10.45-36.27-13.93-54.88-4.85-26-9.72-52.14-8.12-78.51,1.24-20.51-2.21-40.91.56-61.35,3.79-27.85,8-55.63,15.29-82.78,3.82-14.21,9.18-28,13.81-42,.21-.65-.28-1.7.07-2.1,11.58-12.89,11.08-30.93,19.33-45.21,8.92-15.44,17.75-30.94,26.93-46.23,10.06-16.78,21.88-32.28,34.29-47.43,45-54.91,99-98.52,162.56-130A495.18,495.18,0,0,1,863.74,66.45c32.41-6.68,65.11-8.75,97.94-10.52"/>
                            <path transform="translate(-467.46 -53.44)" d="M961.67,774.5q0-55.94,0-111.87c0-13.47,2.23-16,15.05-17.19,14.16-1.27,26.69-7,38.71-14,29.55-17.32,42.22-45.65,44.57-77.48,2.25-30.43-9.14-57.34-32.61-78.62-18.87-17.11-41.21-25.52-65.74-25.27-31.28.32-57.87,12.61-77.56,38.23-10.65,13.87-16.27,29.14-19.59,46.27-5.26,27.18,3.83,50,17.55,72.13,2.46,4,5,7.89,7.52,11.84"/>
                            <path transform="translate(-467.46 -53.44)" d="M1148.84,97.89c7.33-1,13.87,1.13,20.47,4.22,46.66,21.87,89.78,49.41,126.44,85.52,14.37,14.16,30.08,27.33,42.47,43.59s25.57,32.13,36.46,49.56A530.28,530.28,0,0,1,1401.9,329c7.92,16.23,14.73,32.81,21.48,49.52,7.38,18.24,12.31,37.05,17,56,1.55,6.21,2.5,12.21-.43,19.15-19.39,2.21-38.36,9.91-58.8,8.88-7.83-.39-13.82,5.29-21.38,7-14.09,3.15-28.62,4.09-42.44,10.48-8.6,4-20.56,1.2-30.87,3.89-7.74,2-15.89,2.47-23.59,4.58-6.51,1.78-10.55,4.79-9,13.89,4,23.42,2.84,47.26,2.31,70.93-.23,10.43-3.05,20.77-3.94,31.21-.45,5.29-5.26,1.67-6.62,4.29"/>
                            <path transform="translate(-467.46 -53.44)" d="m793.86 303.35c-19.07 17.85-40.06 33.57-57.12 53.65-33.36 39.35-54.49 84.59-65.21 134.62-4 18.56-5.92 37.74-4.6 56.95"/>
                            <path transform="translate(-467.46 -53.44)" d="m1231.7 662.63c-12.3-10.27-28.27-12.93-42.07-20.21-14.62-7.72-14.47-6.76-9.69-21.78 8.55-26.87 13.38-54.62 11.63-82.77-1.27-20.38-6.48-40.35-10.79-60.41-3-13.77-9.48-24.81-15.87-36.36a256.71 256.71 0 0 0-27.81-41c-33.85-40.36-77.06-65-128.08-76.23-36.81-8.08-73.51-7.4-109.7 4.18-24.81 7.94-26.48 6.59-36.67-18.23-20.81-50.7-42.21-101.16-63.36-151.72"/>
                            <path transform="translate(-467.46 -53.44)" d="m799.24 371.12c2.15 11.26-2.89 18.84-10.48 27.15-28.36 31.09-45.33 68.06-53.05 109.45-8.08 43.31-3.09 85.12 13 125.87"/>
                            <path transform="translate(-467.46 -53.44)" d="M1047.73,129.62c-3-.1-4.52,3.66-8.7,1.82-17.75-7.82-37-8.1-55.85-8.61-25.1-.69-50.35-1.57-75.27,2.12-31.13,4.62-62.15,10.67-91.38,22.61-39.54,16.15-78.17,33.9-112.14,60.89-33,26.19-63,54.72-87,89.45-5.84,8.44-12.25,17.17-24.63,16.21"/>
                            <path transform="translate(-467.46 -53.44)" d="m800.32 389.4c13 8.39 22.18 20.85 33.3 31.25 11.48 10.74 11.38 11 23.7 1 24.59-20 52.84-33.26 84-36.09 64.59-5.87 118 16.52 155.8 70.62 19.26 27.54 29.35 58.38 28.1 92.42"/>
                            <path transform="translate(-467.46 -53.44)" d="M592.71,783.11c3.23.36,6.59.26,9.64,1.2,3.5,1.07,8,.34,9.78,5.24,6.41,17.18,19.52,29.77,31.33,42.88,37.82,42,81.87,76,133.2,100.19,4.94,2.32,10.74,3.43,14.87,6.7,5.22,4.15,9.4,2.82,14.16.31"/>
                            <path transform="translate(-467.46 -53.44)" d="m710 804.62c7.35 13.2 20.16 21.05 31.42 29.83 38.76 30.2 82.49 50.94 129.94 63.71 5.29 1.42 10.74 2.2 16.12 3.27"/>
                            <path transform="translate(-467.46 -53.44)" d="M1052,68.84c8.12-4.83,15.89-.57,23.65,1.14,19.76,4.35,39,10.48,58.06,17.26,14.77,5.26,15.57,8.49,9.77,22.5q-33.55,81.13-66.75,162.41"/>
                            <path transform="translate(-467.46 -53.44)" d="m1139.2 301.2c-11.17 3.24-20.45-1-29-7.55-10.15-7.79-23.06-10.77-32.68-20-3.71-3.56-12.11-1.7-17.85-3.78-31.33-11.35-63.82-16.17-96.87-16.83a234.47 234.47 0 0 0-47.23 3.49c-8.89 1.65-12.91-3-13.65-8.09-2.47-16.86-8.33-33.21-8-50.49"/>
                            <path transform="translate(-467.46 -53.44)" d="M762.67,237.73c.5,10.18-5.76,14.28-13.68,19.8-28.29,19.73-52.43,44.12-73.57,71.55a332.36,332.36,0,0,0-38.72,63.51c-2.48,5.36-6.34,10.09-9.57,15.11"/>
                            <path transform="translate(-467.46 -53.44)" d="M1123,714.26c-18.78,13.24-35.79,28.92-56.94,38.88s-42.58,17.76-65.66,21.52c-13.33,2.17-26.75.63-39.76,1.69-25,2-47.67-4.06-71.21-9.81-11.34-2.77-21.44-6.33-31.06-12.43-11-7-22.39-13.38-33.25-20.59-5.47-3.63-9.63-9.32-15.24-12.61-10.07-5.91-12-14.52-10.65-24.92"/>
                            <path transform="translate(-467.46 -53.44)" d="M1387.65,548.61c1.09,22.39-1.76,44.53-4.3,66.69,0,.35.14.81,0,1.06-10.26,15.77-5,35-11.58,51.74-6.86,17.39-12,35.48-19.6,52.62-8,17.93-16.61,35.53-28,51.64-16.37,23.23-31.06,47.63-51.37,68-7.21,7.24-14.15,10.8-23.93,9.42"/>
                            <path transform="translate(-467.46 -53.44)" d="M1318.8,298c0,2.71-1.36,5.24-1.77,7.6-.82,4.74-.69,9,3.44,14.29,16.18,20.93,27.11,45.08,37,69.56A393,393,0,0,1,1379,461.47"/>
                            <path transform="translate(-467.46 -53.44)" d="M474.38,548.61c16.14,0,32.28.24,48.4-.09,9.62-.2,13.09,3.38,13,13-.21,23.65,2.29,47,8.51,69.92"/>
                            <path transform="translate(-467.46 -53.44)" d="M555.06,467.93c13.27,2.51,26.56,4.91,39.79,7.57,8.95,1.8,12.25,6.22,10.7,15-5.58,31.78-6,63.79-2.74,95.7.87,8.51-.78,18.34,6,25.91,3.13,3.5-.57,6.48-1.56,9.63"/>
                            <path transform="translate(-467.46 -53.44)" d="M804.62,472.23c5.63,8,5,15.75,1.38,24.86-5,12.54-7.32,26-7.85,39.68-.32,8.29,3.56,12,11.85,11.89,16.49-.18,33-.05,49.48-.05"/>
                            <path transform="translate(-467.46 -53.44)" d="m512 362.51c33.71 14 67.34 28.13 101.16 41.83 8.27 3.35 18.48 3.69 18.24 16.25"/>
                            <path transform="translate(-467.46 -53.44)" d="m1125.2 797.09c-12.32 2.88-22.1 11-33.27 16.29-17.76 8.38-36.27 14.35-54.79 20.7-32.58 11.17-65.86 9.1-99.11 8.93-7.39 0-15.45-0.32-22.47-2.25-8.81-2.43-12.49 2.86-13.76 8.05-4.23 17.23-9 34.65-12 51.76-3.15 18-6.62 36.31-8.75 54.65"/>
                            <path transform="translate(-467.46 -53.44)" d="M1128.41,779.88c-5.29,11.34.12,20.25,6.44,29.05,34.05,47.44,65.07,96.94,97.9,145.21"/>
                            <path transform="translate(-467.46 -53.44)" d="m623.9 692.75c-7-4-12.55 1-18.24 3.35-31.3 12.66-62.44 25.7-93.63 38.61"/>
                            <path transform="translate(-467.46 -53.44)" d="m1286.5 408.76c0.08 5.82-4.33 6.91-8.58 8.67q-42.57 17.57-85 35.46c-4.73 2-9.33 4.28-14 6.43"/>
                            <path transform="translate(-467.46 -53.44)" d="m713.19 715.34c-30.84 20.44-61.73 40.79-92.44 61.42-3.71 2.49-8 4.85-9.75 9.57"/>
                            <path transform="translate(-467.46 -53.44)" d="m1211.2 715.34c33.67 23 68.64 44.09 101.12 68.84"/>
                            <path transform="translate(-467.46 -53.44)" d="m1314.5 315.18c-18.54 6.67-32.67 20.58-49.37 30.31-13.8 8-26.48 18-40 26.6-7.8 5-11.61 11.36-10.69 20.54"/>
                            <path transform="translate(-467.46 -53.44)" d="m1231.7 293.67c-10.66-1.35-18.23 1.93-26.17 10.43-25.59 27.41-52.72 53.39-79.25 79.93"/>
                            <path transform="translate(-467.46 -53.44)" d="M1130.56,928.33c-2.67,10.83-9.38,16.06-20.27,19.84-18.11,6.27-36.2,12-55,16-3,.64-5.09-.87-7.6-.33"/>
                            <path transform="translate(-467.46 -53.44)" d="M961.67,187.17c-18.65,1.43-37.29,2.82-55.93,4.33-5.79.47-10.55,7.69-17.21,2.66"/>
                            <path transform="translate(-467.46 -53.44)" d="m1316.6 481.91c3.91 22.06 5.39 44.36 6.45 66.69"/>
                            <path transform="translate(-467.46 -53.44)" d="m1027.3 902.51c-21.12 6.09-42.83 6.33-64.54 6.45"/>
                            <path transform="translate(-467.46 -53.44)" d="M1311.81,612.07c4,5.41,4.08,10.39,2,17.33-5.49,18.38-10.5,36.91-17.78,54.67-1.54,3.75.52,5.85,1.25,8.68"/>
                            <path transform="translate(-467.46 -53.44)" d="m1196.2 179.64c0.19 10.3 5 17.29 13.89 22.75 15.47 9.52 28.95 21.7 42.14 34.17 3.34 3.15 7.8 5.12 11.74 7.63"/>
                            <path transform="translate(-467.46 -53.44)" d="m1216.6 788.49c2.06 11-2.54 18.61-10.62 26a360.31 360.31 0 0 1-96 63c-9.17 4.1-13.33 10.12-16 18.62"/>
                            <path transform="translate(-467.46 -53.44)" d="m1019.8 842.27c3.19 19.31 11 37.87 8.79 58.11-0.74 6.9 5.45 12.06 6.91 19.21 2.88 14.05 3.2 29 10.24 42 2.63 4.85-2.38 6.4-2.82 9.75"/>
                            <path transform="translate(-467.46 -53.44)" d="M670.16,608.84c-13.41-1.85-25.79,3.77-38.73,5.35C624.65,615,618,618,611,615.3"/>
                            <path transform="translate(-467.46 -53.44)" d="m807.85 614.22c-13.94 1.8-25.65 9.8-38.74 13.94-26.32 8.32-50.11 22.78-76.36 31.24"/>
                            <path transform="translate(-467.46 -53.44)" d="M1374.74,630.36c-17.21-3.23-34.41-6.51-51.65-9.59-1.68-.3-3.57.63-5.36,1"/>
                            <path transform="translate(-467.46 -53.44)" d="m1110.7 602.39c5.78 11-1.41 20-6.36 27.68a194.56 194.56 0 0 1-27.7 33.48c-11.07 10.81-22.35 20.26-35.36 28.05-5.49 3.29-11.43 5.81-17.17 8.68"/>
                            <path transform="translate(-467.46 -53.44)" d="M812.69,602.39,809,614.29c7.82,11.75,14.66,24.47,23.8,35.24,16.84,19.86,36.14,37.19,60,48.6,5.14,2.46,10.09.9,15.06-.54"/>
                            <path transform="translate(-467.46 -53.44)" d="m675.54 600.24c-3.55 4.79-4.65 8.92-1.45 15.25 3.76 7.43 3.35 17 7.09 24.42 9.74 19.41 15.79 40.29 26.13 59.56 8.88 16.54 21.36 29.61 32.73 43.87 3.53 4.42 7.86 8.34 9.72 14"/>
                            <path transform="translate(-467.46 -53.44)" d="M872.39,765.9A430.47,430.47,0,0,0,855,806.72c-1.58,4.29-4.88,7.94-7.39,11.89"/>
                            <path transform="translate(-467.46 -53.44)" d="m1147.8 250.64c12.56-3.75 22.15 1.36 31.28 9.59 12.07 10.88 26.43 19.29 35.41 33.44"/>
                            <path transform="translate(-467.46 -53.44)" d="m761.59 252.79c14 14.39 24.19 31.24 33.45 49.6 4.63 2.57 11.16 1.17 17.11 3.11"/>
                            <path transform="translate(-467.46 -53.44)" d="m1244.6 657.25c-7.44 2.06-13.17 5.44-15.19 14-3.76 15.79-17.15 27.51-19.23 44.14-13.51 7.52-18.37 23.82-30.48 31.72-10.52 6.86-9 15.12-9.32 24.22"/>
                            <path transform="translate(-467.46 -53.44)" d="m961.67 985.34v50.56"/>
                            <path transform="translate(-467.46 -53.44)" d="m1041.3 133.39c2.28 14.16-2.84 27.36-5.46 40.86-1 5.25-1.6 10.23 1.16 15.08"/>
                            <path transform="translate(-467.46 -53.44)" d="m784.18 796c11.2-3.36 20.06 1.72 29.12 7.4 7.86 4.92 16 10 24.77 12.69 8.51 2.65 12.59 7.73 15 15.41"/>
                            <path transform="translate(-467.46 -53.44)" d="m767 757.29c-10.27-1.06-18.11 1-25.14 10.46-9.13 12.32-20.94 22.7-32 33.56-5.18 5.11-12.16 1.1-18.21 2.23"/>
                            <path transform="translate(-467.46 -53.44)" d="M1124.1,696c-1.33,10.65.67,19.05,10.54,26.12,12.94,9.27,21.22,24.14,35.72,32"/>
                            <path transform="translate(-467.46 -53.44)" d="m906.81 618.53c-10.66-1.35-18.8 1.21-26.15 10.49-9.38 11.85-21.18 21.78-31.94 32.54"/>
                            <path transform="translate(-467.46 -53.44)" d="m1305.9 204.38c-12.91 12.55-25.67 25.25-38.79 37.58-6.28 5.91-1.77 13-3.17 19.43"/>
                            <path transform="translate(-467.46 -53.44)" d="m875.62 333.47c-4 4.65-4.49 10.68-6.45 16.14"/>
                            <path transform="translate(-467.46 -53.44)" d="m1176.8 635.74-16.14 5.38"/>
                            <path transform="translate(-467.46 -53.44)" d="m845.5 430.28v16.14"/>
                            <path transform="translate(-467.46 -53.44)" d="m1201.6 375.42 14 3.23"/>
                            <path transform="translate(-467.46 -53.44)" d="m798.17 711h-14"/>
                            <path transform="translate(-467.46 -53.44)" d="m1198.3 194.7c-5-1.34-9.23 2-14 2.15"/>
                            <path transform="translate(-467.46 -53.44)" d="m1217.7 803.55h14"/>
                            <path transform="translate(-467.46 -53.44)" d="m794.94 779.88 2.15 14"/>
                            <path transform="translate(-467.46 -53.44)" d="m607.77 312c-1.34 5 2 9.23 2.15 14"/>
                            <path transform="translate(-467.46 -53.44)" d="m1126.2 304.42c-1.35 4.65 2.48 8.43 2.15 12.91"/>
                            <path transform="translate(-467.46 -53.44)" d="m1262.9 850.88v12.91"/>
                            <path transform="translate(-467.46 -53.44)" d="m1126.2 606.69-11.83 4.3"/>
                            <path transform="translate(-467.46 -53.44)" d="m1014.4 696c3.42 1.44 7.33 2 9.7 5.41l-4.32 11.8"/>
                            <path transform="translate(-467.46 -53.44)" d="m1286.5 415.22 11.83 4.3"/>
                        </g>
                        </svg>
                    </div>
                    <div class="event-details flex flex-col items-center justify-around p-8  border-t border-b">
                        <div>
                            <h2 class="text-white my-2 text-center mb-4">The game begins on</h2>
                            <h3 class="font-semibold text-yellow text-center my-1">21 Febraury, 2019</h3>
                        </div>
                        <div>
                            <h2 class="text-center text-yellow my-4">Countdown</h2>
                            <div class="flex timer text-white text-xl">
                                <div>
                                    <div class="p-4 border mx-2" id = "days"></div>
                                    <p class="text-center my-2 text-xs uppercase">days</p>
                                </div>
                                <div>
                                    <div class="p-4 border mx-2" id = "hours"></div>
                                    <p class="text-center my-2 text-xs uppercase">hours</p>
                                </div>
                                <div>
                                    <div class="p-4 border mx-2" id = "mins"></div>
                                    <p class="text-center my-2 text-xs uppercase">min</p>
                                </div>
                                <div>
                                    <div class="p-4 border mx-2" id = "secs"></div>
                                    <p class="text-center my-2 text-xs uppercase">sec</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <!-- main content ends here -->

    <!-- footer starts here -->
    <?php include_once("static/_partials/footer.php") ?>
    <!-- footer ends here -->
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="js/timer.js"></script>
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
</html>
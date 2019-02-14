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
                    $("#status").removeClass('hidden flip fa-check-circle')    
                    $("#status").addClass('block flip fa-times-circle');
                    break;

                case '1':
                    $("#status").removeClass('hidden flip fa-times-circle')
                    $("#status").addClass('block flip fa-check-circle')
                    updateLeaderboard();
                    setTimeout(getQuestion, 1000);
                    break;
            }
        }
    });
}

function clearQuestionArea() {
    $('#level-number').text('');
    $('#ques-image').css('display', 'none');
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
                        // case 'text':
                        //     $('#ques-text').text(quesObj['data']).css('display', 'inline');
                        //     break;

                        case 'image':
                            $('#ques-image img').attr('src', quesObj['data']);
                            $('#ques-image-enlarged').attr('src', quesObj['data']);
                            $('#ques-image').css('display', 'inline');
                            break;

                        // case 'audio':
                        //     $('#ques-audio').attr('src', quesObj['data']).css('display', 'inline');
                        //     break;

                        // case 'video':
                        //     $('#ques-video').attr('src', quesObj['data']).css('display', 'inline');
                        //     break;
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
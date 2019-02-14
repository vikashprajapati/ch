function updateTimer(remaining) {
    var tmpId;

    // calling function first time so that it wll setup remaining time
    var _changeTime = function() {

        _dd = remaining * 1000;
        remaining--;
        
        _dday = Math.floor(_dd / (60 * 60 * 1000 * 24) * 1);
        _dhour = Math.floor((_dd % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
        _dmin = Math.floor(((_dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
        _dsec = Math.floor((((_dd % (60 * 60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);
        
        $('#days').text(_dday);
        $('#hours').text(_dhour);
        $('#mins').text(_dmin);
        $('#secs').text(_dsec);

        if (remaining < 0 && tmpId != undefined)
        {
            clearInterval(tmpId);
            location.reload();
        }
    };

    if (remaining > 0)
    {
        _changeTime();
        tmpId = setInterval(_changeTime, 1000);
    }
    else
    {
        _dd = 0;
        
        _dday = Math.floor(_dd / (60 * 60 * 1000 * 24) * 1);
        _dhour = Math.floor((_dd % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
        _dmin = Math.floor(((_dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
        _dsec = Math.floor((((_dd % (60 * 60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);
        
        $('#days').text(_dday);
        $('#hours').text(_dhour);
        $('#mins').text(_dmin);
        $('#secs').text(_dsec);
    }
}

function getRemaningTimeFromServerAndStartTimer() {
    $.ajax({
        url: "timer.php",
        type: "GET",
        data: "operation=difference",
        success: function (response) {
            var obj = JSON.parse(response);
            $("#gameStatus").text(obj['message']);
            updateTimer(obj['value']);
        }
    });
}

getRemaningTimeFromServerAndStartTimer();
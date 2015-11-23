/**
 * JBZoo is universal CCK, application for YooTheme Zoo component
 * @package     JBZoo
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com
 * @license     http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

jQuery(function ($) {

    var totalLines = 0,
        timerId = 0,
        secondsPassed = 0,
        currentProgress = 0,
        page = 0,
        stopFlag = true;

    function updateData(data) {

        totalLines = totalLines + data.lines;

        $('.jsProgressbar .barInner').animate({'width':data.progress + '%'});
        $('.jsProgressbar .value').text(data.progress + '%');
        $('.jsProgressbar .js-totallines').text(totalLines);

        $.each(data, function (key, data) {
            $('.js-' + key).text(data);
        });

        currentProgress = data.progress;
    }

    function request(page) {

        if (stopFlag) {
            return;
        }

        $.post('index.php',
            {
                'option'    :'com_zoo',
                'tmpl'      :'component',
                'controller':'jbtools',
                'task'      :'checkdbajax',
                'page'      :page
            },
            function (data) {
                if (data.progress != 100) {
                    page++;
                    request(page);
                    updateData(data);
                } else {
                    timerStop();
                    updateData(data);
                }
            },
            'json'
        );
    }

    function timerStart() {

        secondsPassed = 0;
        $('.jsProgressbar .jsLoader').show();
        $('.jsProgressbar .jsStart').hide();
        $('.jsProgressbar .jsStop').show();

        timerId = setInterval(function () {
            secondsPassed++;
            $('.jsProgressbar .js-timepassed').text(timeFormat(secondsPassed));

            var seconsRemaining = parseInt((secondsPassed * 100 / currentProgress) - secondsPassed, 10);

            $('.jsProgressbar .js-timeremaining').text(timeFormat(seconsRemaining));

        }, 1000);
    }

    function timerStop() {
        clearInterval(timerId);
        $('.jsProgressbar .js-timeremaining').text(timeFormat(0));
        $('.jsProgressbar .jsLoader').hide();
        $('.jsProgressbar .jsStart').show();
        $('.jsProgressbar .jsStop').hide();
    }

    function timeFormat(seconds) {

        if (seconds <= 0 || isNaN(seconds)) {
            return '00:00';
        }

        var formatedMin = Math.floor(seconds / 60),
            formatedSec = seconds % 60;

        if (formatedSec < 10) {
            formatedSec = '0' + formatedSec;
        }

        if (formatedMin < 10) {
            formatedMin = '0' + formatedMin;
        }

        return formatedMin + ':' + formatedSec;
    }

    $.fn.JBZooReIndex = function () {

        return $(this).each(function (n, obj) {

            var $obj = $(obj),
                $start = $obj.find('.jsStart'),
                $stop = $obj.find('.jsStop');

            $start.click(function () {
                $start.hide();
                $stop.show();
                timerStart();
                stopFlag = false;
                request(0);
            });

            $stop.click(function () {
                if (confirm('Are you sure?')) {
                    stopFlag = true;
                    page = 0;
                    timerStop();
                    $start.show();
                    $stop.hide();
                }
            });

        });
    };

    $('.jsProgressbar').JBZooReIndex();
});
$(function() {

    // just a super-simple JS demo

    var demoHeaderBox;

    // simple demo to show create something via javascript on the page
    if ($('#javascript-header-demo-box').length !== 0) {
    	demoHeaderBox = $('#javascript-header-demo-box');
    	demoHeaderBox
    		.hide()
    		.text('Hello from JavaScript! This line has been added by public/js/application.js')
    		.css('color', 'green')
    		.fadeIn('slow');
    }

    // if #javascript-ajax-button exists
    if ($('#javascript-ajax-button').length !== 0) {

        $('#javascript-ajax-button').on('click', function(){

            // send an ajax-request to this URL: current-server.com/songs/ajaxGetStats
            // "url" is defined in views/_templates/footer.php
            $.ajax(url + "/songs/ajaxGetStats")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    $('#javascript-ajax-result-box').html(result);
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed
                })
                .always(function() {
                    // this will ALWAYS be executed, regardless if the ajax-call was success or not
                });
        });
    }

    // load audio
    $(function(){
        if($('audio').length > 0){
            // Setup the player to autoplay the next track
            var a = audiojs.createAll({
                trackEnded: function() {
                    var next = $('tr td.mangeplay.playing').next();
                    if (!next.length) next = $('tr td').first();
                    next.addClass('playing').siblings().removeClass('playing');
                    audio.load($('a', next).attr('data-src'));
                    audio.play();
                }
            });

            // Load in the first track
            var audio = a[0];
            first = $('tr td.mangeplay a').attr('data-src');
            $('tr td.mangeplay').first().addClass('playing');
            audio.load(first);

            // Load in a track on click
            $('tr td.mangeplay').click(function(e) {
                e.preventDefault();
                $(this).addClass('playing').siblings().removeClass('playing');
                audio.load($('a', this).attr('data-src'));
                audio.play();
            });


        }


    });


});

 var init = (function(){
     "use strict"

    var defaultPhoto = function(){
        $(document).ready(function(){
            $('.inner li:first').addClass("active");
        });
    }

    var timer = function(){
        $(document).ready(function(){
            var d = new Date();
            var time = d.getHours() + ":" ;
            var min = d.getMinutes();
            if(min < 10)
                $('.time-today').html(time + "0" + min);
            else 
                $('.time-today').html(time + min);
        });
    
    }

    //SCROLL THROUGH THE LIST ELEMENTS
    var scroller = function(){
        var photo_li = $('#photos').find('li.active');
        var plex_li = $('#plex').find('li.active');
        var cal_li = $('#calendar').find('li.active');

        //loop through photo list elements
        if( photo_li.next().is("li")){
            photo_li.next("li").addClass("active");
        } else {
            // $('.inner li:first').addClass("active");
            $('#photos li:first').addClass("active");
        }

        photo_li.removeClass("active");

        //loop through plex list elements
        if( plex_li.next().is("li")){
            // plex_li.next("li").addClass("active").show("slide", {direction: "left"}, 1000);
            // plex_li.next("li").addClass("active").show();
            plex_li.next("li").addClass("active").toggle("slide");
        } else {
            // $('#plex li:first').addClass("active").show("slide", {direction: "left"}, 1000);
            // $('#plex li:first').addClass("active").show();
            $('#plex li:first').addClass("active").toggle("slide");
        }
        // plex_li.removeClass("active").hide("slide", {direction: "right"}, 1000);
        plex_li.removeClass("active").toggle("slide");

        //loop through calendar list elements
        // cal_li.fadeOut();
        if( cal_li.next().is("li")){
            cal_li.next("li").addClass("active").slideDown();
            // cal_li.next("li").fadeIn();
        } else {
            $('#calendar li:first').addClass("active").slideDown();
            // $('#calendar li:first').fadeIn();
        }
        cal_li.removeClass("active").slideUp();

    }

    var refreshWeather = function(){
        $.ajax({
            url: "/home/getWeather",
            dataType: "json",

        }).done(function(data){
            // console.log(data);
            // $('#weather').html(data.content);
            $('#weather').prepend(data.content);
        });

    }

    var refreshPlex = function(){
        $.ajax({
            url: "/home/getPlexRecentAdded",
            dataType: "json"
        }).done(function(data){
            $('#plex .plex-inner').html(data.content);
            $('.content > .plex-inner > li:first').addClass("active").fadeIn("slow");
        });
    }

    var refreshDate = function(){
        $(document).ready(function(){
            var d = new Date();
            var datetime = d.toDateString();
            $('.date-today').html(datetime);
        });
    }

    var refreshCalendar = function(){
        $.ajax({
            url: "/home/getCalendarEvents",
            dataType: "json"
        }).done(function(data){
            if(!data.success){
                window.location.href="/home/newCalendarClient";
                // $('#calendar').html("Cannot retreive data");
            } else {
                $('#calendar').html(data.content);
                //Calendar
                // $('#calendar li:first').addClass("active");
                $('#calendar li:first').addClass("active").fadeIn("slow");
            }
        });

    }
    
    //AUTO REFRESH THE DATA VIA THE INTERVALS
    var autoTimer = function(){

        setInterval(scroller, 9000);
        setInterval(timer, 60000); //refresh time every minute
        setInterval(refreshWeather, 3600000); //refresh weather every hour
        setInterval(refreshPlex, 3600000); //refresh weather every hour
        setInterval(refreshDate, 7200000); //refresh date every 2 hours
        setInterval(refreshCalendar, 7200000); //refresh calendar every 2 hours
    }

    var photos = function(){
        defaultPhoto();
    }

    var init = function(){
        autoTimer();
        timer();
        refreshDate();
        refreshWeather();
        refreshPlex();
        refreshCalendar();
    }

   return {

        init: init,
        photos: photos

   }


})();
init.init();
init.photos();

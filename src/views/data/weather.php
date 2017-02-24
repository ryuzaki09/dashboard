<?php
$x = 1;
$today = date("d/m/Y");
if(isset($weather['list']) && !empty($weather['list'])):
    // array_shift($data['weather']['today']);
    // array_shift($data['weather']['today']);
    // array_shift($data['weather']['today']);
    // array_shift($data['weather']['today']);
    echo "<div class='today'>";
    foreach($weather['list'] AS $time):
        if($x > 4) break;
        if($x === 1) {
            echo "<div class='main'>";
            // echo date("F d, D", strtotime($time['dt_txt']))."<br />";
        } else {
            echo "<div class='later'>";
        }
        if(date("d/m/Y", strtotime($time['dt_txt'])) != $today)
            echo "<div>Tomorrow</div>";

        echo strstr($time['dt_txt'], " ")."<br />";
        echo $time['weather'][0]['description']."<br />";
        echo "wind: ".$time['wind']['speed']."<br />";
        echo "<div class='".Home::getIcon($time['weather'][0]['icon'])."'></div>";
        echo "<div class='deg'>".$time['main']['temp']."&deg;C</div>";

        echo "</div>";

        $x++;

    endforeach;
    // if($x > 4) //IF there are 4 weather data then close the <div class='today'>
    echo "</div>";

endif;



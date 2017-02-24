<div class="container">
    <div class="left_col">
    <div class="clearfix">
        <div id="calendar">
            <div class="time-today"></div>
            <?php
            if(isset($events['items']) && is_array($events['items']) && !empty($events['items'])){
                foreach($events['items'] AS $event):
                    echo $event['summary']."<br />";
                    echo date("d M H:i", strtotime($event['start']['dateTime'])).
                        " - ".date("d M D H:i", strtotime($event['end']['dateTime']))."<br />";
                endforeach;

            } else {
                echo "No upcoming events";
            }
            ?>
        </div>
            <!-- <div class="clearfix"> -->
        <div id="photos">
            <div class="inner">
                <?php
                if(is_array($photos) && !empty($photos)){
                    foreach($photos AS $photo):
                        echo "<li><img src='".$photo."' /></li>";
                    endforeach;
                }
                ?>
            </div>
        </div>
        <!-- </div> -->
    </div>
    </div>
    <div id="weather" class="weather"> </div>
    <?php
        // print_r($plex_recent_data);
    ?> 
</div>


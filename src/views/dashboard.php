<div class="container">
    <div class="left_col">
        <div class="row1 clearfix">
            <div id="datetime">
                <div class="time-today"></div>
                <div class="date-today"></div>
            </div>
            <div id="calendar" class="box-container">
                <?php
                // $now = new DateTime(date("Y-m-d"));
                // if(isset($events['items']) && is_array($events['items']) && !empty($events['items'])){
                //     foreach($events['items'] AS $event):
                //         $starttime = date("Y-m-d", strtotime($event['start']['dateTime']));
                //         $eventdate = new DateTime($starttime);
                //         // $eventdate = date("Y-m-d", strtotime($event['start']['dateTime']));
                //         $diff = $now->diff($eventdate);
                //         // echo "<!-- datetime ".$eventdate->date."  -->";
                //         echo "<li><div class='heading-grey'>".$event['summary']."</div>";
                //         echo "<div class='start-time'>";
                //         echo "<div class='sub-heading'>Start</div>";
                //         echo "<div class='cal-time'>".date("d M D H:i", strtotime($event['start']['dateTime']))."</div>";
                //         echo "</div>";
                //         echo "<div class='end-time'>";
                //         echo "<div class='sub-heading'>End</div>";
                //         echo "<div class='cal-time'>".date("d M D H:i", strtotime($event['end']['dateTime']))."</div>";
                //         echo "</div>";
                //         echo "<div class='time-diff'>".$diff->format('%a day(s) away')."</div>";
                //         echo "</li>";
                //     endforeach;

                // } else {
                //     echo "No upcoming events";
                // }
                ?>
            </div>
        </div>
        <div class="row2 clearfix">
            <div id="plex" class="content">
                <div class="plex-inner"> </div>
            </div>
            <div id="photos" class="content">
                <div class="inner">
                    <?php
                    if(is_array($photos) && !empty($photos)){
                        $i = 0;
                        foreach($photos AS $photo):
                            // echo "<li><img src='".$photo."' /></li>";
                            // echo "<li>$i</li>";
                            $i++;
                        endforeach;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div><!-- left-col -->
    <div id="weather" class="weather"> 
        <div id="gmaps">
            <iframe 
            width="450"
            height="430"
            frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/directions?key=<?php echo $gmaps_key; ?>&origin=IG7+5NW&destination=E16+3PX&avoid=tolls|highways&mode=driving" ></iframe>
        </div>
    </div>
</div>


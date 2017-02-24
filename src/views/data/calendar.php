<?php
$now = new DateTime(date("Y-m-d"));
if(isset($events['items']) && is_array($events['items']) && !empty($events['items'])){
    foreach($events['items'] AS $event):
        $starttime = date("Y-m-d", strtotime($event['start']['dateTime']));
        $eventdate = new DateTime($starttime);
        // $eventdate = date("Y-m-d", strtotime($event['start']['dateTime']));
        $diff = $now->diff($eventdate);
        // echo "<!-- datetime ".$eventdate->date."  -->";
        echo "<li><div class='heading-grey'>".$event['summary']."</div>";
        echo "<div class='start-time'>";
        echo "<div class='sub-heading'>Start</div>";
        echo "<div class='cal-time'>".date("d M D H:i", strtotime($event['start']['dateTime']))."</div>";
        echo "</div>";
        echo "<div class='end-time'>";
        echo "<div class='sub-heading'>End</div>";
        echo "<div class='cal-time'>".date("d M D H:i", strtotime($event['end']['dateTime']))."</div>";
        echo "</div>";
        echo "<div class='time-diff'>".$diff->format('%a day(s) away')."</div>";
        echo "</li>";
    endforeach;

} else {
    echo "No upcoming events";
}
?>


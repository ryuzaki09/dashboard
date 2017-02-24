<div class="heading-white">Recently Added</div>
<?php
if(is_array($plex_recent_data) && !empty($plex_recent_data)){
    foreach($plex_recent_data AS $plex):
        echo "<li><div class='vid-info'>";
        if (isset($plex['parentTitle']))
            echo $plex['parentTitle']."<br />";
        
        if (isset($plex['year'])) {
            echo $plex['title']."<br />".$plex['year'];
            
        }
        
        if (isset($plex['leafCount'])) {
            echo "Episode ".$plex['leafCount']."</div>".
                "<img src='http://192.168.1.201:32400".$plex['parentThumb']."' />";
        }
        if (isset($plex['thumb'])) {
            echo "</div>".
                "<img src='http://192.168.1.201:32400".$plex['thumb']."' />";
        }
        echo "</li>";

    endforeach;

} else {
    echo "Nothing added recently";
}
?>

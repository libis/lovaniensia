<div class='result'>
<?php
    $base_url = get_option('rosetta_resolver');
    $html='';

    if($list = rosetta_get_list($base_url."/".urlencode($_GET['search'])."/list")):
        foreach ($list as $key => $rep):
            //var_dump($rep['content']);echo '<br><hr><br>';
            $content = $rep['content'];
            echo "<ul>";
            foreach($content as $fl => $file):
              //echo $fl."<br>";
              echo "<li><a target='_blank' href='".$base_url."/".$fl."/stream?quality=low'>".$file['label']." - ".$file['file_label']."</a><Input type = 'Radio' Name ='pid' value= '".$fl."'>
              </li>";
            endforeach;
            echo '</ul><hr><br>';
        endforeach;
        //echo $html;
    else:?>
    <p>No results found</p>
    <?php endif;?>
</div>

<?php
    
    $jsondata = file_get_contents('http://tntradio.ba/eter/getdata.php'); 
    $data = json_decode($jsondata, true);
    $artist = $data['artist'];
    $song = $data['song'];
    $id = $data['id'];
    $ocjena = $data['ocjena'];
    $image = $data['image'];
    $history = $data['history'];
    $emisija = $data['emisija'];
    $slika = $data['slika'];
    
?>
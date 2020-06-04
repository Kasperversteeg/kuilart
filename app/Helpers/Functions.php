<?php


// for now is set to false, need to make global function
function isMobile(){
    return false;
}


// returns a string
function formatDate($date){
    $formatted = date('d-m-Y', strtotime($date));
    return $formatted;
}

// returns a string
function formatTime($time){
    $formatted = date('H:i', strtotime($time));
    return $formatted;
}
// returns a database format sttri
function dateForDB($date){
    $formatted = date('Y-m-d', strtotime($date));
    return $formatted;
}




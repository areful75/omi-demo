<?php

function getConnection(){
    $con = new mysqli('127.0.0.1', 'root', '', 'buss');
    return $con;
}






function booked($seatBooked){
    $con = getConnection();
    $sql = "insert into bus VALUES('{$seatBooked}')";
    if(mysqli_query($con, $sql)){
        return true;
    } else{
        return false;
    }
}
?>
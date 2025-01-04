
<?php

    function getConnection(){
        $con = new mysqli('127.0.0.1', 'root', '', 'contacts');
        return $con;
    }



    function contract($email, $comment){
        $con = getConnection();
        $sql = "insert into review VALUES('{$email}', '{$comment}')";
        if(mysqli_query($con, $sql)){
            return true;
        } else{
            return false;
        }
    }
    


    
          
?>

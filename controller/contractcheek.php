<?php
require_once('db.php');

if (isset($_REQUEST['submit'])) {
    $email = trim($_REQUEST['email']);
    $comment = trim($_REQUEST['comment']);

    if (empty($email) || empty($comment)) {
        echo "Null input";
    } else {
        $atCount = 0;
        $dotCount = 0;
        $atPosition = 0;
        $dotPosition = 0;

       
        for ($i = 0; $i < strlen($email); $i++) {
            $char = $email[$i];

            if ($char == '@') {
                $atCount++;
                $atPosition = $i;
            }

            if ($char == '.') {
                $dotCount++;
                $dotPosition = $i;
            }

            if (($atCount > 1) || 
                ($dotCount > 0 && $dotPosition <= $atPosition + 1) || 
                ($i == 0 && $char == '@') || 
                ($i == strlen($email) - 1 && ($char == '@' || $char == '.'))) {
                echo "Invalid email format.<br>";
                
            }
        }

       
        if ($atCount == 1 && $dotCount > 0 && $dotPosition > $atPosition) {
            echo "Email is valid.<br>";
        } else {
            echo "Invalid email format.<br>";
        }

        
        if ($atCount == 1 && $dotCount > 0 && $dotPosition > $atPosition) {
            $status = contract($email, $comment);
            if ($status) {
              
                echo "Check in database";
            } else {
                echo "Comment not added";
            }
        }
    }
} else {
    header('location:contract.html');
}
?>

<?php
    require "page_var.php";

    session_start();
    
    $RETURN_HTML = true;

    if (isset($_POST['input'])) {
        
        if ($_POST['input'] == $_SESSION['correctword']) {
            $_SESSION['score'] = $_SESSION['score'] + 1;
            $status = true;
        } else {
            $status = false;
        }

        $_SESSION['correctword'] = "apa";
        $shuffledword = str_shuffle($_SESSION['correctword']);
        $response = array(
            "data" => array("status" => $status, "score" => $_SESSION['score'], "shuffledword" => $shuffledword)
        );
        echo (json_encode($response));
        $RETURN_HTML = false;
    } else {
        $_SESSION['score'] = 0;
        $_SESSION['correctword'] = "hello";
        $shuffledword = str_shuffle($_SESSION['correctword']);
    }

    if ($RETURN_HTML) {
        include "view.php";
    }
?>
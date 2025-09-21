<?php
    $hostname = "sv93.ifastnet.com";
    $userName = "vascodagama_vasc";
    $password = "S3KLMVFjDG";
    $databaseName = "vascodagama_players";

        $conn = new mysqli ($hostname, $userName, $password, $databaseName);

        //check connection
        if ($conn -> connect_error) {
            #die("Connection Failed: " . $conn -> connect_error);
            die(
                include("error.html")
            );
            
        }
?>



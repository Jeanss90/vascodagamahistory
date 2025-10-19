<?php
    $hostname = "sv93.ifastnet.com";
    $userName = "vascodagama_vasc";
    $pass = "S3KLMVFjDG";
    $databaseName = "vascodagama_matches";

        $conn = new mysqli ($hostname, $userName, $pass, $databaseName);

        //check connection
        if ($conn -> connect_error) {
            #die("Connection Failed: " . $conn -> connect_error);
            die(
                include("error.html")
            );
            
        }
?>
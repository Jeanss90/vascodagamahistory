<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>


<?php
include("vasco.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Salaries - Results</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">  
            <div id="results" class="form-style">
                
                <?php

                    function generatePayRef($id, $year, $month) {
                        $random = substr(md5(uniqid(mt_rand(), true)), 0, 6);

                        return $id . $year . $month . strtoupper($random);
                    };

                    $playerId = intval($_POST['player_id'] ?? 0);
                    $ano = intval($_POST['ano'] ?? 0);
                    $meses = $_POST['mes'] ?? [];
                    $nome = $_POST['nome_completo'] ?? '';
                    $salario = $_POST['salario'] ?? '';
                    
                    #echo "$playerId<br>";
                    #echo "$ano<br>";
                    #var_dump($meses);
                    #echo "<br>";
                    #echo "$nome<br>";
                    #echo "$salario<br>";

                    if(!empty($meses)) {
                        echo "<h1>Paid Succesfully!</h1>
                        
                        <div class='form-container'>
                            <div class='field-container'>
                                <label class='label-field'>Full Name: </label>
                                <div class='input-field'>
                                    $nome<br>
                                </div>
                            </div>";
                            
                            foreach ($meses as $mes) {
                                switch ($mes) { 
                                    case '01':
                                        $number = '01';
                                        $mes = "January";
                                        break;
                                    case '02':
                                        $number = '02';
                                        $mes = "February";
                                        break;
                                    case '03':
                                        $number = '03';
                                        $mes = "March";
                                        break;
                                    case '04':
                                        $number = '04';
                                        $mes = "April";
                                        break;
                                    case '05':
                                        $number = '05';
                                        $mes = "May";
                                        break;
                                    case '06':
                                        $number = '06';
                                        $mes = "June";
                                        break;
                                    case '07':
                                        $number = '07';
                                        $mes = "July";
                                        break;
                                    case '08':
                                        $number = '08';
                                        $mes = "August";
                                        break;
                                    case '09':
                                        $number = '09';
                                        $mes = "September";
                                        break;
                                    case '10':
                                        $number = '10';
                                        $mes = "October";
                                        break;
                                    case '11':
                                        $number = '11';
                                        $mes = "November";
                                        break;
                                    case '12':
                                        $number = '12';
                                        $mes = "December";
                                        break;
                                }
                                echo"
                                <div class='field-container'>
                                    <label class='label-field'>Paid for $mes: </label>
                                    <div class='input-field'>
                                        R$ $salario<br>
                                    </div>
                                </div>";

                                $payRef = generatePayRef($playerId, $ano, $number);
                                $now = date("Y-m-d H:i:s");

                                echo"                
                                <div class='field-container'>
                                    <label class='label-field'>Payment Reference: </label>
                                    <div class='input-field'>
                                        $payRef<br>
                                    </div>
                                </div>";

                                $sql = "INSERT INTO pagamentos (
                                    id,
                                    mes,
                                    ano,
                                    pay_ref,
                                    salario_liquido,
                                    data_pagamento
                                    )
                                    VALUES (
                                    '$playerId',
                                    '$number',
                                    '$ano',
                                    '$payRef',
                                    '$salario',
                                    '$now'
                                    )";

                                if ($conn->query($sql) === TRUE) {
                                    #echo " Records updated! ".$playerId."-".$number."-".$ano."-".$payRef."-".$salario."-".$now;
                                } else {
                                    #echo " Error: ".$sql."<br>".$conn->error;
                                }
                            }
                        echo "</div>
                        </div>";
                    } else {
                        echo "<h1'>An error has occurred! Please try again.</h1>";
                    }                
                
                ?>
            </div>
        </div>
        
        <?php include('back-to-options.html');?>
        <?php include('back-to-main.html');?>
        <?php include('back-to-squad.html');?>
        
        <script src='/script.js'></script>

        <?php include('footer.php');?>
    </body>
</html>


<?php 
    
    }else{
    
        header("Location: dev.php");
    
        exit();
    
    }
    
?>
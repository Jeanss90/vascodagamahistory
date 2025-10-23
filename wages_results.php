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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Wages - Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="wages-form">

<?php include('loggedinheader.php')?>

<div class="section">
    <div class="card-panel">   
        <span>
            
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
                    echo "<h1 style='text-align: center'>Pagamento realizado com Sucesso!</h1>
                    
                    <div class='form-container'>
                        <div class='field-container'>
                            <label>Nome Completo: </label>
                            <div class='input-field'>
                                $nome<br>
                            </div>
                        </div>";
                        
                        foreach ($meses as $mes) {
                            switch ($mes) { 
                                case '01':
                                    $number = '01';
                                    $mes = "Janeiro";
                                    break;
                                case '02':
                                    $number = '02';
                                    $mes = "Fevereiro";
                                    break;
                                case '03':
                                    $number = '03';
                                    $mes = "Março";
                                    break;
                                case '04':
                                    $number = '04';
                                    $mes = "Abril";
                                    break;
                                case '05':
                                    $number = '05';
                                    $mes = "Maio";
                                    break;
                                case '06':
                                    $number = '06';
                                    $mes = "Junho";
                                    break;
                                case '07':
                                    $number = '07';
                                    $mes = "Julho";
                                    break;
                                case '08':
                                    $number = '08';
                                    $mes = "Agosto";
                                    break;
                                case '09':
                                    $number = '09';
                                    $mes = "Setembro";
                                    break;
                                case '10':
                                    $number = '10';
                                    $mes = "Outubro";
                                    break;
                                case '11':
                                    $number = '11';
                                    $mes = "Novembro";
                                    break;
                                case '12':
                                    $number = '12';
                                    $mes = "Dezembro";
                                    break;
                            }
                            echo"
                            <div class='field-container'>
                                <label>Valor Pago em $mes: </label>
                                <div class='input-field'>
                                    R$ $salario<br>
                                </div>
                            </div>";

                            $payRef = generatePayRef($playerId, $ano, $number);
                            $now = date("Y-m-d H:i:s");

                            echo"                
                            <div class='field-container'>
                                <label>Numero de Referencia do Pagamento: </label>
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
                    echo "<h1 style='text-align: center'>An error has occurred! Please try again.</h1>";
                }                
            
                ?>
            </div>
        </span>

        <p style= "text-align: center">
            <a href="/wages.php"><img class="backmainpage">Back to Payments</a><br>
            <a href="/dev_options.php"><img class="backmainpage">Go to options menu</a><br>
            <a href="/squad.php"><img class="backmainpage">Go to Squad page</a>
        </p>
        
    </div>
</div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>
</body>
</html>


<?php 
    
    }else{
    
        header("Location: dev.php");
    
        exit();
    
    }
    
?>
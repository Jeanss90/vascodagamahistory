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
    <title>Squad 2024</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>



<body class="background">
    <div class="center-align">
        <div class="section">
            <div class="card-panel">
                <span>

                <h1>Squad <?php
                    echo date('Y')?></h1>
                <p style= "text-align: center">
                    <a href="/index.php"><img class="backmainpage">Back to main page</a>
                </p>
        
                <div class="elenco">
                    <table class="highlight centered mywhite">
                        <thead>
                            <tr class="table-title">
                                <th colspan=2><h4>Players</h4></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--Players-->
                            
                            <?php 
        
                                $sql = 'CALL get_squad()';    // Select table here 
                                $result = mysqli_query($conn,$sql);  // here i am run the query
                                $i = 1;                             // only creates sequence of the data
                                while($row = mysqli_fetch_array($result)) // Showing all the data
                                {
                                    
                                    $apelido = $row['apelido'];
                                    $id = $row['id'];
                                    $numero = $row['numero'];
                                    $nome_completo = $row['nome_completo'];
                                    $data_de_nascimento = $row['data_de_nascimento'];
                                    $idade = $row['idade'];
                                    $posicao = $row['posicao'];
                                    $contrato = $row['contrato'];
                                    $termino_contrato = $row['termino_contrato'];
                                    
                                    
                                    if ($previous_posicao <> $posicao) {
                                        if ($posicao == "Lateral") {
                                            echo "<tr><th colspan=2><h4>Laterais</h4></th></tr";
                                        } else if ($posicao == "Tecnico") {
                                            echo "<tr><th colspan=2><h4>Tecnico</h4></th></tr";
                                        } else {
                                            echo "<tr><th colspan=2><h4>".$posicao."s</h4></th></tr";
                                        }
                                }     
                            ?>
                            <tr>
                                <td>
                                    <?php echo $apelido; ?>
                                </td>
                                <td>
                                    <a class="waves-effect waves-light btn modal-trigger" href="#modal<?php echo $id?>">View</a>
                                </td>
                            </tr>
                    
                    <!-- Modal Structure -->
                    <div id="modal<?php echo $id?>" class="modal">
                        <div class="modal-content" style="background-color: var(--myred)">
                            <h4 style="margin-bottom: 5px"><?php echo $apelido?></h4>
                            
                            <div class="modal-body">
                                <div class="player-info">
                                    <img class="foto" src="/img/player/<?php
                                        $files = scandir("img/player/");
                                            $number = 0;
                                            foreach($files as $filename) {
                                                $filenumber = basename($filename, ".png");
                                                if ($filenumber == $numero) {
                                                    $number++;
                                                }
                                            }
                                            if ($number == 1) {
                                                echo $numero;
                                            } else {
                                                echo 0;
                                            }
                                        ?>.png" alt="#<?php echo $apelido ?>">
                                    <div class="player-details">
                                        <p><b><em>Número:</em></b> <?php
                                            if ($numero >= 100) {
                                                echo "s/n";
                                            } else {
                                                echo $numero;    
                                            } ?></p>    
                                        <p><b><em>Nome Completo:</em></b> <?php echo $nome_completo; ?></p>
                                        <p><b><em>Data de Nascimento:</em></b> <?php echo $data_de_nascimento; ?></p>
                                        <p><b><em>Idade:</em></b> <?php echo $idade; ?></p>
                                        <p><b><em>Posição:</em></b> <?php echo $posicao; ?></p>
                                        <p><b><em>Tipo de Contrato:</em></b> <?php echo $contrato; ?></p>
                                        <p><b><em>Término do Contrato:</em></b> <?php echo $termino_contrato; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Close</a>
                        </div>
                    </div>
                    <?php
                        $i++;
                        $previous_posicao = $posicao;
                    }
                    ?>
                    </tbody>
                </table>
                </span>
                <p style= "text-align: center">
                    <a href="/index.php"><img class="backmainpage">Back to main page</a>
                </p>
            </div>
        </div>            
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>
    
</body>

<footer>
    <?php
        include('footer.php');
    ?>
</footer>

</html>
<?php
    include("database_jogos.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Copa do Brasil</title>
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
            <div class="card-panel carioca">
                <span>

                <a id="logo-container" href="#" class="brand-logo" style="height: inherit;">
                    <img class="responsive" src="/img/copa_do_brasil_horizontal.svg" alt="logo_copadobrasil" style="padding: 10px; width: 25%; background-color: antiquewhite;">
                </a>
                <p style= "text-align: center">
                    <a href="/index.php"><img class="backmainpage">Back to Main Page</a>
                </p>
                <p style= "text-align: center">
                    <a href="/competitions.php"><img class="backmainpage">Back to Competitions</a>
                </p>

                <div>
                    <div>
                        <!-- Adding Fixtures-->
                        <div>
                            <table colspan="11" class="highlight centered mywhite">
                                <thead>
                                    <tr class="table-title">
                                        <th>
                                            <h4>Fixtures</h4>
                                        </th>
                                    </tr>
                                </thead>

                                    <?php
                                        $sql = 'SELECT jogos.id, horario, escudo_casa, casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio, rodada
                                            FROM ((jogos
                                            INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                                            INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                                            WHERE competicao = "Copa do Brasil" AND horario > "2025-01-01 00:00" ORDER BY id;
                                        ';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query

                                        date_default_timezone_set('Europe/London');
                                        $now = date("Y-m-d H:i:s");
                            
                                        while($row = mysqli_fetch_assoc($result)) // Showing all the data
                                        {
                                            #get rodada atual

                                            $horario = $row['horario'];
                                            $rodada = $row['rodada'];
                                            $score_casa = $row['score_casa'];
                                            $score_fora = $row['score_fora'];

                                            $after_rodada = date('Y-m-d H:i:s', strtotime($horario. ' + 24 hours'));
                                            
                                            if ($after_rodada > $now && !isset($score_casa) && !isset($score_fora)) {
                                                if ($rodada != 1){
                                                    $rodada_atual = $rodada;
                                                    break;
                                                }
                                            }  else {
                                                $rodada_atual = $rodada;
                                            }
                                        }

                                        #echo $after_rodada;
                                        #echo $rodada_atual;

                                        #get last round
                                        $sql = 'SELECT * FROM jogos WHERE competicao = "Copa do Brasil" AND horario > "2025-01-01 00:00" ORDER BY id;
                                        ';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query
                            
                                        while($row = mysqli_fetch_assoc($result)) // Showing all the data
                                        {
                                            $last_round = $row['rodada'];
                                        }
                                        #echo $last_round;

                                        while(mysqli_next_result($conn)){;}
                                        $sql = 'SELECT jogos.id, horario, escudo_casa, casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio, rodada
                                            FROM ((jogos
                                            INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                                            INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                                            WHERE competicao = "Copa do Brasil" AND horario > "2025-01-01 00:00" ORDER BY rodada, id;
                                        ';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query

                                        while($row = mysqli_fetch_assoc($result)) // Showing all the data
                                        {
                                            #Fixtures

                                            $horario = $row['horario'];
                                            $casa = $row['casa'];
                                            $fora = $row['fora'];
                                            $competicao = $row['competicao'];
                                            $estadio = $row['estadio'];
                                            $escudo_casa = $row['escudo_casa'];
                                            $escudo_fora = $row['escudo_fora'];
                                            $score_casa = $row['score_casa'];
                                            $score_fora = $row['score_fora'];
                                            $penalti_casa = $row['penalti_casa'];
                                            $penalti_fora = $row['penalti_fora'];
                                            $rodada = $row['rodada'];
                                            
                                            $day = date_format(date_create($horario), 'D d/m/Y');
                                            $time = date_format(date_create($horario), 'H:i');
                                            
                                            if ($rodada_anterior <> $rodada) {
                                                $first_match = TRUE;
                                            } else {
                                                $first_match = FALSE;
                                            }

                                                if ($first_match) {
                                                    if ($rodada_atual == $rodada) {
                                                    echo"    
                                                    <tbody class='show' id=round$rodada>";
                                                    } else {
                                                    echo"    
                                                    <tbody class='hidden' id=round$rodada>";    
                                                    }
                                                    echo"
                                                    <tr>
                                                        <th style='display: flex; justify-content: space-between;'>";
                                                            if ($rodada == 1) {
                                                                    echo"
                                                                        <span class='prev'>
                                                                            <i class='material-icons' style='font-size: 20px'></i>        
                                                                        </span>";
                                                                    } else {
                                                                        echo"
                                                                        <span class='prev' onmouseover='modeHover()' onclick='moveTablePrev($rodada)'>
                                                                            <i class='material-icons' style='font-size: 20px'>chevron_left</i>        
                                                                        </span>";
                                                                    }

                                                            switch ($rodada) {
                                                                case 1:
                                                                    $round = "1ª Fase";
                                                                    break;
                                                                case 2:
                                                                    $round = "2ª Fase";
                                                                    break;
                                                                case 3:
                                                                    $round = "3ª Fase";
                                                                    break;
                                                                case 4:
                                                                    $round = "Oitavas-de-final";
                                                                    break;
                                                                case 5:
                                                                    $round = "Quartas-de-final";
                                                                    break;
                                                                case 6:
                                                                    $round = "Semi-final";
                                                                    break;
                                                                case 7:
                                                                    $round = "Final";
                                                                    break;
                                                                default:
                                                                    $round = "1ª Fase";
                                                                    break;
                                                            }
                                                            echo"
                                                            <h4>$round</h4>";
                                                            if ($rodada == $last_round) {
                                                                    echo"
                                                                        <span class='next'>
                                                                            <i class='material-icons' style='font-size: 20px'></i>        
                                                                        </span>";
                                                                    } else {
                                                                        echo"
                                                                        <span class='next' onmouseover='modeHover()' onclick='moveTableNext($rodada)'>
                                                                            <i class='material-icons' style='font-size: 20px'>chevron_right</i>        
                                                                        </span>";
                                                                    }
                                                        echo"
                                                        </th>
                                                    </tr>";
                                                }
                                                echo"
                                                <tr>
                                                    <td style='padding: 0'>
                                                    <div class='game-fixtures'>   
                            
                                                        <div class='game-info-fixtures'>

                                                            <div class='info'>
                                                                <span> $competicao </span><br>
                                                                <span> $day </span><br>
                                                            </div>
                                                            <div class='info'>
                                                                <span> $estadio </span><br>
                                                                <span> $time </span><br>
                                                            </div>
                                                        </div>
                                                        <div class='score-fixtures'>
                                                            <div class='score-home'>
                                                                <span class='team'>$casa</span>
                                                                <img class='home-team' src='$escudo_casa' title='$casa'>
                                                            </div>
                                                            <div class='score-box'>
                                                                <span class='goal table-goals'>$score_casa</span>
                                                                <span class='penalties-home' style='color:var(--myblack)'>$penalti_casa</span>
                                                                <span class='versus'>
                                                                    <svg viewBox='0 0 100 100' width='100%' height='100%'>
                                                                        <line x1='-3' x2='100' y1='1' y2='100' stroke='#D52315' stroke-width='5'></line>
                                                                        <line x1='-3' x2='100' y1='100' y2='1' stroke='#D52315' stroke-width='5'></line>
                                                                    </svg>
                                                                </span>
                                                                <span class='penalties-away' style='color:var(--myblack)'>$penalti_fora</span>
                                                                <span class='goal table-goals'>$score_fora</span>
                                                            </div>
                                                            <div class='score-away'>
                                                                <img class='away-team' src='$escudo_fora'  title='$fora'>
                                                                <span class='team'>$fora</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </td>
                                                </tr>";
                                        $rodada_anterior = $rodada;
                                        
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </span>
                <p style= "text-align: center">
                    <a href="/index.php"><img class="backmainpage">Back to Main Page</a>
                </p>
                <p style= "text-align: center">
                    <a href="/competitions.php"><img class="backmainpage">Back to Competitions</a>
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
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
    <title>Campeonato Brasileiro</title>
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
                    <img class="responsive table-logo-bra" src="/img/brasileirao.svg" alt="logo_campeonatobrasileiro">
                </a>
                <p style= "text-align: center">
                    <a href="/index.php"><img class="backmainpage">Back to Main Page</a>
                </p>
                <p style= "text-align: center">
                    <a href="/competitions.php"><img class="backmainpage">Back to Competitions</a>
                </p>

                <div>
                    <div>
                        <div style="margin-bottom: 20px">
                            <table class="highlight centered mywhite">
                                <thead>
                                    <tr class="table-title">
                                        <th colspan=11><h4>Standings</h4></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--Tabela-->
                                    <tr class="table-h4">
                                        <th >
                                            <h4>#</h4>
                                        </th>
                                        <th>
                                            <h4>Team</h4>
                                        </th>
                                        <th>
                                            <h4>PTS</h4>
                                        </th>
                                        <th>
                                            <h4>P</h4>
                                        </th>
                                        <th>
                                            <h4>W</h4>
                                        </th>
                                        <th>
                                            <h4>D</h4>
                                        </th>
                                        <th>
                                            <h4>L</h4>
                                        </th>
                                        <th>
                                            <h4>GF</h4>
                                        </th>
                                        <th>
                                            <h4>GA</h4>
                                        </th>
                                        <th class="hide-table">
                                            <h4>DIFF</h4>
                                        </th>
                                        <th class="hide-table">
                                            <h4>PCT</h4>
                                        </th>
                                    </tr>

                                    <tr>
                                    <?php
                                        $year = date('Y');
                                        $sql = 'SELECT * FROM jogos WHERE competicao = "Campeonato Brasileiro" AND horario > "'.$year.'-01-01"';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query
                                        $i = 1;                             // only creates sequence of the data
                                        $myFixtures = array();

                                        date_default_timezone_set('Europe/London');
                                        $now = date("Y-m-d H:i:s");
                                        $starter = $now;

                                        $libertadoresClube = "Flamengo";
                                        $libertadoresFinished = true;
                                        $libertadoresCount = 0;

                                        $copaDoBrasilClube = false;
                                        $copaDoBrasilFinished = false;
                                        $copaDoBrasilCount = 0;

                                        $sudamericanaClube = "Lanus";
                                        $sudamericanaFinished = true;
                                        $sudamericanaCount = 0;

                                        while($row = mysqli_fetch_assoc($result)) // Showing all the data
                                        {

                                                $casa = $row['casa'];
                                                #echo "$casa<br>";
                                                $score_casa = $row['score_casa'];
                                                #echo "$score_casa<br>";
                                                $score_fora = $row['score_fora'];
                                                #echo "$score_fora<br>";
                                                $fora = $row['fora'];
                                                #echo "$fora<br>";
                                                $horario = $row['horario'];
                                                #echo $horario;

                                                $fixtures = array("casa" => $casa,"score_casa" => $score_casa, "score_fora" => $score_fora, "fora" => $fora, "horario" => $horario);

                                                $myFixtures[] = $fixtures;

                                                #set first game of season
                                                if ($starter > $horario) {
                                                    $starter = $horario;
                                                }

                                            $i++;
                                        }

                                        #var_dump($myFixtures);

                                        $sql = 'SELECT * FROM clubs_brasileirao;';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query
                                        $i = 1;                             // only creates sequence of the data
                                        $myStandings = array();
                                        while($row = mysqli_fetch_assoc($result)) // Showing all the data
                                        {

                                            $clube = $row['clube'];
                                            #echo "$clube<br>";
                                            $PG = 0;
                                            $J = 0;
                                            $V = 0;
                                            $E = 0;
                                            $D = 0;
                                            $GP = 0;
                                            $GC = 0;
                                            $des = null;

                                            foreach ($myFixtures as $fixtures) {

                                                $casa = $fixtures['casa'];
                                                #echo "$casa<br>";
                                                $score_casa = $fixtures['score_casa'];
                                                #echo "$score_casa<br>";
                                                $score_fora = $fixtures['score_fora'];
                                                #echo "$score_fora<br>";
                                                $fora = $fixtures['fora'];
                                                #echo "$fora<br>";
                                                $horario = $fixtures['horario'];
                                                #echo $horario;

                                                
                                                if ($clube == $casa) {
                                                    #calcular pontos ganhos, vitorias, empates e derrotas para time jogando em casa
                                                    if ($score_casa == NULL  && $horario > $now) {
                                                        continue;
                                                    } else {
                                                        if ($score_casa > $score_fora) {
                                                            $PG += 3;
                                                            $V += 1;
                                                        } else if ($score_casa == $score_fora) {
                                                            $PG += 1;
                                                            $E += 1;
                                                        } else {
                                                            $PG += 0;
                                                            $D += 1;
                                                        }
                                                    } 

                                                    
                                                    #calcular jogos
                                                    $J += 1;

                                                    #calcular gols pro
                                                    $GP += $score_casa;

                                                    #calcular gols contra
                                                    $GC += $score_fora;
                                                }

                                                if ($clube == $fora) {
                                                    #calcular pontos ganhos, vitorias, empates e derrotas para time jogando fora
                                                    if ($score_fora == NULL && $horario > $now) {
                                                        continue;
                                                    } else {
                                                        if ($score_fora > $score_casa) {
                                                            $PG += 3;
                                                            $V += 1;
                                                        } else if ($score_fora == $score_casa) {
                                                            $PG += 1;
                                                            $E += 1;
                                                        } else {
                                                            $PG += 0;
                                                            $D += 1;
                                                        }
                                                    }
                                                    
                                                    #calcular jogos
                                                    $J += 1;

                                                    #calcular gols pro
                                                    $GP += $score_fora;

                                                    #calcular gols contra
                                                    $GC += $score_casa;
                                                }
                                                
                                            
                                            }
                                            if ($J == 0) {
                                                $JAP = 1;
                                            } else {
                                                $JAP =$J;
                                            }


                                            $sql = "UPDATE standings_brasileirao
                                                SET `PG` = $PG, `J` = $J, `V` = $V, `E` = $E, `D` = $D, `GP` = $GP, `GC` = $GC, `SG` = ($GP-$GC), `AP` = ($PG/($JAP*3))
                                                WHERE clube = '$clube'";

                                            if ($conn->query($sql) === TRUE) {
                                                #echo " Records updated! ";
                                            } else {
                                                #echo " Error: ".$sql2."<br>".$conn->error;
                                            }
                                            
                                            $i++;
                                        }

                                        $sql = 'CALL sort_table_brasileirao;';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query
                                        $i = 1;                             // only creates sequence of the data
                                        $position = 1;                      //set position for table
                                        $positionadd = 0;
                                        while($row = mysqli_fetch_array($result)) // Showing all the data
                                        {
                                            
                                            $clube = $row['clube'];
                                            $PG = $row['PG'];
                                            $J = $row['J'];
                                            $V = $row['V'];
                                            $E = $row['E'];
                                            $D = $row['D'];
                                            $GP = $row['GP'];
                                            $GC = $row['GC'];
                                            $SG = $row['SG'];
                                            $AP = $row['AP'];
                                            $desempate = $row['desempate'];
                                    ?>

                                    <?php
                                    if ($position == 1) {

                                    } else {
                                        if (
                                        $PGant == $PG &&
                                        $Jant == $J &&
                                        $Vant == $V &&
                                        $Eant == $E &&
                                        $Dant == $D &&
                                        $GPant == $GP &&
                                        $GCant == $GC &&
                                        $SGant == $SG &&
                                        $APant == $AP &&
                                        $desempateant == $desempate)
                                        {
                                            $position = $positionant;
                                            $positionadd++;
                                        } else {
                                            $position = $position + $positionadd;
                                            $positionadd = 0;
                                        }
                                    }   

                                    ?>

                                    <tr
                                    <?php
                                        if ($starter < $now) {

                                            switch ($position) {
                                                case 1:
                                                    echo ' class="br1" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-main); color: var(--brasileirao-green)"';
                                                case 17:
                                                case 18:
                                                case 19:
                                                case 20:
                                                    echo ' class="brreleg" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-red)"';
                                            }

                                            if ($libertadoresClube == $clube && $copaDoBrasilClube == $clube) {
                                                $libertadoresCount++;
                                                $copaDoBrasilCount++;
                                                if ($libertadoresFinished && $copaDoBrasilFinished) {
                                                    echo ' class="brlib" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-main); color: var(--mygold)"';
                                                }
                                            } else if ($libertadoresClube == $clube) {
                                                $libertadoresCount++;
                                                if ($libertadoresFinished) {
                                                    echo ' class="brlib" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-main); color: var(--mygold)"';
                                                }
                                            } else if ($copaDoBrasilClube == $clube) {
                                                $copaDoBrasilCount++;
                                                if ($copaDoBrasilFinished) {
                                                    echo ' class="brlib" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-main); color: var(--mygold)"';
                                                }
                                            } else if ($sudamericanaClube == $clube) {
                                                $sudamericanaCount++;
                                                if ($sudamericanaFinished) {
                                                    echo ' class="brlib" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-main); color: var(--mygold)"';
                                                }
                                            }

                                            if ($position >=2 && $position <=4) {
                                                echo ' class="br1" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-main); color: antiquewhite"';
                                            } else if ($position >= 2+$libertadoresCount+$copaDoBrasilCount+$sudamericanaCount && $position <= 4+$libertadoresCount+$copaDoBrasilCount+$sudamericanaCount) {
                                                echo ' class="br1" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-main); color: antiquewhite"';
                                            } else if ($position  >= 5+$libertadoresCount+$copaDoBrasilCount+$sudamericanaCount && $position <= 6+$libertadoresCount+$copaDoBrasilCount+$sudamericanaCount) {
                                                echo ' class="br2" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-second); color: antiquewhite"';
                                            } else if ($position >= 7+$libertadoresCount+$copaDoBrasilCount+$sudamericanaCount && $position <= 12+$libertadoresCount+$copaDoBrasilCount+$sudamericanaCount) {
                                                echo ' class="br3" style="font-weight:bold; font-style: italic; background-color: var(--brasileirao-green); color: var(--brasileirao-main)"';
                                            }
                                        }
                                    ?>
                                    >
                                        <td>
                                            <?php echo $position; ?>
                                        </td>
                                        <td>
                                            <?php echo $clube; ?>
                                        </td>
                                        <td>
                                            <?php echo $PG; ?>
                                        </td>
                                        <td>
                                            <?php echo $J; ?>
                                        </td>
                                        <td>
                                            <?php echo $V; ?>
                                        </td>
                                        <td>
                                            <?php echo $E; ?>
                                        </td>
                                        <td>
                                            <?php echo $D; ?>
                                        </td>
                                        <td>
                                            <?php echo $GP; ?>
                                        </td>
                                        <td>
                                            <?php echo $GC; ?>
                                        </td>
                                        <td class="hide-table">
                                            <?php echo $SG; ?>
                                        </td>
                                        <td class="hide-table">
                                            <?php 
                                            $PCT = round($AP*100, 2);
                                            echo "$PCT%"; ?>
                                        </td>
                                    </tr>
                            

                            <?php
                                $i++;
                                $positionant = $position;
                                $position++;
                                $PGant = $PG;
                                $Jant = $J;
                                $Vant = $V;
                                $Eant = $E;
                                $Dant = $D;
                                $GPant = $GP;
                                $GCant = $GC;
                                $SGant = $SG;
                                $APant = $AP;
                                $desempateant = $desempate;
                            }
                            
                            ?>
                            </tbody>
                            </table>
                        </div>
                    </div>

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
                                        while(mysqli_next_result($conn)){;}
                                        $sql = 'SELECT jogos.id, horario, escudo_casa, casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio, rodada
                                            FROM ((jogos
                                            INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                                            INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                                            WHERE competicao = "Campeonato Brasileiro" AND horario > "2025-01-01" ORDER BY horario;
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
                                        #echo $now;

                                        #get last round
                                        $sql = 'SELECT * FROM jogos WHERE competicao = "Campeonato Brasileiro" AND horario > "2025-01-01 00:00" ORDER BY id;
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
                                            WHERE competicao = "Campeonato Brasileiro" AND horario > "2025-01-01" ORDER BY rodada, horario;
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
                                                            echo"
                                                            <h4>Round $rodada</h4>";
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
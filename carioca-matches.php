<?php
    include("database_jogos.php");
    $year = date('Y');
?>

<!-- Adding Fixtures-->
<div class="competition-box">
    <table class="competitions" colspan="11">
        <thead>
            <tr class="table-title">
                <th>
                    <h3>Fixtures</h3>
                </th>
            </tr>
        </thead>
        <?php
            $sql = "SELECT jogos.id, horario, escudo_casa, casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio, rodada
                FROM ((jogos
                INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                WHERE competicao = 'Campeonato Carioca'
                AND horario > '$year-01-01 00:00'
                AND horario < '$year-12-31 23:59'
                ORDER BY horario;";    // Select table here 
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
                    if ($rodada != 0){
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
            $sql = "SELECT * FROM jogos WHERE competicao = 'Campeonato Carioca'
            AND horario > '$year-01-01 00:00'
            AND horario < '$year-12-31 23:59'
            ORDER BY id;";    // Select table here 
            $result = mysqli_query($conn,$sql);  // here i am run the query

            while($row = mysqli_fetch_assoc($result)) // Showing all the data
            {
                $last_round = $row['rodada'];
            }
            #echo $last_round;

            while(mysqli_next_result($conn)){;}
            $sql = "SELECT jogos.id, horario, escudo_casa, casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio, rodada
                FROM ((jogos
                INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                WHERE competicao = 'Campeonato Carioca'
                AND horario > '$year-01-01 00:00'
                AND horario < '$year-12-31 23:59'
                ORDER BY id, horario;";    // Select table here 
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

                switch ($rodada) {
                    case '1':
                    case '2':
                    case '3':
                    case '4':
                    case '5':
                    case '6':
                        $stage = "Round $rodada";
                        break;
                    case 7:
                        $stage = "Quarter finals";
                        break;
                    case 8:
                        $stage = "Semifinals - 1st Leg";
                        break;
                    case 9:
                        $stage = "Semifinals - 2nd Leg";
                        break;
                    case 10:
                        $stage = "Final";
                        break;
                }
                
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
                        <th style='display: flex; justify-content: space-between; align-items: center;'>";
                            if ($rodada == 1) {
                                echo"
                                    <span class='prev material-symbols-outlined'></span>";
                            } else {
                                echo"
                                    <span class='prev material-symbols-outlined' onmouseover='modeHover()' onclick='moveTablePrev($rodada)'>
                                        chevron_left       
                                    </span>";
                            }
                            echo"
                            <h4>$stage</h4>";
                            if ($rodada == $last_round) {
                                echo"
                                    <span class='next material-symbols-outlined'></span>";
                            } else {
                                echo"
                                    <span class='next material-symbols-outlined' onmouseover='modeHover()' onclick='moveTableNext($rodada)'>
                                        chevron_right        
                                    </span>";
                            }
                        echo"
                        </th>
                    </tr>";
                }
                echo"
                    <tr>
                        <td>
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
                                        <span class='goals'>$score_casa</span>
                                        <span class='penalties-home' style='color:var(--primary)'>$penalti_casa</span>
                                        <span class='versus material-symbols-outlined'>
                                            close_small
                                        </span>
                                        <span class='penalties-away' style='color:var(--primary)'>$penalti_fora</span>
                                        <span class='goals'>$score_fora</span>
                                    </div>
                                    <div class='score-away'>
                                        <img class='away-team' src='$escudo_fora' title='$fora'>
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
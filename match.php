<table class="header-match">
    <tbody>
        <tr>
            <td>
                <?php
                    $year = date('Y');
                    $sql = "SELECT horario, casa, escudo_casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio
                            FROM ((jogos
                            INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                            INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                            WHERE (casa = 'Vasco da Gama' OR fora = 'Vasco da Gama') AND horario > DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY horario;";    // Select table here 
                    $result = mysqli_query($conn,$sql);  // here i am run the query
                    $i = 1;                             // only creates sequence of the data
                    while($row = mysqli_fetch_array($result)) // Showing all the data
                        {
                        
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
                        
                        
                        $day = date_format(date_create($horario), 'D d/m/Y');
                        $time = date_format(date_create($horario), 'H:i');
                        break;
                        
                        }
                        
                    date_default_timezone_set('Europe/London');
                    $now = date("Y-m-d H:i:s");
                    #WHEN SUMMER TIME, PRELIVE IS -2, NORMAL IS -1
                    $prelive = date('Y-m-d H:i:s', strtotime($horario. ' - 1 hours'));
                    $afterlive = date('Y-m-d H:i:s', strtotime($horario. ' + 3 hours'));
                    
                    #echo $prelive.' '.$horario.' '.$now.' '.$afterlive;
                    
                    if($now >= $prelive && $now <= $afterlive) {
                        echo '<div class="live">';
                    } else {
                        echo '<div class="not-live">';
                    }
                ?>

                    <div class='game-fixtures'>
                        <div class='game-info-fixtures'>

                            <?php
                                $sql = "SELECT horario, casa, escudo_casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio
                                        FROM ((jogos
                                        INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                                        INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                                        WHERE (casa = 'Vasco da Gama' OR fora = 'Vasco da Gama') AND horario > DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY horario;";    // Select table here 
                                $result = mysqli_query($conn,$sql);  // here i am run the query
                                $i = 1;                             // only creates sequence of the data
                                while($row = mysqli_fetch_array($result)) // Showing all the data
                                {

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
                                
                                
                                $day = date_format(date_create($horario), 'D d/m/Y');
                                $time = date_format(date_create($horario), 'H:i');
                                break;
                                
                                }
                                
                            date_default_timezone_set('Europe/London');
                            $now = date("Y-m-d H:i:s");
                            $prelive = date('Y-m-d H:i:s', strtotime($horario. ' - 1 hours'));
                            
                            #echo $prelive.' '.$horario.' '.$now;
                            
                            $yearmatch = date_format(date_create($horario), 'Y');
                            $showfirstmatch = date_format(date_create($yearmatch . '-01-07'),'Y-m-d H:i:s');
                            if ($yearmatch > $year) {
                                echo "<p><b>END OF SEASON</b></p>";
                            } else if ($now <= $showfirstmatch) {
                                echo "<p><b>HAPPY NEW YEAR!</b></p>";
                            }
                                else {
                                
                                echo
                                "
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
                                ";
                            }
                        ?>
                        </div>
                    </div>
                </div>  
            </td>
        </tr>
    </tbody>
</table>


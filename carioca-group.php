<?php
include("database_jogos.php");
$groups = 2;

for ($group = 1; $group <= $groups; $group++) { 
?>
    <div class="competition-box" id="group-fase group<?php echo $group?>">
        <!--Adding Tables-->
        <div>
            <table table class="competitions carioca">
                <thead>
                    <tr>
                        <th colspan=11><h3>Group <?php echo $group ?></h3></th>
                    </tr>
                </thead>
                <tbody>
                    <!--Table-->
                    <tr>
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
                        <th class='hide-table'>
                            <h4>DIFF</h4>
                        </th>
                        <th class='hide-table'>
                            <h4>PCT</h4>
                        </th>
                    </tr>

                    <tr>
                    <?php
                        while(mysqli_next_result($conn)){;}
                        $year = date('Y');
                        $sql = "SELECT * FROM jogos WHERE competicao = 'Campeonato Carioca'
                        AND horario > '$year-01-01 00:00'
                        AND horario < '$year-12-31 23:59';";    // Select table here 
                        $result = mysqli_query($conn,$sql);  // here i am run the query
                        $i = 1;                             // only creates sequence of the data
                        $myFixtures = array();

                        date_default_timezone_set('Europe/London');
                        $now = date("Y-m-d H:i:s");
                        $starter = $now;

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

                        $sql = "SELECT * FROM clubs_carioca";    // Select table here 
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

                            $sql = "UPDATE standings_carioca
                                SET `PG` = $PG, `J` = $J, `V` = $V, `E` = $E, `D` = $D, `GP` = $GP, `GC` = $GC, `SG` = ($GP-$GC), `AP` = ($PG/($JAP*3))
                                WHERE clube = '$clube'";

                            if ($conn->query($sql) === TRUE) {
                                #echo " Records updated! ";
                            } else {
                                #echo " Error: ".$sql2."<br>".$conn->error;
                            }
                            $i++;
                        }

                        $sql = "CALL sort_table_carioca_grupo('$group');";    // Select table here 
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
                    </tr>

                    <tr
                    <?php
                        if ($starter < $now) {
                            if ($position == 1) {
                                echo 'class="carioca1"';
                            } else if ($position == 12) {
                                echo 'class="cariocareleg"';
                            } else if ($position  >=2 && $position <= 4) {
                                echo 'class="carioca2"';
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
<?php 
    }
?>


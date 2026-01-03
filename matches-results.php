<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>


<?php
include("jogos.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Matches - Results</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">  
            <div id="results" class="form-style">
                <?php
                    
                    $adicionar = $_POST['adicionar'];
                    $atualizar = $_POST['atualizar'];
                    
                    $form_id = $_POST['form-id'];
                    $form_data = $_POST['form-data'];
                    $form_casa = $_POST['mandante'];
                    $form_fora = $_POST['visitante'];
                    $form_competicao = $_POST['form-competicao'];
                    $form_estadio = $_POST['form-estadio'];
                    $form_escudo_casa = $_POST[''];
                    $form_escudo_fora = $_POST[''];
                    $form_score_casa = $_POST['score-casa'];
                    $form_score_fora = $_POST['score-fora'];
                    $form_penalti_casa = $_POST['penalti-casa'];
                    $form_penalti_fora = $_POST['penalti-fora'];
                    $form_time = $_POST['form-hora'];
                    
                    $newform_data = date_format(date_create($form_data), 'd/m/Y');
                    $new_horario = date('Y-m-d H:i:s', strtotime("$form_data $form_time"));
                    date_default_timezone_set('Europe/London');
                    $now = date('Y-m-d H:i:s');
                    $prelive = date('Y-m-d H:i:s', strtotime($new_horario. ' - 1 hours'));

                    #echo $now;
                    #echo $prelive;

                    if ($form_penalti_casa == 0 && $form_penalti_fora == 0) {
                        $i = TRUE;
                    }

                    echo $disabled;
                    #echo $adicionar;
                    #echo $atualizar;
                                
                    #echo $form_data;
                    #echo $form_casa;
                    #echo $form_fora;
                    #echo $form_competicao;
                    #echo $form_estadio;
                    #echo $form_escudo_casa;
                    #echo $form_escudo_fora;
                    #echo $form_score_casa;
                    #echo $form_score_fora;
                    #echo $form_penalti_casa;
                    #echo $form_penalti_fora;
                    #echo $form_time;
                    #echo $new_horario;

                    function formResults($form1, $form2, $form3, $form4, $form5, $form6, $form7, $form8, $form9, $form10) {
                        echo
                        "<div class='form-container'>
                            <div class='field-container'>
                                <label class='label-field'>Home: </label>
                                <div class='input-field'>
                                    $form1<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Away: </label>
                                <div class='input-field'>
                                    $form2<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Home Score: </label>
                                <div class='input-field'>
                                    $form3</br>
                                </div>
                            </div>
                    
                            <div class='field-container'>
                                <label class='label-field'>Away Score: </label>
                                <div class='input-field'>
                                    $form4<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Home Penalty:</label>
                                <div class='input-field'>
                                    $form5<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Away Penalty: </label>
                                <div class='input-field'>
                                    $form6<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>        
                                <label class='label-field'>Date: </label>
                                <div class='input-field'>
                                    $form7<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Time: </label>
                                <div class='input-field'>
                                    $form8<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Venue: </label>
                                <div class='input-field'>
                                    $form9<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Competition: </label>
                                <div class='input-field'>
                                    $form10<br>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                    
                    
                    if ($adicionar != "") {
                        echo "<h1>Match Added Succesfully!</h1>";
                        formResults($form_casa, $form_fora, $form_score_casa, $form_score_fora, $form_penalti_casa, $form_penalti_fora, $newform_data, $form_time, $form_estadio, $form_competicao);
                    } else {
                        if ($atualizar != "") {
                            echo "<h1>Match Updated Succesfully!</h1>";
                            formResults($form_casa, $form_fora, $form_score_casa, $form_score_fora, $form_penalti_casa, $form_penalti_fora, $newform_data, $form_time, $form_estadio, $form_competicao);
                        } else {
                            echo "<h1>An error has occurred! Please try again.</h1>";
                        }
                    }

                    
                        
                    if ($adicionar == "adicionar") {
                        $sql = "INSERT INTO jogos (
                        horario,
                        casa,
                        fora,
                        estadio,
                        competicao
                        )
                        VALUES (
                        '$new_horario',
                        '$form_casa',
                        '$form_fora',
                        '$form_estadio',
                        '$form_competicao'
                        )";
                    } else {
                        if ($atualizar == "atualizar") {
                            if ($now <= $prelive) {
                                $sql = "UPDATE jogos SET
                                    horario = '$new_horario',
                                    casa = '$form_casa',
                                    fora = '$form_fora',
                                    estadio = '$form_estadio',
                                    competicao = '$form_competicao'
                                    WHERE id = '$form_id'";
                            } else {
                                if ($i) {
                                    $sql = "UPDATE jogos SET
                                    horario = '$new_horario',
                                    casa = '$form_casa',
                                    score_casa = $form_score_casa,
                                    penalti_casa = NULL,
                                    penalti_fora = NULL,
                                    score_fora = $form_score_fora,
                                    fora = '$form_fora',
                                    estadio = '$form_estadio',
                                    competicao = '$form_competicao'
                                    WHERE id = '$form_id'";
                                } else {
                                    $sql = "UPDATE jogos SET
                                    horario = '$new_horario',
                                    casa = '$form_casa',
                                    score_casa = $form_score_casa,
                                    penalti_casa = $form_penalti_casa,
                                    penalti_fora = $form_penalti_fora,
                                    score_fora = $form_score_fora,
                                    fora = '$form_fora',
                                    estadio = '$form_estadio',
                                    competicao = '$form_competicao'
                                    WHERE id = '$form_id'";
                                }
                            }
                        }
                    }
                    
                    #echo $adicionar." ";
                    #echo $atualizar." ";
                    
                    if ($conn->query($sql) === TRUE) {
                        #echo " Records updated! ".$new_horario."-".$form_casa."-".$form_score_casa."-".$form_penalti_casa."-".$form_penalti_fora."-".$form_score_fora."-".$form_fora."-".$form_competicao."-".$form_estadio;
                    } else {
                        #echo " Error: ".$sql."<br>".$conn->error;
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
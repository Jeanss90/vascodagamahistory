<?php 

session_start();
$now = time();

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {

?>

<?php include('jogos.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Developer - Score</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>





<body class="player-form">

<?php include('loggedinheader.php');?>

<div class="section">
    <div class="card-panel">   
        <span>
            <div class="form-style">
        
                <h1 style="text-align: center;">Atualizar Scores</h1>
                
                <form action="/score.php" method="post" name="score_form">
                <div class="field-container" style="padding-bottom:5px; border-bottom: solid #D52315 0.5px; margin-bottom:10px">
                    <label style="padding-top: 8px; padding-bottom: inherit;">
                        <!-- IMPORTANT, use class browser-default as materialize css does not work properly with select on ios iphone-->
                        <select class="browser-default"  style="
                            background-color: antiquewhite;
                            color: var(--myred);
                            font-weight: bold;
                            font-style: italic;
                            border: var(--mygrey) 1px solid;" id="select" name="select">
                            <?php
                            echo "<option name='current-game' value='current-game'>Adicionar Jogo</option>";
                            
                            
                            $sql = 'SELECT jogos.id, horario, casa, escudo_casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio
                                    FROM ((jogos
                                    INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                                    INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                                    WHERE horario > DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY horario;';    // Select table here 
                            $result = mysqli_query($conn,$sql);  // here i am run the query
                            $i = 1;                             // only creates sequence of the data
                            while($row = mysqli_fetch_array($result)) // Showing all the data
                            {
                                
                            $id = $row['id'];
                            $casa = $row['casa'];
                            $fora = $row['fora'];
                            
                            echo "<option name='$id' value='$id'>$casa x $fora</option>";
                            
                            $i++;
                            }
                        
                            ?>
                    </select>
                </label>
                <div class="input-field"  style="display: grid; margin: auto;">
                    <input type="submit" name="buscar" value="Buscar" class="btn btn-info">
                    <button type="submit" name="select" value="" class="btn btn-info">Limpar</button>
                </div>
            </div>
            </form>
        
        
        
        
        
        
        
                
                <form action="/score_results.php" method="post" enctype="multipart/form-data" name="score_form">
                
                <?php
                
                $select = $_POST['select'];
                $buscar = $_POST['buscar'];
                
                
                
                
                $sql = 'SELECT jogos.id, horario, casa, escudo_casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio
                        FROM ((jogos
                        INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                        INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                        WHERE horario > DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY horario;';    // Select table here 
                $result = mysqli_query($conn,$sql);  // here i am run the query
                $i = 1;                             // only creates sequence of the data
                while($row = mysqli_fetch_array($result)) // Showing all the data
                {
                    $id = $row['id'];
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
        
                        
                    if ($select == $id) {
                
                        $form_id = $id;
                        $form_horario = $horario;
                        $form_casa = $casa;
                        $form_fora = $fora;
                        $form_competicao = $competicao;
                        $form_estadio = $estadio;
                        $form_escudo_casa = $escudo_casa;
                        $form_escudo_fora = $escudo_fora;
                        $form_score_casa = $score_casa;
                        $form_score_fora = $score_fora;
                        $form_penalti_casa = $penalti_casa;
                        $form_penalti_fora = $penalti_fora;
                        
                        $form_time = date_format(date_create($form_horario), 'H:i');

                        if (!isset($form_score_casa)) {
                            $form_score_casa = 0;
                        }

                        if (!isset($form_score_fora)) {
                            $form_score_fora = 0;
                        }

                        if (!isset($form_penalti_casa)) {
                            $form_penalti_casa = 0;
                        }

                        if (!isset ($form_penalti_fora)) {
                            $form_penalti_fora = 0;
                        }
                            
                        
        
                    }
                $i++;
                }
                ?>
        
            
                <div class="form-container">
                    
                    <div class="field-container">
                        <label for="mandante">Mandante: </label>
                        <div class="input-field score-fields">
                            <input type="text" name="mandante" id="mandante" <?php
                                if ($select) {
                                    echo "value='$form_casa' disabled>
                                    <input hidden name='mandante' value='$form_casa'>
                                    <img src='$form_escudo_casa' alt='$form_casa'";
                                } else {
                                    echo "value='$form_casa' placeholder='Mandante'>
                                    <img src='/img/crest_2.png' alt='Mandante'";
                                }?>>
                            <br>
                        </div>
                    </div>
                    
                    <div class="field-container">
                        <label for="visitante">Visitante: </label>
                        <div class="input-field score-fields">
                            <input type="text" name="visitante" id="visitante" <?php
                                if ($select) {
                                    echo "value='$form_fora' disabled>
                                    <input hidden name='visitante' value='$form_fora'>
                                    <img src='$form_escudo_fora' alt='$form_fora'";
                                } else {
                                    echo "value='$form_fora' placeholder='Visitante'>
                                    <img src='/img/crest_2.png' alt='Visitante'";
                                }?>>
                            <br>
                        </div>
                    </div>
                    
                    <script>
                    var i = <?php echo $form_score_casa ?>;
                    
                    function incrementScoreCasa() {
                        i++;
                        document.getElementById('score-casa').value = i;
                    }
        
                    function decrementScoreCasa() {
                        i--;
                        document.getElementById('score-casa').value = i;
                    }
                    
                    var j = <?php echo $form_score_fora ?>;

                    function incrementScoreFora() {
                        j++;
                        document.getElementById('score-fora').value = j;
                    }
        
                    function decrementScoreFora() {
                        j--;
                        document.getElementById('score-fora').value = j;
                    }
                    
                    
                    var k = <?php echo $form_penalti_casa ?>;
                    
                    function incrementPenaltiCasa() {
                        k++;
                        document.getElementById('penalti-casa').value = k;
                    }
        
                    function decrementPenaltiCasa() {
                        k--;
                        document.getElementById('penalti-casa').value = k;
                    }
                    
                    
                    
                    var l = <?php echo $form_penalti_fora ?>;
                    
                    function incrementPenaltiFora() {
                        l++;
                        document.getElementById('penalti-fora').value = l;
                    }
        
                    function decrementPenaltiFora() {
                        l--;
                        document.getElementById('penalti-fora').value = l;
                    }
                    </script>
                    
                    
                    <div class="field-container">
                        <label for="score-casa">Score Casa: </label>
                        <div class="input-field">
                            <input type='text' name='score-casa' id='score-casa' style="margin-bottom: 5px"
                            <?php
                                if ($select) {
                                    echo "value=$form_score_casa";
                                } else {
                                    echo "disabled";
                                }
                            ?>
                            >
                            <input style="width: 50px;" type="button" onclick=incrementScoreCasa() value="+" >
                            <input style="width: 50px;" type="button" onclick=decrementScoreCasa() value="-" >
                        </div>
                    </div>
                    
                    <div class="field-container">
                        <label for="score-fora">Score Fora: </label>
                        <div class="input-field">
                            <input type='text' name='score-fora' id='score-fora' style="margin-bottom: 5px"
                            <?php
                                if ($select) {
                                    echo "value=$form_score_fora";
                                } else {
                                    echo "disabled";
                                }
                            ?>
                            >
                            <input style="width: 50px;" type="button" onclick=incrementScoreFora() value="+" >
                            <input style="width: 50px;" type="button" onclick=decrementScoreFora() value="-" >
                        </div>
                    </div>
                    
                    <div class="field-container">
                        <label for="penalti-casa">Penalti Casa: </label>
                        <div class="input-field">
                            <input type='text' name='penalti-casa' id='penalti-casa' style="margin-bottom: 5px"
                            <?php
                                if ($select) {
                                    echo "value=$form_penalti_casa";
                                } else {
                                    echo "disabled";
                                }
                            ?>
                            >
                            <input style="width: 50px;" type="button" onclick=incrementPenaltiCasa() value="+" >
                            <input style="width: 50px;" type="button" onclick=decrementPenaltiCasa() value="-" >
                        </div>
                    </div>
                    
                    <div class="field-container">
                        <label for="penalti-fora">Penalti Fora: </label>
                        <div class="input-field">
                            <input type='text' name='penalti-fora' id='penalti-fora' style="margin-bottom: 5px"
                            <?php
                                if ($select) {
                                    echo "value=$form_penalti_fora";
                                } else {
                                    echo "disabled";
                                }
                            ?>
                            >
                            <input style="width: 50px;" type="button" onclick=incrementPenaltiFora() value="+" >
                            <input style="width: 50px;" type="button" onclick=decrementPenaltiFora() value="-" >
                        </div>
                    </div>
                    
                    <div class="field-container">
                        <label for="form-data">Data: </label>
                        <div class="input-field">
                            <?php
                                echo "<input type='date' name='form-data' id='form-data' value=$form_horario>";
                            ?>
                        </div>
                    </div>
                    
                    <div class="field-container">
                        <label for="form-hora">Horario: </label>
                        <div class="input-field">
                            <?php
                                echo "<input type='time' name='form-hora' id='form-hora' value=$form_time>";
                            ?>
                        </div>
                    </div>
                    
                    <div class="field-container">
                        <label for="form-estadio">Estadio: </label>
                        <div class="input-field">
                            <?php
                                echo "<input type='text' name='form-estadio' id='form-estadio' value='$form_estadio'>";
                            ?>
                        </div>
                    </div>
        
                    <div class="field-container">
                        <label for="form-competicao">Competicao: </label>
                        <div class="input-field">
                            <?php
                                echo "<input type='text' name='form-competicao' id='form-competicao' value='$form_competicao'>";
                            ?>
                        </div>
                    </div>
                    
                    
                <?php echo "<input hidden name='form-id' value='$form_id'>"; ?>
                    
                    <div class="player-actions">
                        <input type="submit" name="adicionar" value="Adicionar" class="btn btn-info" <?php 
                        if ($select){
                            echo 'disabled';
                        }?>>
                        <input type="submit" name="atualizar" value="Atualizar" class="btn btn-info" <?php 
                        if (!$select){
                            echo 'disabled';
                        }?>>
                    </div>
                    
                </div>
                </form>
                </div>
                
                <p style= "text-align: center">
                    <br>
                    <a href="/dev-options.php"><img class="backmainpage" >Go to options menu</a><br>
                    <a href="/squad.php"><img class="backmainpage" >Go to Squad page</a>
                </p>
            </div>
        </span>
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
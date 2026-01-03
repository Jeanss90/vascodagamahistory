<?php 

session_start();
$now = time();

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {

?>

<?php include('jogos.php')?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Matches</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">
            <div class="form-style">
                
                <h1>Manage Matches</h1>
                        
                <form action="/matches.php" method="post" name="matches_form">
                    <div class="form-container-select">
                        <label>
                            <select class="input-field input-field-select" id="select" name="select">
                                <?php
                                echo "<option name='current-game' value='current-game'>Select Match</option>";

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
                        <div>
                            <button type="submit" name="buscar" value="select" class="btn btn-form">Select</button>
                            <button type="submit" name="select" calue="limpar" class="btn btn-form">Clear</button>
                        </div>
                    </div>
                </form>
                
                <form action="/matches-results.php" method="post" enctype="multipart/form-data" name="matches_form">
                
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
                            <label class="label-field" for="mandante">Home Team: </label>
                            <input class="input-field" type="text" name="mandante" id="mandante" <?php
                                if ($select) {
                                    echo "value='$form_casa' disabled>
                                    <input hidden name='mandante' value='$form_casa'>
                                    <img style='margin-left: 10px; height: auto;' src='$form_escudo_casa' alt='$form_casa'";
                                } else {
                                    echo "value='$form_casa' placeholder='Mandante'>
                                    <img style='margin-left: 10px; height: auto;' src='/img/crest_2.png' alt='Mandante'";
                                }?>>
                        </div>
                        
                        <div class="field-container">
                            <label class="label-field" for="visitante">Away: </label>
                            <input class="input-field" type="text" name="visitante" id="visitante" <?php
                                if ($select) {
                                    echo "value='$form_fora' disabled>
                                    <input hidden name='visitante' value='$form_fora'>
                                    <img style='margin-left: 10px; height: auto;'src='$form_escudo_fora' alt='$form_fora'";
                                } else {
                                    echo "value='$form_fora' placeholder='Visitante'>
                                    <img style='margin-left: 10px; height: auto;' src='/img/crest_2.png' alt='Visitante'";
                                }?>>
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
                            <label class="label-field" for="score-casa">Home Score: </label>
                            <div>
                                <input class="input-field" type='text' name='score-casa' id='score-casa'
                                <?php
                                    if ($select) {
                                        echo "value=$form_score_casa";
                                    } else {
                                        echo "disabled";
                                    }
                                ?>
                                >
                                <div style="display: flex; justify-content: center">
                                    <button style="width: 50px; background: transparent" type="button" onclick=incrementScoreCasa() value="+" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">add</span></button>
                                    <button style="width: 50px; background: transparent" type="button" onclick=decrementScoreCasa() value="-" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">remove</span></button>
                                </div>    
                            </div>
                        </div>
                        
                        <div class="field-container">
                            <label class="label-field" for="score-fora">Away Score: </label>
                            <div>
                                <input class="input-field" type='text' name='score-fora' id='score-fora'
                                <?php
                                    if ($select) {
                                        echo "value=$form_score_fora";
                                    } else {
                                        echo "disabled";
                                    }
                                ?>
                                >
                                <div style="display: flex; justify-content: center">
                                    <button style="width: 50px; background: transparent" type="button" onclick=incrementScoreFora() value="+" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">add</span></button>
                                    <button style="width: 50px; background: transparent" type="button" onclick=decrementScoreFora() value="-" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">remove</span></button>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="field-container">
                            <label class="label-field" for="penalti-casa">Home Penalty: </label>
                            <div>
                                <input class="input-field" type='text' name='penalti-casa' id='penalti-casa'
                                <?php
                                    if ($select) {
                                        echo "value=$form_penalti_casa";
                                    } else {
                                        echo "disabled";
                                    }
                                ?>
                                >
                                <div style="display: flex; justify-content: center">
                                    <button style="width: 50px; background: transparent" type="button" onclick=incrementPenaltiCasa() value="+" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">add</span></button>
                                    <button style="width: 50px; background: transparent" type="button" onclick=decrementPenaltiCasa() value="-" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">remove</span></button>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="field-container">
                            <label class="label-field" for="penalti-fora">Away Penalty: </label>
                            <div>
                                <input class="input-field" type='text' name='penalti-fora' id='penalti-fora'
                                <?php
                                    if ($select) {
                                        echo "value=$form_penalti_fora";
                                    } else {
                                        echo "disabled";
                                    }
                                ?>
                                >
                                <div style="display: flex; justify-content: center">
                                    <button style="width: 50px; background: transparent" type="button" onclick=incrementPenaltiFora() value="+" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">add</span></button>
                                    <button style="width: 50px; background: transparent" type="button" onclick=decrementPenaltiFora() value="-" ><span class="material-symbols-outlined btn btn-form" style="background: var(--light)">remove</span></button>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="field-container">
                            <label class="label-field" for="form-data">Date: </label>
                            <?php
                                echo "<input class='input-field' type='date' name='form-data' id='form-data' value=$form_horario>";
                            ?>
                        </div>
                        
                        <div class="field-container">
                            <label class="label-field" for="form-hora">Time: </label>
                            <?php
                                echo "<input class='input-field' type='time' name='form-hora' id='form-hora' value=$form_time>";
                            ?>
                        </div>
                        
                        <div class="field-container">
                            <label class="label-field" for="form-estadio">Venue: </label>
                            <?php
                                echo "<input class='input-field' type='text' name='form-estadio' id='form-estadio' value='$form_estadio'>";
                            ?>
                        </div>
            
                        <div class="field-container">
                            <label class="label-field" for="form-competicao">Competition: </label>
                            <?php
                                echo "<input class='input-field' type='text' name='form-competicao' id='form-competicao' value='$form_competicao'>";
                            ?>
                        </div>
                        
                        <?php echo "<input hidden name='form-id' value='$form_id'>"; ?>
                        
                        <div class="form-actions">
                            <button type="submit" name="adicionar" value="adicionar" class="btn btn-form" <?php 
                            if ($select){
                                echo 'disabled';
                            }?>>Add</button>
                            <button type="submit" name="atualizar" value="atualizar" class="btn btn-form" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>Update</button>
                        </div>
                    </div>
                </form>
            </div>   
        </div>

        <?php include('back-to-options.html');?>
        <?php include('back-to-main.html');?>

        <?php include('footer.php');?>

        <script src='/script.js'></script>
    </body>
</html>

<?php 
} else {
    header("Location: dev.php");
    exit();
}
?>
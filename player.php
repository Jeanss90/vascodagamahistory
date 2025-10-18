<?php 

session_start();
$now = time();

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {

?>

<?php include('vasco.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Developer - Players</title>
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
                
                    <h1 style="text-align: center;">Atualizar Lista de Jogadores</h1>
                
                    <form action="/player.php" method="post" name="player_form">
                        <div class="field-container" style="padding-bottom:5px; border-bottom: solid #D52315 0.5px; margin-bottom:10px">
                            <label style="padding-top: 8px">
                                
                                <!-- IMPORTANT, use class browser-default as materialize css does not work properly with select on ios iphone-->
                                <select class="browser-default"  style="
                                        background-color: antiquewhite;
                                        color: var(--myred);
                                        font-weight: bold;
                                        font-style: italic;
                                        border: var(--mygrey) 1px solid;"
                                        id="select" name="select">
                                    <option value="" disabled selected>Selecionar jogador</option>
                                    <?php 
                                        $sql = 'SELECT * FROM players WHERE numero > 0 AND numero <= 100 AND apelido != "" ORDER BY numero ASC';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query
                                        $i = 1;                             // only creates sequence of the data
                                        while($row = mysqli_fetch_array($result)) // Showing all the data
                                        {
                                        
                                        
                                        $ncamisa = $row['apelido'];
                                        $num = $row['numero'];
                
                                        if ($num == 100) {
                                            echo "<option value='$num'>TEC - $ncamisa</option>";
                                        } else {
                                            echo "<option value='$num'>$num - $ncamisa</option>";
                                        }
                                        
                                        $i++;
                                        }
                                        
                                        $sql2 = 'SELECT * FROM players WHERE numero > 100 AND apelido != "" ORDER BY apelido ASC';    // Select table here 
                                        $result2 = mysqli_query($conn,$sql2);  // here i am run the query
                                        $i = 1;                             // only creates sequence of the data
                                        while($row = mysqli_fetch_array($result2)) // Showing all the data
                                        {  
                                        
                                        $ncamisa = $row['apelido'];
                                        $num = $row['numero'];
                                        
                                        if ($row['emprestado'] == 1) {
                                            echo "<option value='$num'>EMP - $ncamisa</option>";
                                        } else if ($row['u20squad'] == 1) {
                                            echo "<option value='$num'>U20 - $ncamisa</option>"; 
                                        } else {
                                            echo "<option value='$num'>0 - $ncamisa</option>";
                                        }
                
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
                
                    <form action="/player_results.php" method="post" enctype="multipart/form-data" name="player_form">
                
                        <?php
                        
                        $select = $_POST['select'];
                        $buscar = $_POST['buscar'];
                        
                        if($select != "") {
                            #echo 'teste'; 
                            #echo $select;
                        }
                    
                        $sql = 'SELECT * FROM players ORDER BY numero ASC';    // Select table here 
                        $result = mysqli_query($conn,$sql);  // here i am run the query
                        $i = 1;                             // only creates sequence of the data
                        while($row = mysqli_fetch_array($result)) // Showing all the data
                        {
                            $apelido = $row['apelido'];
                            $numero = $row['numero'];
                            $nome_completo = $row['nome_completo'];
                            $data_de_nascimento = $row['dob'];
                            $posicao = $row['posicao'];
                            $contrato = $row['contrato'];
                            $termino_contrato = $row['tdc'];
                            $emprestado = $row['emprestado'];
                            $notas = $row['notas'];
                            $u20 = $row['u20squad'];
                            
                            if ($select == $numero) {
                                $form_apelido = $apelido;
                                $form_numero = $numero;
                                $form_nome_completo = $nome_completo;
                                $form_data_de_nascimento = $data_de_nascimento;
                                $form_posicao = $posicao;
                                $form_contrato = $contrato;
                                $form_termino_contrato = $termino_contrato;
                                $form_emprestado = $emprestado;
                                $form_notas = $notas;
                                $form_u20 = $u20;
                                
                                $old_apelido = $apelido;
                                $old_numero = $numero;
                                $old_nome_completo = $nome_completo;
                                $old_data_de_nascimento = $data_de_nascimento;
                                $old_posicao = $posicao;
                                $old_contrato = $contrato;
                                $old_termino_contrato = $termino_contrato;
                                $old_emprestado = $emprestado;
                                $old_notas = $notas;
                
                            }
                            
                        $i++;
                        
                        }?>
        
                        <div class="form-container">
                    
                            <div class="field-container">
                                <label for="nome_completo">Nome Completo: </label>
                                <div class="input-field">
                                    <input type="text" id="nome_completo" name="nome_completo" <?php
                                        if ($select) {
                                            echo "value='$form_nome_completo'";
                                        } else {
                                            echo "placeholder='Fulano Sicrano Beltrano'";
                                        }?>><br>
                                </div>
                            </div>
                    
                            <div class="field-container">
                                <label for="apelido">Nome na Camisa*: </label>
                                <div class="input-field">
                                    <input type="text" id="apelido" name="apelido" <?php
                                        if ($select) {
                                            echo "value='$form_apelido'";
                                        } else {
                                            echo "placeholder='Fulaninho'";
                                        }?> required><br>
                                </div>
                            </div>
                    
                            <div class="field-container">
                                <label for="numero">Numero: </label>
                                <div class="input-field">
                                    <!-- IMPORTANT, use class browser-default as materialize css does not work properly with select on ios iphone-->
                                    <select class="browser-default" style="
                                        background-color: antiquewhite;
                                        color: var(--myred);
                                        font-weight: bold;
                                        font-style: italic;
                                        border: var(--mygrey) 1px solid;"
                                        id="numero" name="numero">
                                        
                                        <?php
                                        if ($select) {
                                            if ($form_numero >= 100) {
                                                $form_numero = 0;
                                            } else {
                                                $form_numero;
                                            }
                                            echo
                                            "<option value='$old_numero' selected>$form_numero</option>;
                                            <option value=0>0 - s/n</option>";
                                            
                                            $sql = 'SELECT * FROM players WHERE numero > 0 AND numero < 100 ORDER BY numero ASC';    // Select table here 
                                            $result = mysqli_query($conn,$sql);  // here i am run the query
                                            $i = 1;                             // only creates sequence of the data
                                            while($row = mysqli_fetch_array($result)) // Showing all the data
                                            {
                                                
                                                $numero = $row['numero'];
                                                $apelido = $row['apelido'];
                                                
                                                if ($apelido != "") {
                                                    echo "<option value='$numero' disabled>$numero - $apelido</option>";
                                                } else {
                                                    echo "<option value='$numero'>$numero</option>";
                                                }
                                            }
                                            $i++;
                                            
                                        } else {
                                            echo 
                                            "<option value='' disabled selected>Selecionar numero</option>
                                            <option value=0>0 - s/n</option>";
                                            
                                            $sql = 'SELECT * FROM players WHERE numero > 0 AND numero < 100 ORDER BY numero ASC';    // Select table here 
                                            $result = mysqli_query($conn,$sql);  // here i am run the query
                                            $i = 1;                             // only creates sequence of the data
                                            while($row = mysqli_fetch_array($result)) // Showing all the data
                                            {
                                                
                                                $numero = $row['numero'];
                                                $apelido = $row['apelido'];
                                                
                                                if ($apelido != "") {
                                                    echo "<option value='$numero' disabled>$numero - $apelido</option>";
                                                } else {
                                                    echo "<option value='$numero'>$numero</option>";
                                                }
                                            }
                                            $i++;
                                        }?>
                                    </select><br>
                                </div>
                            </div>
            
                            <div class="field-container">
                                <label for="dob">Data de Nascimento: </label>
                                <div class="input-field">
                                    <!-- datepicker not working correctly on ios iphone, not using class="datepicker" for now-->
                                    <input type="date" id="dob" name="dob" max="CURDATE()" <?php
                                    if ($select) {
                                            echo "value='$form_data_de_nascimento'";
                                        }?>><br><!-- atualizar max="CURDATE()" com php -->
                                </div>
                            </div>
                    
                            <div class="field-container">
                                <label>Posicao:</label>
                                <div class="input-field">
                                    <p>
                                        <label for="1">
                                            <input type="radio" id="1" name="posicao" value="Goleiro" <?php
                                            if ($form_posicao == 'Goleiro'){
                                                echo 'checked';
                                            }?>><span>Goleiro</span>
                                        </label><br>
                                    </p>
                                    
                                    <p>
                                        <label for="2">
                                            <input type="radio" id="2" name="posicao" value="Zagueiro" <?php
                                            if ($form_posicao == 'Zagueiro'){
                                                echo 'checked';
                                            }?>><span>Zagueiro</span>
                                        </label><br>
                                    </p>
                                    
                                    <p>
                                        <label for="3">
                                            <input type="radio" id="3" name="posicao" value="Lateral" <?php
                                            if ($form_posicao == 'Lateral'){
                                                echo 'checked';
                                            }?>><span>Lateral</span>
                                        </label><br>    
                                    </p>
                                    
                                    <p>
                                        <label for="4">
                                            <input type="radio" id="4" name="posicao" value="Volante" <?php
                                            if ($form_posicao == 'Volante'){
                                                echo 'checked';
                                            }?>><span>Volante</span>
                                        </label><br>    
                                    </p>
                                    
                                    <p>
                                        <label for="5">
                                            <input type="radio" id="5" name="posicao" value="Meia" <?php
                                            if ($form_posicao == 'Meia'){
                                                echo 'checked';
                                            }?>><span>Meia</span>
                                        </label><br>    
                                    </p>
                                    
                                    <p>
                                        <label for="6">
                                            <input type="radio" id="6" name="posicao" value="Atacante" <?php
                                            if ($form_posicao == 'Atacante'){
                                                echo 'checked';
                                            }?>><span>Atacante</span>
                                        </label><br>    
                                    </p>
                                    
                                    <p>
                                        <label for="7">
                                            <input type="radio" id="7" name="posicao" value="Tecnico" <?php
                                            if ($form_posicao == 'Tecnico'){
                                                echo 'checked';
                                            }?>><span>Tecnico</span>
                                        </label><br>    
                                    </p>
                                </div>
                            </div>
                    
                            <div class="field-container">
                                <label>Tipo de Contrato: </label>
                                <div class="input-field">
                                    <p>
                                        <label for="def">
                                            <input type="radio" id="def" name="contrato" value="Definitivo" <?php
                                            if ($form_contrato == 'Definitivo'){
                                                echo 'checked';
                                            }?>><span>Definitivo</span>
                                        </label><br>   
                                    </p>
                                    
                                    <p>
                                        <label for="emp">
                                            <input type="radio" id="emp" name="contrato" value="Emprestimo" <?php
                                            if ($form_contrato == 'Emprestimo'){
                                                echo 'checked';
                                        }?>><span>Emprestimo</span>
                                        </label><br>   
                                    </p>
                                </div>
                            </div>
                    
                            <div class="field-container">        
                                <label for="tdc">Termino de Contrato: </label>
                                <div class="input-field">
                                    <input type="date" id="tdc" name="tdc" min="CURDATE()" <?php
                                    if ($select) {
                                            echo "value='$form_termino_contrato'";
                                        }?>><br><!-- atualizar min="CURDATE()" com php -->
                                </div>
                            </div>
                    
                            <div class="field-container">
                                <label>Jogador Emprestado: </label>
                                
                                <div class="input-field">
                                    <p>
                                        <label for="emp_yes">
                                            <input type="radio" id="emp_yes" name="emprestado" value="1" <?php
                                                if ($form_emprestado == "1"){
                                                    echo 'checked';
                                                }?>><span>Sim</span>
                                        </label><br>    
                                    </p>
                                    
                                    <p>
                                        <label for="emp_no">
                                            <input type="radio" id="emp_no" name="emprestado" value="0" <?php
                                                if ($form_emprestado == "0"){
                                                    echo 'checked';
                                                }?>><span>Nao</span>
                                        </label><br>    
                                    </p>

                                </div>
                            </div>
                    
                            <!--adicionar campo tde para indicar data do fim de emprestimo de jogador-->
                    
                    
                            <div class="field-container">
                                <label>Comentarios: </label>
                                <div class="input-field">
                                <?php     
                                    if ($select) {
                                        if ($form_notas){
                                            echo "<textarea class='materialize-textarea' name='notas' rows='5' cols='30'>$form_notas</textarea><br>";    
                                        } else {
                                            echo "<textarea class='materialize-textarea' name='notas' rows='5' cols='30'></textarea><br>";
                                    }} else {
                                        echo "<textarea class='materialize-textarea' name='notas' rows='5' cols='30' placeholder='Inserir comentarios'></textarea><br>";
                                    }
                                ?>
                                </div>
                            </div>
                    
                            <div style="display: none" class="field-container">
                                <label>U20 Squad: </label>
                                
                                <div class="input-field">
                                    <input type="text" id="u20" name="u20" <?php
                                        $form_u20;
                                        ?>><br>
                                </div>
                            </div>
                    
                            <div class="field-container">
                                <label>Profile Picture: </label>
                                <div class="input-field">
                                    <?php
                                    #echo $old_numero;
                                    
                                    if ($select == "") {
                                        echo "<img src='/img/players/0.png' alt='profile picture' style='width:60px; height:80px; border: var(--mygrey) 1px solid;'>";
                                    } else {
                                        echo "<img src='/img/players/$old_numero.png' alt='$old_apelido' style='width:60px; height:80px; border: var(--mygrey) 1px solid;'>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <br>
                    
                            <div class="field-container">
                                <label>Change Picture: </label>
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>File</span>
                                        <input type="file" id="new-picture" name="new-picture">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path" type="text">
                                    </div>
                                </div>
                            </div>
                            <br>
                    
                            <!--adding values for old_ inputs-->
                            <?php
                            echo
                            "<input hidden name='old_apelido' value='$old_apelido'>
                            <input hidden name='old_numero' value='$old_numero'>
                            <input hidden name='old_nome_completo' value='$old_nome_completo'>
                            <input hidden name='old_data_de_nascimento' value='$old_data_de_nascimento'>
                            <input hidden name='old_posicao' value='$old_posicao'>
                            <input hidden name='old_contrato' value='$old_contrato'>
                            <input hidden name='old_termino_contrato' value='$old_termino_contrato'>
                            <input hidden name='old_emprestado' value='$old_emprestado'>
                            <input hidden name='old_notas' value='$old_notas'>
                            "?>
                        </div>
                    
                        <div class="player-actions">
                            <input type="submit" name="adicionar" value="Adicionar" class="btn btn-info" <?php 
                            if ($select){
                                echo 'disabled';
                            }?>>
                            <input type="submit" name="atualizar" value="Atualizar" class="btn btn-info" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>
                            <input type="submit" name="deletar" value="Deletar" class="btn btn-info" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>
                            <!-- criar janela para confirmar da acao de deletar o jogador **jogador sera deletado permanentemente**-->
                        </div>
                    </form>
                </div>
            
                <p style= "text-align: center">
                    <br>
                    <a href="/dev-options.php"><img class="backmainpage" >Go to options menu</a><br>
                    <a href="/squad.php"><img class="backmainpage" >Go to Squad page</a>
                </p>
            </span>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>

</body>
</html>

<?php 
} else {
    header("Location: dev.php");
    exit();
}
?>
<?php 

session_start();
$now = time();

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {

?>

<?php include('vasco.php')?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Players</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">
            <div class="form-style">
            
                <h1>Manage Players</h1>
            
                <form action="/player.php" method="post" name="player_form">
                    <div class="form-container-select">
                        <label>
                            <select class="input-field input-field-select" id="select" name="select">
                                <option value="" disabled selected>Select Player</option>
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
                        <div>
                            <button type="submit" name="buscar" value="select" class="btn btn-form">Select</button>
                            <button type="submit" name="select" calue="limpar" class="btn btn-form">Clear</button>
                        </div>
                    </div>
                </form>
            
                <form action="/player-results.php" method="post" enctype="multipart/form-data" name="player_form">
            
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
                            <label class="label-field" for="nome_completo">Full Name: </label>
                            <input class="input-field" type="text" id="nome_completo" name="nome_completo" <?php
                                if ($select) {
                                    echo "value='$form_nome_completo'";
                                } else {
                                    echo "placeholder='Fulano Sicrano Beltrano'";
                                }?>>
                        </div>
                
                        <div class="field-container">
                            <label class="label-field" for="apelido">Shirt Name*: </label>
                            <input class="input-field" type="text" id="apelido" name="apelido" <?php
                                if ($select) {
                                    echo "value='$form_apelido'";
                                } else {
                                    echo "placeholder='Fulaninho'";
                                }?> required>
                        </div>
                
                        <div class="field-container">
                            <label class="label-field" for="numero">Number: </label>
                            <select class="input-field input-field-select" id="numero" name="numero">
                                
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
                            </select>
                        </div>
        
                        <div class="field-container">
                            <label class="label-field" for="dob">Date of Birth: </label>
                            <input class="input-field" type="date" id="dob" name="dob" max="CURDATE()" <?php
                            if ($select) {
                                    echo "value='$form_data_de_nascimento'";
                                }?>><!-- atualizar max="CURDATE()" com php -->
                        </div>
                
                        <div class="field-container">
                            <label class="label-field">Position:</label>
                            <div class="input-field" style="height: 200px !important">
                                <p>
                                    <input type="radio" id="1" name="posicao" value="Goleiro" <?php
                                        if ($form_posicao == 'Goleiro'){
                                            echo 'checked';
                                        }?>>
                                    <label for="1"> Goalkeeper</label>
                                </p>
                                
                                <p>
                                    <input type="radio" id="2" name="posicao" value="Zagueiro" <?php
                                        if ($form_posicao == 'Zagueiro'){
                                            echo 'checked';
                                        }?>>
                                    <label for="2">Defender</label>
                                </p>
                                
                                <p>
                                    <input type="radio" id="3" name="posicao" value="Lateral" <?php
                                        if ($form_posicao == 'Lateral'){
                                            echo 'checked';
                                        }?>>
                                    <label for="3">Wing Back</label>  
                                </p>
                                
                                <p>
                                    <input type="radio" id="4" name="posicao" value="Volante" <?php
                                        if ($form_posicao == 'Volante'){
                                            echo 'checked';
                                        }?>>
                                    <label for="4">Def. Midfielder</label>
                                </p>
                                
                                <p>
                                    <input type="radio" id="5" name="posicao" value="Meia" <?php
                                        if ($form_posicao == 'Meia'){
                                            echo 'checked';
                                        }?>>
                                    <label for="5">Att. Midfielder</label>
                                </p>
                                
                                <p>
                                    <input type="radio" id="6" name="posicao" value="Atacante" <?php
                                        if ($form_posicao == 'Atacante'){
                                            echo 'checked';
                                        }?>>
                                    <label for="6">Forward</label>
                                </p>
                                
                                <p>
                                    <input type="radio" id="7" name="posicao" value="Tecnico" <?php
                                        if ($form_posicao == 'Tecnico'){
                                            echo 'checked';
                                        }?>>
                                    <label for="7">Head Coach</label>
                                </p>
                            </div>
                        </div>
                
                        <div class="field-container">
                            <label class="label-field">Contract Type: </label>
                            <div class="input-field" style="height: 70px !important">
                                <p>
                                    <input type="radio" id="def" name="contrato" value="Definitivo" <?php
                                        if ($form_contrato == 'Definitivo'){
                                            echo 'checked';
                                        }?>>
                                    <label for="def">Permanent</label>
                                </p>
                                
                                <p>
                                    <input type="radio" id="emp" name="contrato" value="Emprestimo" <?php
                                        if ($form_contrato == 'Emprestimo'){
                                            echo 'checked';
                                    }?>>
                                    <label for="emp">Loan</label>
                                </p>
                            </div>
                        </div>
                
                        <div class="field-container">        
                            <label class="label-field" for="tdc">Contract Expiry: </label>
                            <input class="input-field" type="date" id="tdc" name="tdc" min="CURDATE()" <?php
                            if ($select) {
                                    echo "value='$form_termino_contrato'";
                                }?>><!-- atualizar min="CURDATE()" com php -->
                        </div>
                
                        <div class="field-container">
                            <label class="label-field">On Loan?: </label>
                            
                            <div class="input-field" style="height: 70px !important">
                                <p>
                                    <input type="radio" id="emp_yes" name="emprestado" value="1" <?php
                                            if ($form_emprestado == "1"){
                                                echo 'checked';
                                            }?>>
                                    <label for="emp_yes">Yes</label>
                                </p>
                                
                                <p>
                                    <input type="radio" id="emp_no" name="emprestado" value="0" <?php
                                            if ($form_emprestado == "0"){
                                                echo 'checked';
                                            }?>>
                                    <label for="emp_no">No</label>
                                </p>

                            </div>
                        </div>
                
                        <!--adicionar campo tde para indicar data do fim de emprestimo de jogador-->
                
                
                        <div class="field-container">
                            <label class="label-field">Comments: </label>
                            <?php
                            echo "<textarea class='input-field' style='height: 300px !important'";
                                if ($select) {
                                    if ($form_notas){
                                        echo " name='notas'>$form_notas</textarea>";    
                                    } else {
                                        echo " name='notas'></textarea>";
                                }} else {
                                    echo " name='notas' placeholder='Insert Comments'></textarea>";
                                }
                            ?>
                        </div>
                
                        <div style="display: none" class="field-container">
                            <label class="label-field">U20 Squad: </label>
                            <input class="input-field" type="text" id="u20" name="u20" <?php
                                $form_u20;
                            ?>>
                        </div>
                
                        <div class="field-container">
                            <label class="label-field">Profile Picture: </label>
                            <div class="input-field" style="height: 95px !important; text-align: center">
                                <?php
                                #echo $old_numero;
                                
                                if ($select == "") {
                                    echo "<img src='/img/player/0.png' alt='profile picture' style='width:60px; height:80px;'>";
                                } else {
                                    echo "<img src='/img/player/$old_numero.png' alt='$old_apelido' style='width:60px; height:80px;'>";
                                }
                                ?>
                            </div>
                        </div>
                
                        <div class="field-container">
                            <label class="label-field">Change Picture: </label>
                            <input class="input-field" style="height: 37px !important;" type="file" id="new-picture" name="new-picture">
                        </div>
                
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
                        

                        <div class="form-actions">
                            <button type="submit" name="adicionar" value="adicionar" class="btn btn-form" <?php 
                            if ($select){
                                echo 'disabled';
                            }?>>Add</button>
                            <button type="submit" name="atualizar" value="atualizar" class="btn btn-form" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>Update</button>
                            <button type="submit" name="deletar" value="deletar" class="btn btn-form" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>Delete</button>
                            <!-- criar janela para confirmar da acao de deletar o jogador **jogador sera deletado permanentemente**-->
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
<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>


<?php
include("vasco.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Players - Results</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">
            <div id="results" class="form-style">
                <?php
                    
                    $adicionar = $_POST['adicionar'];
                    $atualizar = $_POST['atualizar'];
                    $deletar = $_POST['deletar'];
                    
                    $nome_completo = $_POST['nome_completo'];
                    $apelido = $_POST['apelido'];
                    $numero = $_POST['numero'];
                    $data_de_nascimento = $_POST['dob'];
                    $posicao = $_POST['posicao'];
                    $contrato = $_POST['contrato'];
                    $termino_contrato = $_POST['tdc'];
                    $emprestado = $_POST['emprestado'];
                    $notas = $_POST['notas'];
                    $u20 = $_POST['u20'];
                    
                    $old_nome_completo = $_POST['old_nome_completo'];
                    $old_apelido = $_POST['old_apelido'];
                    $old_numero = $_POST['old_numero'];
                    $old_dob = $_POST['old_data_de_nascimento'];
                    $old_posicao = $_POST['old_posicao'];
                    $old_contrato = $_POST['old_contrato'];
                    $old_tdc = $_POST['old_termino_contrato'];
                    $old_emprestado = $_POST['old_emprestado'];
                    $old_notas = $_POST['old_notas'];
                    
                    $form_dob = date_format(date_create($data_de_nascimento), 'd/m/Y');
                    $form_old_dob = date_format(date_create($old_dob), 'd/m/Y');
                    $form_tdc = date_format(date_create($termino_contrato), 'd/m/Y');
                    $form_old_tdc = date_format(date_create($old_tdc), 'd/m/Y');
                    
                    if ($numero > 100) {
                        $form_num = "s/n";
                    } else {
                        $form_num = $numero;
                    }
                    
                    if ($old_numero > 100) {
                        $form_old_num = "s/n";
                    } else {
                        $form_old_num = $numero;
                    }
                    
                    if($emprestado == 1) {
                        $form_emp = "Yes";
                    } else {
                        $form_emp = "No";
                    }
                    
                    if($old_emprestado == 1) {
                        $form_old_emp = "Yes";
                    } else {
                        $form_old_emp = "No";
                    }
                    
                    if($notas) {
                        $form_notas = $notas;
                    } else {
                        $form_notas = "n/a";
                    }
                    
                    if($old_notas) {
                        $form_old_notas = $old_notas;
                    } else {
                        $form_old_notas = "n/a";
                    }
                    
                    
                    $dir = "img/player/";
                    $ext = "png";
                    
                    function formResults($form1, $form2, $form3, $form4, $form5, $form6, $form7, $form8, $form9) {
                        echo
                        "<div class='form-container'>
                            <div class='field-container'>
                                <label class='label-field'>Full Name: </label>
                                <div class='input-field'>
                                    $form1<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Shirt Name: </label>
                                <div class='input-field'>
                                    $form2<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Number: </label>
                                <div class='input-field'>
                                    $form3</br>
                                </div>
                            </div>
                    
                            <div class='field-container'>
                                <label class='label-field'>Date of Birth: </label>
                                <div class='input-field'>
                                    $form4<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Position:</label>
                                <div class='input-field'>
                                    $form5<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Contract Type: </label>
                                <div class='input-field'>
                                    $form6<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>        
                                <label class='label-field'>Contract Expiry: </label>
                                <div class='input-field'>
                                    $form7<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>On Loan?: </label>
                                <div class='input-field'>
                                    $form8<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Comments: </label>
                                <div class='input-field'>
                                    $form9<br>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                    
                    function nposicao($idposicao) {
                        switch ($idposicao) {
                            case "Goleiro":
                                return 1;
                                break;
                            case "Zagueiro":
                                return 2;
                                break;
                            case "Lateral":
                                return 3;
                                break;
                            case "Volante":
                                return 4;
                                break;
                            case "Meia":
                                return 5;
                                break;
                            case "Atacante":
                                return 6;
                                break;
                            case "Tecnico":
                                return 7;
                                break;
                            default:
                                return 0;
                        }
                    }
                    
                    function get_u20 ($num, $age) {
                        if ($num > 0 && $num < 100) {
                            return FALSE;
                        } else {
                            if ($age > 20) {
                                return FALSE;
                            } else {
                                return TRUE;
                            }
                        }
                    }
                    
                    
                    if ($adicionar != "") {
                        echo "<h1>Player Added Succesfully!</h1>";
                        formResults($nome_completo, $apelido, $form_num, $form_dob, $posicao, $contrato, $form_tdc, $form_emp, $form_notas);
                    } else {
                        if ($atualizar != "") {
                            echo "<h1>Player Updated Succesfully!</h1>";
                            formResults($nome_completo, $apelido, $form_num, $form_dob, $posicao, $contrato, $form_tdc, $form_emp, $form_notas);
                        } else {
                            if ($deletar != "") {
                                echo "<h1>Player Deleted Succesfully!</h1>";
                                formResults($old_nome_completo, $old_apelido, $form_old_num, $form_old_dob, $old_posicao, $old_contrato, $form_old_tdc, $form_old_emp, $form_old_notas);
                            } else {
                                echo "<h1>An error has occurred! Please try again.";
                            }
                        }
                    }
                    
                    $new_apelido = $apelido;
                    
                    #change player number to 100+ if added with no number or player on loan
                    if($numero == '' || $numero == 0 || $emprestado == 1) {
                        if ($posicao == 'Tecnico') {
                            $new_numero = 100;
                        } else {
                            $sql = 'SELECT * FROM players WHERE numero > 100 AND apelido = "" ORDER BY numero ASC';    // Select table here 
                            $result = mysqli_query($conn,$sql);  // here i am run the query
                            while($row = mysqli_fetch_array($result)) // Showing all the data
                            {
                            $new_numero = $row['numero'];
                            #echo $new_numero;
                            break;
                            }
                        }
                    } else {
                        $new_numero = $numero;
                    }
            
                    $new_nome_completo = $nome_completo;
                    $new_dob = $data_de_nascimento;
                    $new_posicao = $posicao;
                    $new_contrato = $contrato;
                    $new_tdc = $termino_contrato;
                    $new_emprestado = $emprestado;
                    $new_notas = $notas;
                    $dob = date_format(date_create($new_dob), 'd/m/Y');
                    $idade = date_diff(date_create($new_dob), date_create('today'))->y;
                    $nposicao = nposicao($new_posicao);
                    $termino_contrato = date_format(date_create($new_tdc), 'd/m/Y');
                    $new_u20 = get_u20($new_numero, $idade);
                    
                        
                    if ($adicionar == "adicionar") {
                        $sql = "INSERT INTO players (
                        numero,
                        nome_completo,
                        apelido,
                        dob, 
                        data_de_nascimento,
                        idade,
                        posicao,
                        nposicao,
                        contrato,
                        tdc,
                        termino_contrato,
                        emprestado,
                        notas,
                        u20squad
                        )
                        VALUES (
                        '$new_numero',
                        '$new_nome_completo',
                        '$new_apelido',
                        '$new_dob',
                        '$dob',
                        '$idade',
                        '$new_posicao',
                        '$nposicao',
                        '$new_contrato',
                        '$new_tdc',
                        '$termino_contrato',
                        '$new_emprestado',
                        '$new_notas',
                        '$new_u20'
                        )";
                    } else {
                        if ($atualizar == "atualizar") {
                            $sql = "UPDATE players SET 
                                numero = '$new_numero',
                                nome_completo = '$new_nome_completo',
                                apelido = '$new_apelido',
                                dob = '$new_dob',
                                data_de_nascimento = '$dob',
                                idade = '$idade',
                                posicao = '$new_posicao',
                                nposicao = '$nposicao',
                                contrato = '$new_contrato',
                                tdc = '$new_tdc',
                                termino_contrato = '$termino_contrato',
                                emprestado = '$new_emprestado',
                                notas = '$new_notas',
                                u20squad = '$new_u20'
                                WHERE numero = '$old_numero';";
                        } else {
                            if ($deletar == "deletar") {
                                $sql = "DELETE FROM players WHERE numero = '$old_numero';";
                            }
                        }
                    }
                    
                    #echo $adicionar." ";
                    #echo $atualizar." ";
                    #echo $deletar." ";
                    
                    
                    if ($conn->query($sql) === TRUE) {
                        #echo " Records updated! ".$new_nome_completo."-".$new_apelido."-".$new_numero."-".$new_dob."-".$new_posicao."-".$new_contrato."-".$new_tdc."-".$new_emprestado."-".$new_notas."-".$u20squad;
                    } else {
                        #echo " Error: ".$sql."<br>".$conn->error;
                    }
                    
                    #used only when adding new players for changing name of players image
                    if ($adicionar) {
                        $filename = $dir.$_FILES['new-picture']['name'];
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                        #echo $filename;
                        #echo$imageFileType;
                    
                        // Check if image file is a actual image or fake image
                        $check = getimagesize($_FILES['new-picture']['tmp_name']);
                        if($check !== false) {
                            #echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                            } else {
                                #echo "File is not an image.";
                                $uploadOk = 0;
                            }
                    
                        // Check if file already exists
                        if (file_exists($filename)) {
                            #echo "Sorry, file already exists.";
                            $uploadOk = 0;
                        }
                    
                        // Check file size
                        if ($_FILES["new-picture"]["size"] > 1000000) {
                            #echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }
                    
                        // Allow certain file formats
                        if($imageFileType != "png") {
                            #echo "Sorry, only PNG files are allowed.";
                            $uploadOk = 0;
                        }
                    
                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            #echo "Sorry, your file was NOT uploaded.";
                        // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["new-picture"]["tmp_name"], $filename)) {
                                #echo "The file ". htmlspecialchars( basename( $_FILES["new-picture"]["name"])). " has been uploaded.";
                            } else {
                                #echo "Sorry, there was an error uploading your file.";
                            }
                        }
                        
                        rename($filename, $dir.$new_numero.'.'.$ext);
                    }
                    
                    #need to run the queries below to get rid of number with empty data upon adding a player to that particular number..
                    #or moving a player to new number
                    if ($adicionar || $atualizar) {
                        $sql = "DELETE FROM players WHERE numero = $new_numero AND apelido = ''";    // Select table here
                        
                        
                        if ($conn->query($sql) === TRUE) {
                            #echo " del_ Records updated! $new_numero";
                                if ($new_numero == 0) {
                                    if ($old_numero > 0) {
                                        #echo "ALERT! Please update player's number and image from ".$old_numero." to a 100+ value.";
                                    } else {
                                    #echo "ALERT! Please update player's number and image from 0 to a 100+ value.";
                                    }
                                }
                        } else {
                            #echo " del_ Error: ".$sql."<br>".$conn->error;
                        }
                    }
                    
                    #..for updating a player, need to re-insert the old number with empty data
                    if ($atualizar) {
                        
                        $filename = $dir.$_FILES['new-picture']['name'];
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                        #echo $filename;
                        #echo$imageFileType;
                    
                        // Check if image file is a actual image or fake image
                        $check = getimagesize($_FILES['new-picture']['tmp_name']);
                        if($check !== false) {
                            #echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                            } else {
                                #echo "File is not an image.";
                                $uploadOk = 0;
                            }
                    
                        // Check file size
                        if ($_FILES["new-picture"]["size"] > 1000000) {
                            #echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }
                    
                        // Allow certain file formats
                        if($imageFileType != "png") {
                            #echo "Sorry, only PNG files are allowed.";
                            $uploadOk = 0;
                        }
                    
                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            #echo "Sorry, your file was NOT uploaded.";
                        // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["new-picture"]["tmp_name"], $filename)) {
                                #echo "The file ". htmlspecialchars( basename( $_FILES["new-picture"]["name"])). " has been uploaded.";
                            } else {
                                #echo "Sorry, there was an error uploading your file.";
                            }
                        }
                        
                        rename($filename, $dir.$old_numero.'.'.$ext);
                        
                        if ($old_numero != $new_numero) {
                            #echo 'renaming atualizar picture with new number';
                            #echo $new_numero;
                            
                            rename($dir.$old_numero.'.'.$ext, $dir.$new_numero.'.'.$ext);
                            
                            
                            $sql = "INSERT INTO players (numero, nome_completo, apelido, dob, data_de_nascimento, idade, posicao, nposicao, contrato, tdc, termino_contrato, emprestado, notas, u20squad)
                            VALUES ('$old_numero', '', '', '', '', '', '', '', '', '', '', '', '', '')";    // Select table here 
                            
                            if ($conn->query($sql) === TRUE) {
                                #echo " up_ Records updated $old_numero.' '.$new_numero";
                                if ($old_numero > 100) {
                                    #echo "ALERT! Please update player's image from ".$old_numero." to ".$new_numero."."; 
                                } else {
                                    #echo " add_ Error: ".$sql."<br>".$conn->error;
                                }
                            }
                        }
                    }
                    
                    
                    #..for deleting a player, need to re-insert the old number with empty data
                    if ($deletar) {
                        $sql = "INSERT INTO players (numero, nome_completo, apelido, dob, data_de_nascimento, idade, posicao, nposicao, contrato, tdc, termino_contrato, emprestado, notas, u20squad)
                        VALUES ('$old_numero', '', '', '', '', '', '', '', '', '', '', '', '', '')";    // Select table here 
                        
                        if ($conn->query($sql) === TRUE) {
                            #echo " del_ Records updated $old_numero";
                            #echo "ALERT! Please delete player's image number ".$old_numero.".";
                            
                            unlink($dir.$old_numero.'.'.$ext);
                            
                        } else {
                            #echo " add_ Error: ".$sql."<br>".$conn->error;
                        }
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
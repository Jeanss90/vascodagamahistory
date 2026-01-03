<?php
include("vasco.php");
?>
<!DOCTYPE html>
<html lang="en">
    <?php echo "<title>Squad " . date('Y') . "</title>"; include('head.php');?>

    <body>
        <?php include('nav.php');?>

        <div class="body-page">
            <h1>Squad <?php echo date('Y')?></h1>
            <?php include('back-to-main.html');?>
                <table class="squad-text">
                    <thead>
                        <tr>
                            <th colspan=2><h2>Players</h2></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = 'CALL get_squad()';    // Select table here 
                        $result = mysqli_query($conn,$sql);  // here i am run the query
                        $i = 1;                             // only creates sequence of the data
                        while($row = mysqli_fetch_array($result)) // Showing all the data
                        {
                            
                            $apelido = $row['apelido'];
                            $id = $row['id'];
                            $numero = $row['numero'];
                            $nome_completo = $row['nome_completo'];
                            $data_de_nascimento = $row['data_de_nascimento'];
                            $idade = $row['idade'];
                            $posicao = $row['posicao'];
                            $contrato = $row['contrato'];
                            $termino_contrato = $row['termino_contrato'];
                            
                            
                            if ($previous_posicao <> $posicao) {
                                switch ($posicao) {
                                    case 'Goleiro':
                                        echo "<tr><th colspan=2><h4>Goalkeepers</h4></th></tr";
                                        break;
                                    case 'Zagueiro':
                                        echo "<tr><th colspan=2><h4>Defenders</h4></th></tr";
                                        break;
                                    case 'Lateral':
                                        echo "<tr><th colspan=2><h4>Wing Backs</h4></th></tr";
                                        break;
                                    case 'Volante':
                                        echo "<tr><th colspan=2><h4>Def. Midfielders</h4></th></tr";
                                        break;
                                    case 'Meia':
                                        echo "<tr><th colspan=2><h4>Att. Midfielders</h4></th></tr";
                                        break;
                                    case 'Atacante':
                                        echo "<tr><th colspan=2><h4>Forwards</h4></th></tr";
                                        break;
                                    case 'Tecnico':
                                        echo "<tr><th colspan=2><h4>Head Coach</h4></th></tr";
                                        break;
                                }
                            }
                        ?>    
                        <tr>
                            <td>
                                <?php echo $apelido; ?>
                                <a class="open-btn" href="#modal<?php echo $id?>">View</a>
                            </td>
                        </tr>

                        <div id="modal<?php echo $id?>" class="modal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2><?php echo $apelido?></h2>
                                    <a href="#!" class="close-btn">Close</a>
                                </div>
                                <div>
                                    <div class="player-info">
                                        <img class="foto" src="/img/player/<?php
                                            $files = scandir("img/player/");
                                                $number = 0;
                                                foreach($files as $filename) {
                                                    $filenumber = basename($filename, ".png");
                                                    if ($filenumber == $numero) {
                                                        $number++;
                                                    }
                                                }
                                                if ($number == 1) {
                                                    echo $numero;
                                                } else {
                                                    echo 0;
                                                }
                                            ?>.png" alt="#<?php echo $apelido ?>">
                                        <div class="player-details">
                                            <p><span>Shirt: </span><?php
                                                if ($numero >= 100) {
                                                    echo "s/n";
                                                } else {
                                                    echo $numero;    
                                                } ?></p>    
                                            <p><span>Full Name: </span><?php echo $nome_completo; ?></p>
                                            <p><span>Date of Birth: </span><?php echo $data_de_nascimento; ?></p>
                                            <p><span>Age: </span><?php echo $idade; ?></p>
                                            <p><span>Position: </span><?php echo $posicao; ?></p>
                                            <p><span>Contract Type: </span><?php echo $contrato; ?></p>
                                            <p><span>Expiry: </span><?php echo $termino_contrato; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $i++;
                            $previous_posicao = $posicao;
                        }
                        ?>

                    </tbody>
                </table>

            <?php include('back-to-main.html');?>

            <?php include('footer.php');?>
        </div>

        <script src='/script.js'></script>
    </body>
</html>
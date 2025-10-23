<?php

include ('database_jogos.php');



$db = $conn;

$tableName = 'jogos';

$columns = ['id', 'horario', 'casa', 'score_casa', 'penalti_casa', 'penalti_fora', 'score_fora', 'fora', 'competicao', 'estadio', 'rodada'];



$fetchData = fetch_jogos_data($db, $tableName, $columns);



function fetch_jogos_data($db, $tableName, $columns) {

    if(empty ($db)) {

        $msg = "Database connection error";

    } elseif (empty($columns) || !is_array($columns)) {

        $msg = "columns Name must be defined in an indexed array";

    } elseif (empty($tableName)) {

        $msg = "Table Name is empty";

    } else {



        $columnName = implode(", ", $columns);

        $query = "SELECT ".$columnName." FROM $tableName"." ORDER BY horario ASC";

        $result = $db->query($query);



        if($result==true) {

            if($result->num_rows > 0) {

                $row = mysqli_fetch_all ($result, MYSQLI_ASSOC);

                    $msg = $row;

            } else {

                $msg = "Nenhum jogo disponivel";

            }

        } else {

            $msg = mysqli_error($db);

        }

    }

return $msg;

}

?>
<?php

include ('database_players.php');



$db = $conn;

$tableName = 'players';

$columns = ['numero', 'nome_completo', 'apelido', 'data_de_nascimento', 'idade', 'posicao', 'contrato', 'termino_contrato'];



$fetchData = fetch_data($db, $tableName, $columns);



function fetch_data($db, $tableName, $columns) {

    if(empty ($db)) {

        $msg = "Database connection error";

    } elseif (empty($columns) || !is_array($columns)) {

        $msg = "columns Name must be defined in an indexed array";

    } elseif (empty($tableName)) {

        $msg = "Table Name is empty";

    } else {



        $columnName = implode(", ", $columns);

        $query = "SELECT ".$columnName." FROM $tableName"." ORDER BY numero ASC";

        $result = $db->query($query);



        if($result==true) {

            if($result->num_rows > 0) {

                $row = mysqli_fetch_all ($result, MYSQLI_ASSOC);

                    $msg = $row;

            } else {

                $msg = "Nenhum jogador disponivel";

            }

        } else {

            $msg = mysqli_error($db);

        }

    }

return $msg;

}

?>
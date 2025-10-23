<?php

include ('database_users.php');



$db = $conn;

$tableName = 'users';

$columns = ['id', 'user_name', 'password', 'name', 'dob', 'country', 'cpf', 'email', 'role'];



$fetchData = fetch_user_data($db, $tableName, $columns);



function fetch_user_data($db, $tableName, $columns) {

    if(empty ($db)) {

        $msg = "Database connection error";

    } elseif (empty($columns) || !is_array($columns)) {

        $msg = "columns Name must be defined in an indexed array";

    } elseif (empty($tableName)) {

        $msg = "Table Name is empty";

    } else {



        $columnName = implode(", ", $columns);

        $query = "SELECT ".$columnName." FROM $tableName"." ORDER BY id ASC";

        $result = $db->query($query);



        if($result==true) {

            if($result->num_rows > 0) {

                $row = mysqli_fetch_all ($result, MYSQLI_ASSOC);

                    $msg = $row;

            } else {

                $msg = "Nenhum usuario disponivel";

            }

        } else {

            $msg = mysqli_error($db);

        }

    }

return $msg;

}


?>
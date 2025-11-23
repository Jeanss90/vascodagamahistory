<?php

include "database_jogos.php";

header('Content-Type: application/json');

$sql = "SELECT id, national_team, small_team, date_q, `year`, conf, table_position, code, seed FROM clubs_wc";
$result = $conn->query($sql);

$data = [];


if ($result && $result -> num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    $data[] = $row;
    }

    echo json_encode([
        'data' => $data
    ]);

    } else {
    
        echo json_encode([
        'data' => []
    ]);
    }

?>
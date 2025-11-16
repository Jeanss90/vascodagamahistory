<?php

include "database_jogos.php";

header("Content-Type: application/json; charset=UTF-8");

$response = [];

?>

<?php

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $casa = filter_input(INPUT_GET, 'casa' , FILTER_SANITIZE_SPECIAL_CHARS);
    $fora = filter_input(INPUT_GET, 'fora' , FILTER_SANITIZE_SPECIAL_CHARS);
}


$sql = "SELECT * FROM jogos WHERE casa = '$casa' AND fora = '$fora'";
$result = $conn->query($sql);
if($result->num_rows>0) {
    while($row = $result->fetch_assoc())
    {
        $response[] = $row;
    }
}

echo json_encode($response);

?>
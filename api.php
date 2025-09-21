<?php

include "database_jogos.php";

?>

<html>
<head>
<title>Teste API</title>
</head>

<body>
<h1>Teste API</h1>


<form action="/api.php" method="get">

    <h1>User</h1>
    <div id="user"></div>
    
    <label for="time">Time: </label>
    <input id="time" name="time" type="text" />

    <label for="fora">Fora: </label>
    <input id="fora" name="fora" type="text" />
    
    <input type="submit" value="Submit">
</form>

<?php

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $time = filter_input(INPUT_GET, 'time' , FILTER_SANITIZE_SPECIAL_CHARS);
    $fora = filter_input(INPUT_GET, 'fora' , FILTER_SANITIZE_SPECIAL_CHARS);
}


$sql = "SELECT * FROM jogos WHERE casa = '$time'";
$sql .= $fora != "" ? "&& fora = '$fora'" : "";
$result = $conn->query($sql);
if($result->num_rows>0) {
    while($row = $result->fetch_assoc())
    {
        echo json_encode($row);
    }
}

?>

</body>

</html>


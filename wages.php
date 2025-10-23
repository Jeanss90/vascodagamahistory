<?php 
session_start();
include('vasco.php');

$now = time();

if (isset($_GET['action'])) {
    header('Content-Type: application/json');

    if ($_GET['action'] === 'getYears' && isset($_GET['player_id'])) {
        $playerId = intval($_GET['player_id']);

        $result = $conn->query("SELECT DISTINCT ano FROM pagamentos WHERE id = $playerId");
        $anos = array_column($result->fetch_all(MYSQLI_ASSOC), 'ano');

        echo json_encode($anos);
        exit;
    }

    if ($_GET['action'] === 'getPlayerData' && isset($_GET['player_id'], $_GET['ano'])) {
        $playerId = intval($_GET['player_id']);
        $ano = intval($_GET['ano']);

        $result = $conn->query("SELECT nome_completo, tdc, salario, mes, ano 
            FROM players 
            JOIN pagamentos ON players.id = pagamentos.id
            WHERE pagamentos.id = $playerId AND pagamentos.ano = $ano");
        $playerData =[];

        #initializing month payments array
        $pagamentos = [
            '01' => false,
            '02' => false,
            '03' => false,
            '04' => false,
            '05' => false,
            '06' => false,
            '07' => false,
            '08' => false,
            '09' => false,
            '10' => false,
            '11' => false,
            '12' => false
        ];

        while ($row = $result->fetch_assoc()) {
            // Use the first row to populate player info
            if (empty($playerData)) {
                $playerData['nome_completo'] = $row['nome_completo'];
                $playerData['tdc'] = $row['tdc'];
                $playerData['salario'] = $row['salario'];
            }

            $mesNum = $row['mes'];
            if (isset($pagamentos[$mesNum])) {
                $pagamentos[$mesNum] = true;
            }
        }
    }
    
    $playerData['pagamentos'] = $pagamentos;

    echo json_encode($playerData);
    
    exit;
    }


if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Developer - Wages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="wages-form">
    <?php include('loggedinheader.php');?>

    <div class="section">
        <div class="card-panel">   
            <span>
                <div class="form-style">
                    <h1 class="center">Gerenciar Salários</h1>

                    <!-- Player selection form -->
                    <form id="playerForm" action="/wages.php" method="post">
                        <div class="field-container" style="padding-bottom:5px; border-bottom: solid #D52315 0.5px; margin-bottom:10px">
                            <label for="jogador" style="padding-top: 8px">
                                <!--Testing without class browser default-->
                                <!-- IMPORTANT, use class browser-default as materialize css does not work properly with select on ios iphone-->
                                <select name="jogador" id="jogador" class="browser-default" style="
                                        background-color: antiquewhite;
                                        color: var(--myred);
                                        font-weight: bold;
                                        font-style: italic;
                                        border: var(--mygrey) 1px solid;">
                                    <option value="" disabled selected>Selecionar jogador</option>
                                    <?php 
                                        $sql = 'SELECT apelido, id FROM players WHERE apelido <> "" ORDER BY apelido;';
                                        $result = mysqli_query($conn,$sql);  // here i am run the query
                                        $i = 1;                             // only creates sequence of the data
                                        while($row = mysqli_fetch_array($result)) // Showing all the data
                                        {
                                        
                                        $ncamisa = $row['apelido'];
                                        $id = $row['id'];
                                        
                                        echo "<option value='$id'>$ncamisa ($id)</option>";

                                        $i++;
                                        }
                                    ?>
                                </select>
                            </label>

                            <label for="ano" style="padding-top: 8px">
                                <!--Testing without class browser default-->
                                <!-- IMPORTANT, use class browser-default as materialize css does not work properly with select on ios iphone-->
                                <select name="ano" id="ano" class="browser-default" style="
                                        background-color: antiquewhite;
                                        color: var(--myred);
                                        font-weight: bold;
                                        font-style: italic;
                                        border: var(--mygrey) 1px solid;">
                                    <option value="">Selecionar o Jogador:</option>
                                </select>
                            </label>

                            <div class="input-field"  style="display: grid; margin: auto;">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-info">
                                <button type="button" id="reset" class="btn btn-warning">Limpar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Player details form -->
                    <form id="paymentForm" action="/wages_results.php" method="post" enctype="multipart/form-data">

                        <div class="form-container">
                            <div class="field-container">
                                <label for="nome_completo">Nome Completo:</label>
                                <div class=input-fields>
                                    <input disabled type="text" id="nome_completo" name="nome_completo" placeholder="Fulano Sicrano Beltrano" style="color: #28282B">
                                </div>
                            </div>

                            <div class="field-container">
                                <label for="tdc">Término de Contrato:</label>
                                <div class=input-fields>
                                    <input disabled type="date" id="tdc" name="tdc" style="color: #28282B">
                                </div>
                            </div>

                            <div class="field-container">
                                <label for="salario">Salário:</label>
                                <div class=input-fields>
                                    <input type="text" id="salario" name="salario" placeholder="R$ xxx.xxx,xx" disabled style="
                                        font-weight: bold;
                                        font-style: italic;
                                        background-color: var(--mygrey);
                                        -webkit-text-fill-color: var(--mygold);
                                        padding: 0 5px;">
                                </div>
                            </div>

                            <div class="form-container">
                                <!--do not use class .field-container as this section is using materialize grid-->
                                <div class="input-field">
                                    <div class="row" style="padding: 10px; margin-left: 10%; margin-right: unset;">
                                        <p class="col s4">
                                            <label for="1">
                                                <input type="checkbox" class="filled-in" id="1" name="mes[]" value="01">
                                                <span>Janeiro</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="2">
                                                <input type="checkbox" class="filled-in" id="2" name="mes[]" value="02">
                                                <span>Fevereiro</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="3">
                                                <input type="checkbox" class="filled-in" id="3" name="mes[]" value="03">
                                                <span>Março</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="4">
                                                <input type="checkbox" class="filled-in" id="4" name="mes[]" value="04">
                                                <span>Abril</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="5">
                                                <input type="checkbox" class="filled-in" id="5" name="mes[]" value="05">
                                                <span>Maio</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="6">
                                                <input type="checkbox" class="filled-in" id="6" name="mes[]" value="06">
                                                <span>Junho</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="7">
                                                <input type="checkbox" class="filled-in" id="7" name="mes[]" value="07">
                                                <span>Julho</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="8">
                                                <input type="checkbox" class="filled-in" id="8" name="mes[]" value="08">
                                                <span>Agosto</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="9">
                                                <input type="checkbox" class="filled-in" id="9" name="mes[]" value="09">
                                                <span>Setembro</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="10">
                                                <input type="checkbox" class="filled-in" id="10" name="mes[]" value="10">
                                                <span>Outubro</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="11">
                                                <input type="checkbox" class="filled-in" id="11" name="mes[]" value="11">
                                                <span>Novembro</span>
                                            </label>
                                        </p>
                                        <p class="col s4">
                                            <label for="12">
                                                <input type="checkbox" class="filled-in" id="12" name="mes[]" value="12">
                                                <span>Dezembro</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="player_id" name="player_id">
                            <input type="hidden" id="ano_hidden" name="ano">
                            <input type="hidden" id="nome_hidden" name="nome_completo">
                            <input type="hidden" id="salario_hidden" name="salario">
                            
                            <div class="wages-actions">
                                <input type="submit" id="payButton" name="pay" value="Efetuar Pagamento" class="btn btn-info" disabled>
                            </div>
                        </form>
                    </div>

                </div>

                <p class="center">
                    <br>
                    <a href="/dev_options.php">Go to options menu</a><br>
                    <a href="/squad.php">Go to Squad page</a>
                </p>
            </span>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const jogadorSelect = document.getElementById("jogador");
            const anoSelect = document.getElementById("ano");
            const playerForm = document.getElementById("playerForm");
            const resetButton = document.getElementById("reset");
            const payButton = document.getElementById("payButton");

            const nomeCompleto = document.getElementById("nome_completo");
            const tdc = document.getElementById("tdc");
            const salario = document.getElementById("salario");
            

            // Fetch available years when a player is selected
            jogadorSelect.addEventListener("change", async () => {
                const playerId = jogadorSelect.value;
                //console.log("Selected player:", playerId);

                if (!playerId) return;

                try {
                    const response = await fetch(`wages.php?action=getYears&player_id=${playerId}`);
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                    const data = await response.json();
                    //console.log("Fetch Response (years):", data);

                    // Clear and populate "ano" select
                    anoSelect.innerHTML = '<option value="">Selecionar o Ano:</option>';
                    data.forEach(ano => {
                        const option = document.createElement("option");
                        option.value = ano;
                        option.textContent = ano;
                        anoSelect.appendChild(option);
                    });

                } catch (error) {
                    console.error("Fetch Error (getYears):", error);
                }
            });

            // Handle form submission to fetch player data
            playerForm.addEventListener("submit", async (event) => {
                event.preventDefault();

                const playerId = jogadorSelect.value;
                const ano = anoSelect.value;

                if (!playerId || !ano) {
                    alert("Selecione jogador e ano!");
                    return;
                }

                //adding hidden fields
                document.getElementById('player_id').value = playerId;
                document.getElementById('ano_hidden').value = ano;

                try {
                    const response = await fetch(`wages.php?action=getPlayerData&player_id=${playerId}&ano=${ano}`);
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                    const data = await response.json();
                    //console.log("Fetch Response (player data):", data);

                    // Populate player info
                    nomeCompleto.value = data.nome_completo || "";
                    tdc.value = data.tdc || "";
                    salario.value = "R$ " + (data.salario || "0,00");

                    // Update hidden fields for POST
                    document.getElementById('nome_hidden').value = data.nome_completo || "";
                    document.getElementById('salario_hidden').value = data.salario || "";

                    // Update checkboxes based on pagamentos
                    for (let month = 1; month <= 12; month++) {
                        const monthNum = month.toString().padStart(2, "0");
                        const checkbox = document.getElementById(month.toString());
                        if (!checkbox) continue;

                        if (data.pagamentos[monthNum]) {
                            checkbox.checked = true;
                            checkbox.disabled = true; // already paid
                        } else {
                            checkbox.checked = false;
                            checkbox.disabled = false; // allow payment
                        }
                    }

                    enablePayButton(true);
                } catch (error) {
                    console.error("Fetch Error (getPlayerData):", error);
                }
            });

            // Enable or disable "Efetuar Pagamento" button
            function enablePayButton(enable) {
                payButton.disabled = !enable;
            }

            // Reset everything when "Limpar" is clicked
            resetButton.addEventListener("click", () => {
                jogadorSelect.selectedIndex = 0;
                anoSelect.innerHTML = '<option value="">Selecionar o Jogador</option>';

                nomeCompleto.value = "";
                tdc.value = "";
                salario.value = "";

                // Reset checkboxes
                for (let i = 1; i <= 12; i++) {
                    const checkbox = document.getElementById(i.toString());
                    if (checkbox) {
                        checkbox.checked = false;
                        checkbox.disabled = false;
                    }
                }

                enablePayButton(false);
            });
        });
    </script>

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

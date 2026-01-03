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
        <title>Salaries</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">
            <div class="form-style">

                <h1>Manage Salaries</h1>

                <!-- Player selection form -->
                <form id="playerForm" action="/wages.php" method="post">
                    <div class="form-container-select">
                        <div>
                            <label for="jogador">
                                <select style="margin-bottom: 10px" class="input-field input-field-select" name="jogador" id="jogador">
                                    <option value="" disabled selected>Select Player</option>
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

                            <label for="ano">
                                <select class="input-field input-field-select" name="ano" id="ano">
                                    <option value="">Select a Player First!</option>
                                </select>
                            </label>
                        </div>
                        

                        <div>
                            <button type="submit" name="buscar" value="select" class="btn btn-form">Select</button>
                            <button type="submit" name="select" calue="limpar" class="btn btn-form">Clear</button>
                        </div>
                    </div>
                </form>

                <!-- Player details form -->
                <form id="paymentForm" action="/wages-results.php" method="post" enctype="multipart/form-data">

                    <div class="form-container">
                        <div class="field-container">
                            <label class="label-field" for="nome_completo">Full Name:</label>
                            <input class="input-field" disabled type="text" id="nome_completo" name="nome_completo" placeholder="Fulano Sicrano Beltrano">
                        </div>

                        <div class="field-container">
                            <label class="label-field" for="tdc">Contract Expiry:</label>
                            <input class="input-field" disabled type="date" id="tdc" name="tdc" style="color: #28282B">
                        </div>

                        <div class="field-container">
                            <label class="label-field" for="salario">Salário:</label>
                            <input class="input-field" type="text" id="salario" name="salario" placeholder="R$ xxx.xxx,xx" disabled>
                        </div>

                        <div class="field-container">
                            <div class="input-field months">
                                <div class="months-field">
                                    <div>
                                        <p>
                                            <label for="1"></label>
                                            <input type="checkbox" id="1" name="mes[]" value="01">
                                            <span class="months-field-full">January</span>
                                            <span class="months-field-short">JAN</span>
                                        </p>
                                        <p>
                                            <label for="2"></label>
                                            <input type="checkbox" id="2" name="mes[]" value="02">
                                            <span class="months-field-full">February</span>
                                            <span class="months-field-short">FEB</span>
                                        </p>
                                        <p>
                                            <label for="3"></label>
                                            <input type="checkbox" id="3" name="mes[]" value="03">
                                            <span class="months-field-full">March</span>
                                            <span class="months-field-short">MAR</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            <label for="4"></label>
                                            <input type="checkbox" id="4" name="mes[]" value="04">
                                            <span class="months-field-full">April</span>
                                            <span class="months-field-short">APR</span>
                                        </p>
                                        <p>
                                            <label for="5"></label>
                                            <input type="checkbox" id="5" name="mes[]" value="05">
                                            <span class="months-field-full">May</span>
                                            <span class="months-field-short">MAY</span>
                                        </p>
                                        <p>
                                            <label for="6"></label>
                                            <input type="checkbox" id="6" name="mes[]" value="06">
                                            <span class="months-field-full">June</span>
                                            <span class="months-field-short">JUN</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            <label for="7"></label>
                                            <input type="checkbox" id="7" name="mes[]" value="07">
                                            <span class="months-field-full">July</span>
                                            <span class="months-field-short">JUL</span>
                                        </p>
                                        <p>
                                            <label for="8"></label>
                                            <input type="checkbox" id="8" name="mes[]" value="08">
                                            <span class="months-field-full">August</span>
                                            <span class="months-field-short">AUG</span>
                                        </p>
                                        <p>
                                            <label for="9"></label>
                                            <input type="checkbox" id="9" name="mes[]" value="09">
                                            <span class="months-field-full">September</span>
                                            <span class="months-field-short">SEP</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            <label for="10"></label>
                                            <input type="checkbox" id="10" name="mes[]" value="10">
                                            <span class="months-field-full">October</span>
                                            <span class="months-field-short">OCT</span>
                                        </p>
                                        <p>
                                            <label for="11"></label>
                                            <input type="checkbox" id="11" name="mes[]" value="11">
                                            <span class="months-field-full">November</span>
                                            <span class="months-field-short">NOV</span>
                                        </p>
                                        <p>
                                            <label for="12"></label>
                                            <input type="checkbox" id="12" name="mes[]" value="12">
                                            <span class="months-field-full">December</span>
                                            <span class="months-field-short">DEC</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="player_id" name="player_id">
                        <input type="hidden" id="ano_hidden" name="ano">
                        <input type="hidden" id="nome_hidden" name="nome_completo">
                        <input type="hidden" id="salario_hidden" name="salario">
                        
                        <div class="form-actions">
                            <button type="submit" id="payButton" name="pay" class="btn btn-form" disabled>Make Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php include('back-to-options.html');?>
        <?php include('back-to-main.html');?>

        <?php include('footer.php');?>

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

        <script src='/script.js'></script>
    </body>
</html>

<?php 
} else {
    header("Location: dev.php");
    exit();
}
?>

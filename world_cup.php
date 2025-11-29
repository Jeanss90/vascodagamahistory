<?php
    include("database_jogos.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>World Cup 2026</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="background">
    <div class="center-align">
        <div class="section">
            <div class="card-panel carioca">
                <span>
                    <div class="container" style="background-color: white; color: black;">
                        <div class="row">
                            <div class="col s12">
                                <a id="logo-container" href="#" class="brand-logo" style="height: inherit;">
                                    <img class="responsive" src="/img/wc26/2026_FIFA_World_Cup_emblem.svg" alt="logo_wc26" style="padding: 10px; width: 150px;">
                                </a>
                                <p style= "text-align: center">
                                    <a href="/index.php"><img class="backmainpage">Back to Main Page</a>
                                </p>
                                <p style= "text-align: center">
                                    <a href="/competitions.php"><img class="backmainpage">Back to Competitions</a>
                                </p>
                            </div>
                        </div>
                        <div class="col s12"><h2>Qualified Teams</h2></div>
                        <div class="row">

                            <?php
                                $sql = 'SELECT * FROM clubs_wc WHERE date_q IS NOT NULL ORDER BY id;';    // Select table here 
                                $result = mysqli_query($conn,$sql);  // here i am run the query
                                $i = 1;                             // only creates sequence of the data
                                

                                while($row = mysqli_fetch_assoc($result)) // Showing all the data
                                {

                                    $nationalTeam = $row['national_team'];
                                    $smallTeam = $row['small_team'];
                                    $dateQ = $row['date_q'];
                                    $newDate = date_format(date_create($dateQ), 'd/m/Y');

                                    switch ($nationalTeam) {
                                        case 'Canada':
                                        case 'Mexico';
                                        case 'United States':
                                            $nationalTeam = $nationalTeam.' (Host)';
                                            break;
                                        default:
                                            $nationalTeam = $nationalTeam;
                                    }
                                
                                    echo "

                            
                                    <div class='col s12 m6 l3'>
                                        <img class='responsive' src='/img/fed/$smallTeam.svg' alt='$smallTeam' style='height: 150px; border-radius: 0'>
                                        <p class='center'>$nationalTeam - $newDate</p>
                                    </div>

                                    ";


                                $i++;
                                }
                            ?>
                        </div>
                        <iframe src="/world_cup_group.php" style="width: 100%; height: 1440px; border: none;"></iframe>
                        <iframe src="/world_cup_group_full.php" style="width: 100%; height: 1440px; border: none;"></iframe>
                    </div>
                </span>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>
</body>
<footer>
    <?php
        include('footer.php');
    ?>
</footer>
    
</html>
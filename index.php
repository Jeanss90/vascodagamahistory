<?php
include('jogos.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>CR Vasco da Gama</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="background">
    <nav>
        
        <div class="nav-wrapper">
            <a href="#" class="brand-logo center"><img class="responsive-img" src="/img/android-chrome-192x192.png" style="
                border-radius: 5px;
                width: 25%;
                margin-top: 5px;"></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        
            <ul id="nav-mobile" class="right hide-on-med-and-down">  
                <li><a href="squad.php" style="color: antiquewhite;">Current Squad</a></li>
                <li><a href="competitions.php" style="color: antiquewhite;">Competitions</a></li>
                <li><a href="dev.php" style="color: antiquewhite; display: flex;">Login<i class="tiny material-icons" style="margin-left: 2px">person</i></a></li>
            </ul>
        </div>
        
        

        <ul class="sidenav" id="mobile-demo">
            <li class="logo" style="height: 150px;">
                <a id="logo-container" href="/" class="brand-logo" style="height: inherit;">
                    <img src="/img/logovascodagamahistory.svg" alt="logo vascodagamahistory" style="height: inherit;">
                </a>
            </li>
            <li><a style="font-weight: bold" href="squad.php">Current Squad</a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                    <a class="collapsible-header waves-effect waves-red" style="font-weight: bold" >Competitions</a>
                    <div class="collapsible-body">
                        <ul>
                            <a href="carioca.php">Carioca</a>
                            <a href="brasileirao.php">Brasileirão</a>
                            <a href="copa-do-brasil.php">Copa do Brasil</a>
                            <a href="sudamericana.php">Copa Sudamericana</a>
                            <a href="world_cup.php">World Cup 2026</a>
                        </ul>
                    </div>
                </li>
                <li><a href="dev.php" style="font-weight: bold; display: flex" >Login<i class="tiny material-icons" style="margin-left: 2px">person</i></a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div>
        
        <div class="logo-fixed">
            <img class="responsive-img" src="/img/vasco-logo.png" alt="Vasco da gama" id="watermark">
        </div>
        
        <div>    
            <i class="large material-icons" style="z-index: 2" alt="Hino do Vasco da Gama" id="audio" onclick="startMusic()" onmouseover="audioHover()">volume_off</i>
        </div>
        
        <div style="position: sticky;top: 0; width: 100%; z-index: 2">
            <div class="match match-border">
            
                <?php
                    $sql = 'SELECT horario, casa, escudo_casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio
                            FROM ((jogos
                            INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                            INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                            WHERE (casa = "Vasco da Gama" OR fora = "Vasco da Gama") AND horario > DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY horario;';    // Select table here 
                    $result = mysqli_query($conn,$sql);  // here i am run the query
                    $i = 1;                             // only creates sequence of the data
                    while($row = mysqli_fetch_array($result)) // Showing all the data
                    {
                    
                    $horario = $row['horario'];
                    $casa = $row['casa'];
                    $fora = $row['fora'];
                    $competicao = $row['competicao'];
                    $estadio = $row['estadio'];
                    $escudo_casa = $row['escudo_casa'];
                    $escudo_fora = $row['escudo_fora'];
                    $score_casa = $row['score_casa'];
                    $score_fora = $row['score_fora'];
                    $penalti_casa = $row['penalti_casa'];
                    $penalti_fora = $row['penalti_fora'];
                    
                    
                    $day = date_format(date_create($horario), 'D d/m/Y');
                    $time = date_format(date_create($horario), 'H:i');
                    break;
                    
                    }
                        
                    date_default_timezone_set('Europe/London');
                    $now = date("Y-m-d H:i:s");
                    #WHEN SUMMER TIME, PRELIVE IS -2, NORMAL IS -1
                    $prelive = date('Y-m-d H:i:s', strtotime($horario. ' - 1 hours'));
                    $afterlive = date('Y-m-d H:i:s', strtotime($horario. ' + 3 hours'));
                    
                    #echo $prelive.' '.$horario.' '.$now.' '.$afterlive;
                    
                    if($now >= $prelive && $now <= $afterlive) {
                        echo '<div class="live header-match center" style="padding-top: 2px">';
                    } else {
                        echo '<div class="not-live header-match center" style="padding-top: 2px">';
                    }
                ?>
                            
                            <div class="preloader-wrapper active center">
                                <div class="spinner-layer spinner-red-only">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div><div class="gap-patch">
                                        <div class="circle"></div>
                                    </div><div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>

                                
            
                    <div class="game" style="visibility: hidden; display: none;">   
                
                        <div class="game-info">
                
                        <!--MANUALLY ENTERING MATCH DETAILS-->
                            <!--
                            <div class="info">
                                <span> Campeonato Brasileiro </span><br>
                                <span> thu 04/07/2024 </span><br>
                            </div>
                            <div class="info">
                                <span>São Januário</span><br>
                                <span> 00:00 BST </span><br>
                            </div>
                        </div>
                        <div class="score">
                            <div class="score-home">
                                <span class="team">Vasco</span>
                                <img class="home-team" src="https://s.sde.globo.com/media/organizations/2021/09/04/vasco_SVG.svg" title="Vasco">
                            </div>
                            <div class="score-box">
                                <span class="goals">2</span>
                                <span class="penalties-home"></span>
                                <span class="versus">
                                    <svg viewBox="0 0 100 100" width="100%" height="100%">
                                        <line x1="-3" x2="100" y1="1" y2="100" stroke="#D52315" stroke-width="5"></line>
                                        <line x1="-3" x2="100" y1="100" y2="1" stroke="#D52315" stroke-width="5"></line>
                                    </svg>
                                </span>
                                <span class="penalties-away"></span>
                                <span class="goals">0</span>
                            </div>
                            <div class="score-away">
                                <img class="away-team" src="https://s.sde.globo.com/media/organizations/2021/09/19/Fortaleza_2021_1.svg"  title="Fortaleza">
                                <span class="team">Fortaleza</span>
                            </div>
                            -->
                                        
                            <!--GET MATCHES FROM DATABASE-->
                
                            <?php
                                $sql = 'SELECT jogos.id, horario, casa, escudo_casa, score_casa, penalti_casa, penalti_fora, score_fora, fora, escudo_fora, competicao, estadio
                                        FROM ((jogos
                                        INNER JOIN brasao_casa ON brasao_casa.clube = jogos.casa)
                                        INNER JOIN brasao_fora ON brasao_fora.clube = jogos.fora)
                                        WHERE (casa = "Vasco da Gama" OR fora = "Vasco da Gama") AND horario > DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY horario;';    // Select table here 
                                $result = mysqli_query($conn,$sql);  // here i am run the query
                                $i = 1;                             // only creates sequence of the data
                                while($row = mysqli_fetch_array($result)) // Showing all the data
                                {

                                $horario = $row['horario'];
                                $casa = $row['casa'];
                                $fora = $row['fora'];
                                $competicao = $row['competicao'];
                                $estadio = $row['estadio'];
                                $escudo_casa = $row['escudo_casa'];
                                $escudo_fora = $row['escudo_fora'];
                                $score_casa = $row['score_casa'];
                                $score_fora = $row['score_fora'];
                                $penalti_casa = $row['penalti_casa'];
                                $penalti_fora = $row['penalti_fora'];
                                
                                
                                $day = date_format(date_create($horario), 'D d/m/Y');
                                $time = date_format(date_create($horario), 'H:i');
                                break;
                                
                                }
                                
                            date_default_timezone_set('Europe/London');
                            $now = date("Y-m-d H:i:s");
                            $prelive = date('Y-m-d H:i:s', strtotime($horario. ' - 1 hours'));
                            
                            #echo $prelive.' '.$horario.' '.$now;
                            
                            
                
                            
                            
                            $year = date("Y");
                            $yearmatch = date_format(date_create($horario), 'Y');
                            $showfirstmatch = date($year + '-01-07');
                            if ($yearmatch > $year) {
                                echo "<p><b>END OF SEASON</b></p>";
                            } if ($now <= $showfirstmatch) {
                                echo "<p><b>Happy New Year!</b></p>";
                            }
                                else {
                                
                                echo
                                "
                                <div class='info'>
                                    <span> $competicao </span><br>
                                    <span> $day </span><br>
                                </div>
                                <div class='info'>
                                    <span> $estadio </span><br>
                                    <span> $time </span><br>
                                </div>
                            </div>
                            <div class='score'>
                                <div class='score-home'>
                                    <span class='team'>$casa</span>
                                    <img class='home-team' src='$escudo_casa' title='$casa'>
                                </div>
                                    <div class='score-box'>
                                        <span class='goals'>$score_casa</span>
                                        <span class='penalties-home'>$penalti_casa</span>
                                        <span class='versus'>
                                            <svg viewBox='0 0 100 100' width='100%' height='100%'>
                                                <line x1='-3' x2='100' y1='1' y2='100' stroke='#D52315' stroke-width='5'></line>
                                                <line x1='-3' x2='100' y1='100' y2='1' stroke='#D52315' stroke-width='5'></line>
                                            </svg>
                                        </span>
                                        <span class='penalties-away'>$penalti_fora</span>
                                        <span class='goals'>$score_fora</span>
                                    </div>
                                <div class='score-away'>
                                    <img class='away-team' src='$escudo_fora'  title='$fora'>
                                    <span class='team'>$fora</span>
                                </div>
                                ";
                            }
                        ?>
                        </div>
                    </div>    
                </div>
            </div>
        </div>

        <div class="center-align">
        
        
        <!--Primary Section-->
        <div class="section" style="
            padding-bottom: 0px; padding-top: 0px;
        ">
            <div class="card-panel" style="border-radius: 0px">
                <span>
                    <h1 id="maintitle">CR Vasco da Gama <br>(Brazilian Football Club)</h1>
                    <p>In this website you will get to know more about the centenary Brazilian football club “Vasco da Gama”. Based in Rio de Janeiro, started as a Regatta Club and formed its football team a few years later. Here, you will get to know more about its glorious early years and the fight against racism, being the first ever club to accept black people in its football team. Also, here you will navigate through Vasco da Gama's best decades, in which they won 4 football national championships. On the other hand, you will also get to know their worst years as a club from early 2000's. Finally, we will see their current team and what they expect for their future with the newly acquisition by the American group 777 partners.</p>
                    <ul>
                        <li><a href="#section1">Club History and Foundation</a></li>
                        <li><a href="#section2">The Historic Response of 1924 (“A Resposta Histórica”)</a></li>
                        <li><a href="#section3">The First Decades of International Success</a></li>
                        <li><a href="#section4">Brazil National Champions</a></li>
                        <li><a href="#section5">The Best Years</a></li>
                        <li><a href="#section6">The Worst Years and a Breather in the Early 2010's</a></li>
                        <li><a href="#section7">The Present and the Future</a></li>
                        <li><a href="#section8">Useful links</a></li>
                    </ul>    
                </span>
            </div>
        </div>
        
            
            
        <div class="parallax-container">
            <div class="parallax"><img src="/img/sao_januario-parallax1.jpg"></div>
        </div>
                
                
                
                    <!--Section 1-->
                        <div class="section" style="
                            padding-top: 0px;
                        ">    
                            <div class="card-panel" style="border-radius: 0px 0px 2px 2px">
                                <span>
                                <h2 id="section1">Club History and Foundation</h2>
                                    <div class="centered">
                                        <img class="centered responsive-img materialboxed" src="/img/crest.jpg" alt="Vasco da Gama Crest" data-caption="Vasco da Gama Crest">
                                    </div>
            
                                    <h3>Club foundation and initials: CRVG</h3>
                                        <p>Vasco da Gama was founded on 21st of August 1989 as a “CR” club (Club of Regatta), which is related to rowing. In the late years of the 19th century this sport became very popular, and a lot of rowing clubs were founded in the city of Rio de Janeiro. A group of friends with the desire to found a new rowing club in town gathered with some Portuguese merchants who had the necessary capital to invest in the early years. A total of 62 associates started the new institution and decided to call it “Vasco da Gama” in homage of the famous Portuguese navigator who was the first European to reach India by sea.</p>
                                    
                                    <h3>Maltese Cross</h3>
                                        <p>The founders decided, in the beginning of September, about the uniform, colors and symbols of the newly created club. One of the more famous symbols of Vasco da Gama is the Maltese Cross. Although it is described in the meeting minutes as the Maltese Cross, effectively the one meant to be used was the “Order of Christ Cross”. This choice was, again, related to the Portuguese explorer Vasco da Gama which was a Knight of the Order of Christ and utilized the cross in the sail of its ships. For some unknown reason the Maltese Cross was used and the club was popularised as the "cruzmatinos", the club of the Maltese Cross.<br>Well, in fact, the actual cross used is the Patea Cross.</p>
                                        <div class="centered">
                                            <img class="responsive-img  materialboxed" src="/img/crosses.jpg" alt="Crosses" data-caption="Crosses">
                                        </div>    
            
                                        <h3>Football Team</h3>
                                        <p>CR Vasco da Gama football department was created on 6th of November 1915. Again, becoming a popular sport in Rio de Janeiro in the 1910's, the club decides to form the new department. The president of the club realized he could gather people from the Portuguese colony in the city and incorporated an already formed club called Lusitânia Sport Club. As the Lusitânia club had only Portuguese club members they were not allowed to participate in the football competitions of the city organized by the league (Liga Metropolitana de Sports Athléticos), so the idea was to do a merge which occurred in this date. According to the journalist Mario Filho, Vasco da Gama had a very small window to sign the club up in the league, so it called many mulatto and black players coming from other small clubs and also from kickarounds in the city.</p>
                                        <div class="centered">
                                            <img class="responsive-img materialboxed" src="/img/shirt1.jpg" alt="Shirt 1" width="500" data-caption="Home shirt - season 2020/21" style="margin-bottom: 5px">
                                            <img class="responsive-img materialboxed" src="/img/shirt2.jpg" alt="Shirt 2" width="500" data-caption="Away shirt - season 2020/21">
                                            
                                        </div>
                                        <?php
                                            include('top.php')
                                        ?>
                                </span>
                            </div>
                        </div>
                    
                    
                    <!--Section 2-->
                    <div class="divider"></div>
                        <div class="section"> 
                            <div class="card-panel">
                                <span>
                                <h2 id="section2">The Historic Response of 1924 (“A Resposta Histórica”)</h2>
            
                                    <h3>The Historic Response letter</h3>
                                    <p>After winning some titles in the lower divisions, Vasco was eligible to play in the first division of the Liga Metropolitana de Desportos Terrestres (LMDT) in 1923.<br>
                                        Other teams, like Bangu, had black players but this was the first time that elitist clubs (from the south region of Rio de Janeiro like Flamengo, Fluminense and Botafogo) felt uncomfortable playing a team from the suburb. In fact, Vasco da Gama was crowned champion of the Campeonato Carioca (LMTD) of 1923 playing with lots of black players like Nelson da Conceição, a taxi chauffeur, Nicolino, the dockworker, Ceci, a wall painter, the truck driver Bolão, and four white illiterate players. The deal was that those “elite” clubs couldn't stand losing for a team formed by black and poor people.<br>
                                        In 1924, those called “elite” clubs decided to abandon the LMDT and formed another league called Associação Metropolitana de Esportes Atléticos (AMEA) and left Vasco da Gama out of it. The terms of the new league stated that Vasco da Gama could only enter the league if they were to get rid of 12 athletes (all of them black people) just because they had dubious professions. President of Vasco da Gama José Augusto Prestes, sent a letter to AMEA refusing to adhere to such conditions and abandoning the idea of joining AMEA. This letter is known as the Historic Response, <b><i>“A Resposta Histórica"</i></b>, and it is a milestone in the fight against racism in football.<br>
                                        </p>
                                    <div class="centered">
                                        <img class="responsive-img materialboxed" src="/img/Carta_Resposta_Historica.png" alt="The Historic Response letter" data-caption="The Historic Response letter">
                                    </div>
                                    
                                    <h3>São Januário Stadium Construction</h3>
                                    <p>Another term of AMEA was that Vasco da Gama didn't have their own stadium. Nowadays, just to say, between Vasco, Botafogo, Fluminense and Flamengo, only Vasco da Gama play in their own stadium and the other three play in public stadiums, owned by city government and used in a concession.<br>
                                        Constructing Vasco da Gama's own stadium was already an idea from the club but this controversial decision from AMEA just kick-started the process. Vasco started a big crowd funding campaign between theirs supports to raise money to buy the land and all the material to build the stadium. The campaign was a success raising what it would be close to R$300.000.000 if we convert it into today's rate.<br>
                                        Similarly, Vasco da Gama was able to raise in 2020, and during the pandemic, R$5.300.000 for the construction of their new Training Centre.
                                        </p>
                                    <div class="centered">
                                        <img class="responsive-img materialboxed" style="margin-bottom: 5px" src="/img/Estadio-Sao-Januario-old.jpg" alt="Sao Januario Construction" id="estadio" data-caption="Sao Januario Construction">
                                        <img class="responsive-img materialboxed"  src="/img/sao_januario-today.jpg" alt="Sao Januario nowadays" id="estadio" data-caption="Sao Januario nowadays">
                                    </div>
                                    <?php
                                        include('top.php')
                                    ?>
                                </span>
                            </div>
                        </div>
                    
                    
                    <!--Section 3-->  
                    <div class="divider"></div>
                        <div class="section"> 
                            <div class="card-panel">
                                <span>
                                <h2 id="section3">The First Decades of International Success</h2>
            
                                    <h3>First South American Champion in 1948</h3>
                                    <p>In 1948, Vasco da Gama won the first ever South American football competition. This competition was a model in terms of continental club competition to what we know today as Copa Libertadores and Champions League. It was also the first international trophy from a Brazilian club outside the country.<br>
                                        It was a very tough competition with the strongest teams from South America. Vasco's team became known as the Victory Express, “Expresso da Vitória”, like a train, and this squad was the base of Brazil's national team for the 1950's FIFA World Cup.<br>
                                        Vasco da Gama won the tournament by drawing the last game against River Plate. The Argentinians were considered favourites as they had won 5 consecutive national titles and they also had a young player in the command of the attack: nothing less than Alfredo Di Stefano.<br>
                                        We can see below the matches played by Vasco in the tournament:<br>
                                        </p>
                                        
                                        <div class="games-list">
                                            <ol>
                                                <blockquote> 
                                                        <li>Vasco da Gama 2 x 1 Litoral-BOL</li>
                                                        <li>Vasco da Gama 4 x 1 Nacional-URU</li>
                                                        <li>Vasco da Gama 4 x 0 Municipal-PER</li>
                                                        <li>Vasco da Gama 1 x 0 Emelec-ECU</li>
                                                        <li>Vasco da Gama 1 x 1 Colo Colo-CHI</li>
                                                        <li>Vasco da Gama 0 x 0 River Plate-ARG</li>
                                                </blockquote>
                                            </ol>
                                        </div>
            
                                    <h3>1950 FIFA World Cup</h3>
                                        <p>In 1950, Brazil hoped to win its first World Cup which was to be played in the country. Vasco da Gama was well represented starting by Manager Flávio Costa. A further 5 Vasco da Gama players were amongst the starting eleven: Barbosa, Augusto, Danilo, Chico e Ademir.<br>
                                            However, on 16th of July in that year, Uruguay was crowned champion. A deafening silence came over the stadium in what we call today the “Maracanazo”. Later, a player from Vasco da Gama was targeted as the culprit for this failure: The goalkeeper Barbosa. Having made a mistake on the first Uruguayan goal, (which I personally don't think it was), and mainly because of his skin colour, Barbosa was seen by people and critics as the main factor for Brazil to lose this game.<br>
                                            </p>
                                        <video class="responsive-video" src="/video/1950 WORLD CUP FINAL MATCH Uruguay 2-1 Brazil.mp4" width="1024" height="576" controls poster="/img/videobanner1280x720.png">Video not supported</video>
            
                                    <h3>International Success</h3>
                                        <p>Vasco da Gama won undefeated in 1953 the Octagonal Tournament Rivadavia Corrêa Meyer. This tournament substituted the Copa Rio, and it was an international competition organized by the CDB (Brazilian Sports Confederation) authorized by FIFA. Participated in the tournaments Carioca teams (Vasco da Gama, Botafogo, Fluminense), teams from Sao Paulo (Corinthians and Sao Paulo), and international teams (Hibernian-SCO, Olimpia-PAR and Sporting-POR).<br>
                                            A few years later, Vasco da Gama also won the Tournament of Paris in 1957 winning against Racing de Paris and Real Madrid in the final.
                                            </p>
                                    <?php
                                        include('top.php')
                                    ?>
                                </span>
                            </div>
                        </div>
                    
                    
                    <!--Section 4-->
                    <div class="divider"></div>
                        <div class="section"> 
                            <div class="card-panel">
                                <span>
                                <h2 id="section4">Brazil National Champions</h2>
            
                                    <h3>Brazilian National Champion of 1974 with Roberto Dinamite, 1989, 1997, 2000</h3>
                                        <p>In the 70's, Vasco da Gama's best ever player started to come into the scene. His name is Roberto Dinamite. In 1974, finally, the club won its first National title with Roberto Dinamite as leading goalscorer with 16 goals.<br>
                                            No less important, in 1985, one of the greatest players of history arose from the youth into the adult's team and made its debut. Late in that year, Vasco da Gama's attack was formed by no less than Roberto Dinamite and Romario! Yes, the “baixinho”, (the little guy), as we know him in Brazil started his career in Vasco.<br>
                                            In 1989, after a bad start of the year in the Campeonato Carioca, Vasco signed up many players at top level. A signing that stood out was the one of Bebeto, coming from Vasco's rivals Flamengo. Along with other players from youth categories like Bismark and Sorato, Vasco conquered its 2nd National Title winning by 1x0 against Sao Paulo at the Morumbi Stadium.<br>
                                            The 90's was the best decade ever for Vasco da Gama. Various club idols, most of which came from Vasco youth teams, became known nationally. For example: Edmundo, Felipe, Pedrinho, Carlos Germano, Valdir Bigode and Juninho Pernambucano. In 1997, with most of these players, Vasco won his third National title with Edmundo hitting an incredible mark of 29 goals in the tournament.<br>
                                            In 2000. Vasco da Gama the 4th title. This time the Campeonato Brasileiro was a little different. It reunited the whole Division, from top to lower divisions with a total of 116 teams into 4 big modules, progressing into the knockout stage. The lower division teams had the opportunity as well to participate in the Final 16 depending on where they finished in their modules. Funny enough, the final was played by Vasco da Gama from the blue module (best ranked teams) and the surprise of the tournament, Sao Caetano from the yellow module (second level ranked team). In fact, it was so confusing that the tournament only ended in the following year, 2001. The motive was though, an accident that happened in Sao Januario stadium. After drawing 1x1 the first game in Sao Paulo, the game in Rio was interrupted in the 23rd minute when a wired fence broke by the force of Vasco supporters in the stand pushing against it. People fell from the stands and 168 were injured and 3 have had serious injuries. The game was postponed until the 18th of January 2001 at Maracana where Vasco was crowned champion for the 4th time.<br> 
                                            </p>
                                        <video class="responsive-video" src="/video/Gol de Roberto Dinamite - Vasco 2 x 1 Botafogo - 1976.mp4" width="576" height="432" controls poster="/img/videobanner960x720.png">Video not supported</video><br>
                                        <video class="responsive-video" src="/video/Sorato_1989.mp4" width="576" height="432" controls poster="/img/videobanner960x720.png">Video not supported</video><br>
                                        <video class="responsive-video" src="/video/Edmundo_dancinha.mp4" width="576" height="432" controls poster="/img/videobanner960x720.png">Video not supported</video><br>
                                        <video class="responsive-video" src="/video/Brasileirao_2000.mp4" width="576" height="432" controls poster="/img/videobanner960x720.png">Video not supported</video><br>
                                    <?php
                                        include('top.php')
                                    ?>
                                </span>
                            </div>
                        </div>
                    
                    
                    <!--Section 5-->
                    <div class="divider"></div>
                        <div class="section"> 
                            <div class="card-panel">
                                <span>
                                <h2 id="section5">The Best Years</h2>
        
                                <h3>1998 Copa Libertadores</h3>
                                    <p>The year of 1998 was a great success. Not only because it was the year that Vasco became centenary but also because Vasco da Gama won the first, and only, Copa Libertadores.</p>
        
                                        <div class="games-list">
                                            <ol><b><i>Group Stage:</i></b><br>
                                                <br>
                                                <blockquote>
                                                    <li>Grêmio 1x0 Vasco da Gama</li>
                                                    <li>Chivas Guadalajara-MEX 1x0 Vasco da Gama</li>
                                                    <li>América-MEX 1x1 Vasco da Gama</li>
                                                    <li>Vasco da Gama 3x0 Grêmio</li>
                                                    <li>Vasco da Gama 2x0 Guadalajara-MEX</li>
                                                    <li>Vasco da Gama 1x1 América-MEX</li>
                                                </blockquote>
                                            </ol>
        
                                            <ol><b><i>Knockout Stage:</i></b><br>
                                                <br>
                                                <blockquote>
                                                    <li>Round of 16: Vasco da Gama 2 x 1 Cruzeiro</li>
                                                    <li>Round of 16: Cruzeiro 0 x 0 Vasco da Gama</li>
                                                    <li>Quarterfinal: Grêmio 1 x 1 Vasco da Gama</li>
                                                    <li>Quarterfinal: Vasco da Gama 1 x 0 Grêmio</li>
                                                    <li> <a href="/monumental.php">Semifinal: River Plate 1 x 1 Vasco da Gama<br> (click to watch the "Monumental" goal by Juninho Pernambucano)</a></li>
                                                    <li>Semifinal: Vasco da Gama 1 x 0 River Plate</li>
                                                    <li>Final: Vasco da Gama 2 x 0 Barcelona-ECU</li>
                                                    <li>Final: Barcelona-ECU 1 x 2 Vasco da Gama</li>
                                                </blockquote>
                                            </ol>
                                        </div><br>
        
                                        <div class="centered">
                                            <img class="responsive-img materialboxed" src="/img/time_libertadores_1998.jpg" alt="Libertadores 1998 Squad" data-caption="Libertadores 1998 Squad">
                                        </div>
        
                                <h3>Vice Champion of Intercontinental Cup in 1998 and 1st FIFA World Club Cup in 2000</h3>
                                    <p>With all that success in the late 1990's, Vasco da Gama was hoping to go for the big one: the Club's World Cup. Unfortunately, Vasco “hit the post” twice.<br>
                                        In 1998, after winning the Copa Libertadores, Vasco went on to play the Intercontinental Cup. Desired by many, the cup was played in Japan between Copa Libertadores and UEFA Champions League winners. In that occasion Vasco played really well but lost against Real Madrid by 2x1.<br>
                                        The second chance came with FIFA's 1st ever Clubs World Cup where Vasco participated as champions of Libertadores of 1998. Another Brazilian team participated as National champions from 1999 as the tournaments we to be played in Brazil. Vasco da Gama had a great tournament, including a very good victory against Manchester United by 3x1. In the final, after a 0x0 in regular time, Vasco lost on penalties after a miss by Edmundo.
                                        </p>
        
                                <h3 id="section5-3">Copa Mercosul of 2000 and the historic comeback against Palmeiras in the final</h3>
                                    <p>In 2000 still, Vasco had one of the greatest comebacks of all times. In final of 2000 Copa Mercosul (something closer to UEFA Cup), Vasco conceded 3 goals in the first half. The team was very much beaten apparently. However, in the second half Vasco scored also 3 goals drawing the game and on the 93' minute, him, the one and only, Romario scored the 4th goal in the Parque Antartica stadium winning Vasco da Gama another international tittle.<br>
                                        Romario was one of the greatest goal scorers of all times and in 2007 he reached his 1000th goal playing for Vasco da Gama in Sao Januario. What a great way to reach that mark!<br></p>
                                        <div class="card-center">
                                            <div class="row">
                                                <div class="col s12">
                                                    <div class="card">
                                                        <div class="card-image">
                                                            <img class="responsive-img" src="/img/mercosul_2000.jpg" alt="Mercosul 2000">
                                                            <span class="card-title"></span>
                                                        </div>
                                                        <div class="card-content">
                                                            <p>Check here the Mercosul 2000 page to watch a video of this historic come back.</p>
                                                        </div>
                                                        <div class="card-action">
                                                            <a href="/mercosul2000.php" style="color: var(--myred)">Watch it</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                                                        
                                            <div class="row">
                                                <div class="col s12">
                                                    <div class="card">
                                                        <div class="card-image">
                                                            <img class="responsive-img" src="/img/romario_1000th.jpg" alt="Romario 1000">
                                                            <span class="card-title"></span>
                                                        </div>
                                                        <div class="card-content">
                                                            <p>Check here the Romario 1000 page to watch a video of Romario's 1000th goal.</p>
                                                        </div>
                                                        <div class="card-action">
                                                            <a href="/romario1000.php" style="color: var(--myred)">Watch it</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <br>
                                <?php
                                    include('top.php')
                                ?>
                            </span>
                        </div>
                        </div>
                    
                    
                    <!--Section 6-->
                    <div class="divider"></div>
                        <div class="section">
                            <div class="card-panel">
                                <span>
                                <h2 id="section6">The Worst Years and a Breather in the Early 2010's</h2>
        
                                <h3>First Relegation in 2008</h3>
                                    <p>In contrast, 2008 was probably one of the worst years of the Club. The president was Vasco da Gama's best ever player Roberto Dinamite but this time he wasn't able to bring joy to Vasco's supporters. The football team was not that weak as even Edmundo was in command of the attack. However, things just didn't work out. Club politics also affected the football department as Dinamite only took over in mid-season. Also, many managerial changes during the season didn't make an effect as well. The season ended with Vasco in 18th position, inside the relegation zone, with 11 wins, 7 draws and 20 loses as well as 72 goals conceded against 56 goals for.<br>
                                        Vasco was also relegated in 2013, 2015 and 2020. In 2021, Vasco did not reach promotion to Serie A and finishing 10th in the tournament, the worst ever position for Vasco da Gama at the National competition.
                                        </p>
                                    <div class="centered">
                                        <img class="responsive-img materialboxed" style="margin-bottom: 5px" src="/img/rebaixamento_1.jpg" alt="Relegation photo1" style="margin-right: 5px" data-caption="Pedrinho, current President, relegated in 2008">
                                        <img class="responsive-img materialboxed" src="/img/rebaixamento_2.jpg" alt="Relegation photo2" data-caption="Edmundo, Vasco da Gama's idol, relegated in 2008">
                                    </div>
                        
        
                                <h3>2011 Copa do Brasil Winner and Vice Champion in the Brasileirão</h3>
                                    <p>In the last 20 year, not everything was sad. We had some, but brief years of happiness. In 2011, Vasco da Gama its first Copa do Brasil. The first game of the final against Coritiba was in Sao Januario where Vasco won by 1x0. The second game was played in the Couto Pereira stadium where Coritiba won by 3x2 and Vasco lifted the trophy by away goals difference. In the same year Vasco was vice champion of Campeonato Brasileiro and surely could have won if it wasn't for the many referee mistakes all along the competition.</p>
                                    <img class="responsive-img materialboxed" src="/img/copa_do_brasil_2011.jpg" alt="Copa do Brasil 2011" width="100%" data-caption="Copa do Brasil 2011 Squad">
        
                                <h3>2012 Copa Libertadores great miss chance</h3>
                                    <p>Vasco da Gama was playing a very beautiful football in those 2 years under the presidency of Roberto dynamite. However, reaching the quarter final of Libertadores, played against a really tough opponent, Corinthians. All Vasco fans are still disappointed until today on the chance missed by Diego Souza. This attempt could have seen Vasco through, but the goalkeeper Cassio put a nail on that ball. If only he was a littler shorter…<br>
                                        If Vasco went through, history would be totally different as Corinthians went on to win the Copa Libertadores that year and also won the FIFA Club World cup against Chelsea.
                                        </p>
                                    <div class="centered">
                                        <img class="responsive-img materialboxed" src="/img/diego_souza_missed_chance.png" alt="Diego Souza missed chance" data-caption="Diego Souza missed chance">
                                    </div>
                                <?php
                                    include('top.php')
                                ?>
                            </span>
                        </div>
                        </div>
                    
                    
                    <!--Section 7-->
                    <div class="divider"></div>
                        <div class="section"> 
                            <div class="card-panel">
                                <span>
                                <h2 id="section7">The Present and the Future</h2>
        
                                <h3>Masse association of 2019</h3>
                                    <p>In all this financial crisis, Vasco supporters showed again how powerful they are and proved that they are the force that move Vasco da Gama. In the end of 2019, seeing its rivals winning Campeonato Brasileiro and Libertadores, Vasco fans wished they could do something to help the club financially. Many youtubers and influencers lead the campaign of the masse association. This was also helped, according to president at the time Alexandre Campello, by a reformed membership system with new IT technology to allow better interaction with members and a new membership plan and a very good discount rate favouring new members to sign up. Vasco went from 30.000 members to more than 186.000 in a little more than a month reaching top place in Brazil and top 5 in the World. This only shows how Vasco fans carry this club on their shoulders.</p>
                                    <div class="centered">
                                        <img class="responsive-img materialboxed" src="/img/socio_gigante.jpg" alt="Masse association" data-caption="'Socio Gigante' members reaching 100.000 members">
                                    </div>
        
                                <h3>Selling of Vasco da Gama football</h3>
                                    <p>In early 2020's, Vasco was still suffering with confiscation because of debts with players, managers and also taxes to be paid. This was somewhat suffocating the club who suffered to pay everyone and to invest in the club. In fact, it was so difficult to pay even low-level employees or water bills that all investment in new players was becoming secondary.<br>
                                    Newly elected president Jorge Salgado decided to take part in the new legislation of Brazil for football called SAF (Sociedade Anônima do Football - Société Anonyme for Football). It is an SA for football which was approved by Vasco da Gama's Board of Counsellors on 27th of July 2022. A few days later, it was due to all other Vasco da Gama's associates to give the final approval and on 7th of August 2022, with more than 79% of the votes, Vasco da Gama finalised the selling of 70% of football assets to the American group 777 partners for the sum of R$ 700M. This would finally help the whole club to invest and make Vasco da Gama big and strong again.
                                        </p>
                                    <div class="centered">
                                        <img class="responsive-img materialboxed" src="/img/777-Vasco.jpg" alt="777 Partners and Jorge Salgado" data-caption="777 Partners directors and Jorge Salgado">
                                    </div>
                                <?php
                                    include('top.php')
                                ?>
                            </span>
                        </div>
                        </div>
                    
                    
                    <!--Section 8-->
                    <div class="divider"></div>
                        <div class="section"> 
                            <div class="card-panel">
                                <span>
                                <ul class="useful">
                                <h2 id="section8">Useful links</h2>
                                    <!--add Vasco da Gama S.a.f. - official website-->
                                    <li>
                                        <a target="_blank", href="https://www.vasco.com.br">Vasco da Gama S.a.f. - official website</a>
                                    </li>
                                    <!--add CR Vasco da Gama' website-->
                                    <li>
                                        <a target="_blank", href="https://crvascodagama.com/">CR Vasco da Gama - club of associates website</a>
                                    </li>
                                    <!--add Member's website(sociogigante.com)-->
                                    <li>
                                        <a target="_blank", href="https://www.sociogigante.com">Members website: Sócio Gigante</a>
                                    </li>
                                    <!--add Wikipedia link-->
                                    <li>
                                        <a target="_blank", href="https://en.wikipedia.org/wiki/CR_Vasco_da_Gama">CR Vasco da Gama - Wikipedia</a>
                                    </li>
                                    <!--add Brasileirão Serie A - 2025 Season-->
                                    <li>
                                        <a target="_blank", href="https://ge.globo.com/futebol/brasileirao-serie-a/">Brasileirão Serie A - 2025 Season</a>
                                    </li>
                                    <!--add Carioca 2025-->
                                    <li>
                                        <a target="_blank", href="https://ge.globo.com/rj/futebol/campeonato-carioca/">Carioca Championship 2025</a>
                                    </li>
                                    <!--add Squad-->
                                    <li>
                                        <a href="/squad.php">Current Squad</a>
                                    </li>
                            </ul>
        
                            <div class="useful">
                                <?php
                                    include('top.php')
                                ?>
                            </div>
                        
                            </span>
                        </div>
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
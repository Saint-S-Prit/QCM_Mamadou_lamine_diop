<?php
session_start();
if (!isset($_SESSION['joueur']))
{
    header('Location:/quizz');
}
include_once('src/functions.php');

if (!isset($_SESSION['QR']))
{
   $_SESSION['QR']=[];
}
?>

<div id="player">
    <div class="player-header">
        <div class="player-image">
            <img src="asset/images_joueurs/<?php echo $_SESSION['joueur']['avatar']?>">
            <span class="name-player"><?php echo $_SESSION['joueur']['prenom']?></span>
        </div>
        <div class="player-header-text">
            bienvenue sur la plateforme de jeu de quizz <br>
            jouer et tester votre niveau de culture général
        </div>
        <div class="player-logout">
            <button><a href="layout/_logout.php">Déconnexion</a></button>
        </div>
    </div>

    <!--  fin de l'entête de la page joueur -->

    <!----------------------------- Main joueur  --------------------------->

    <div class="player-main">
        <div class="player-main-left">

                    <span class="header_nom_joueur">
                       <marquee behavior="" direction=""><span class="lamp"><img src='asset/Images/Icones/lamp.png'></span><span class="bravo">Bravo </span><span class="nomjoueur"><?php echo $_SESSION['joueur']['prenom']." ".$_SESSION['joueur']['nom']?></span></marquee>
                    </span>
                    <p class="text_terminer">
                        Vous vennez de terminer cette partie
                    </p>
                        <div class="listes">
                            <table>
                                <tr>
                                    <th class="titre">Questions</th>
                                    <th class="titre">Responses</th>
                                </tr>
                                <?php
                                    for ($i=0; $i < count($_SESSION['QR']); $i++)
                                    {
                                        foreach ( $_SESSION['QR'][$i]['Q'] as $question)
                                        {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                            echo $question
                                                        ?>
                                                    </td>
                                                    <td class="col">
                                                        <?php
                                                            echo "<p class='reps'>";
                                                            foreach ($_SESSION['QR'][$i]['R'] as $reponse)
                                                            {
                                                                echo "<span class='rep'>".$reponse."<br/></span>";
                                                            }
                                                            echo "</p>";
                                                            echo "<p class='verifs'>";
                                                            foreach ($_SESSION['QR'][$i]['verif'] as $verif)
                                                                {
                                                                    if ($verif == 1) {
                                                                        echo "<span class='verif'><img src='asset/Images/Icones/false.png'></span>";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<span class='verif'><img src='asset/Images/Icones/true.png'></span>";
                                                                    }
                                                                }
                                                            echo "<p/>";

                                                        ?>
                                                    </td>

                                                </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </table>
                        

                        <?php

                            if (!empty($_SESSION['score']))
                            {
                                if ($_SESSION['score'] > $_SESSION['joueur']['score'])
                                {

                                    ?>
                                        <span class="felicitation">
                                            <span class="image-felecitation">
                                                <img src="" alt="">
                                                <span class="waaw">WaaaW  félicitation!</span><span class="image-emotion"><img src='asset/Images/Icones/smile.png'></span>
                                            </span>
                                            <br>
                                            <?php
                                                $donnees = file_get_contents('asset/json/donnees.json');
                                                $donnees = json_decode($donnees,true);
                                                foreach ($donnees as $key => $donne) {
                                                    if ($donne['login'] === $_SESSION['joueur']['login'])
                                                    {
                                                        $donnees[$key]['score'] = strval($_SESSION['score']);
                                                    }
                                                }
                                                $donnees = json_encode($donnees);
                                                file_put_contents('asset/json/donnees.json', $donnees);
                                            ?>
                                            <span class=last>Votre nouveau score est <span class="scorefinal"><?php echo $_SESSION['score']." pts"?></span> </span>
                                        </span>
                                    <?php

                                }
                                elseif ($_SESSION['score'] < $_SESSION['joueur']['score'])
                                {
                                    ?>
                                        <span class="felicitation">
                                            <span class="image-felecitation">
                                                <img src="" alt="">
                                                <span class="oups">Oups!</span><span class="image-emotion"><img src='asset/Images/Icones/triste.png'></span>
                                            </span>
                                            <span class="last">
                                                tu as regressé de <?php echo $_SESSION['joueur']['score']-$_SESSION['score']." points sur ton score"?>
                                            </span>
                                            <span class=last>Votre score reste <span class="scorefinal"><?php echo $_SESSION['joueur']['score']." pts"?></span> </span>
                                        </span>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                        <span class="felicitation">
                                            <span class="image-felecitation">
                                                <span class="oups">Oups!</span><span class="image-emotion"><img src='asset/Images/Icones/triste.png'></span><span class=last>Votre score  reste le même <span class="scorefinal"><?php echo $_SESSION['joueur']['score']." pts"?></span></span>
                                            </span>
                                        </span>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                        <span class="felicitation">
                                            <span class="image-felecitation">
                                                <img src="" alt="">
                                                <span class="hum">Hum!</span><span class="image-emotion"><img src='asset/Images/Icones/simple.png'> </span>  <span class=last>Vous n'est pas en forme !</span>
                                            </span>
                                        </span>
                                    <?php
                            }
                        ?>
                        </div>
                </div>
        <!---------------------------------------joueurs meuilleurs Scores  ----------------------------------------------->

<!-- recupération des scores -->
<?php
    $donnees = file_get_contents('asset/json/donnees.json');
    $donnees = json_decode($donnees,true);
    $joueurs = [];
    for ($i=0; $i < count($donnees) ; $i++)
    {
        if ($donnees[$i]['admin'] == 0)
        {
            $joueurs[] =$donnees[$i];
        }
    }
    $joueur = array_column($joueurs,'score');
    array_multisort($joueur, SORT_DESC,$joueurs);
?>
            <div class="player-main-right">
                <!-- entête top score -->
                <div class="player-scores">
                    <div class="meilleur_score">
                        <a href="?score=1">Top score</a>
                    </div>
                    <div class="my_score">
                        <a href="?score=2">Mon meilleur score</a>
                    </div>
                </div>
                <!--------corps top score  -->
                    <div class="main_score">

                    <?php
                        if(isset($_GET['score']))
                        {

                            $score = $_GET['score'];

                            switch ($score) 
                            {
                                case'1':
                                    ?>
                                        <table>
                                            <tr>
                                                <?php
                                                    echo '<tr>';
                                                    echo '<td class="prenom_joueur">'.$_SESSION['joueur']['prenom'].'</td>';
                                                    echo '<td class="score_joueur score1">'.$_SESSION['joueur']['score'].'pts</td>';
                                                    echo '</tr>';
                                                ?>
                                            </tr>
                                        </table>
                                    <?php
                                    break;
                                    default:
                                    ?>
                                    <table>
                                        <tr>
                                            <?php
                                                echo '<tr>';
                                                echo '<td class="prenom_joueur">'.$joueurs[1]['prenom'].'</td>';
                                                echo '<td class="score_joueur score1">'.$joueurs[1]['score'].'pts</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                echo '<td class="prenom_joueur">'.$joueurs[2]['prenom'].'</td>';
                                                echo '<td class="score_joueur score2">'.$joueurs[2]['score'].'pts</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                echo '<td class="prenom_joueur">'.$joueurs[3]['prenom'].'</td>';
                                                echo '<td class="score_joueur score3">'.$joueurs[3]['score'].'pts</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                echo '<td class="prenom_joueur">'.$joueurs[4]['prenom'].'</td>';
                                                echo '<td class="score_joueur score4">'.$joueurs[4]['score'].'pts</td>';
                                                echo '</tr>';
                                                echo '<tr>';
                                                echo '<td class="prenom_joueur">'.$joueurs[5]['prenom'].'</td>';
                                                echo '<td class="score_joueur score5">'.$joueurs[5]['score'].'pts</td>';
                                                echo '</tr>';
                                            ?>
                                        </tr>
                                    </table>
                                <?php
                                break;
                            }
                        }
                        else
                        {
                            ?>
                            <table>
                                <tr>
                                    <?php
                                        echo '<tr>';
                                        echo '<td class="prenom_joueur">'.$joueurs[1]['prenom'].'</td>';
                                        echo '<td class="score_joueur score1">'.$joueurs[1]['score'].'pts</td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td class="prenom_joueur">'.$joueurs[2]['prenom'].'</td>';
                                        echo '<td class="score_joueur score2">'.$joueurs[2]['score'].'pts</td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td class="prenom_joueur">'.$joueurs[3]['prenom'].'</td>';
                                        echo '<td class="score_joueur score3">'.$joueurs[3]['score'].'pts</td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td class="prenom_joueur">'.$joueurs[4]['prenom'].'</td>';
                                        echo '<td class="score_joueur score4">'.$joueurs[4]['score'].'pts</td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td class="prenom_joueur">'.$joueurs[5]['prenom'].'</td>';
                                        echo '<td class="score_joueur score5">'.$joueurs[5]['score'].'pts</td>';
                                        echo '</tr>';
                                    ?>
                                </tr>
                            </table>
                        <?php
                        }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>


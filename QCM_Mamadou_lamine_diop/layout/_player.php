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
            <span class="nom_joueur"><?php echo $_SESSION['joueur']['prenom']?></span>
        </div>
        <div class="player-header-text">
            bienvenue sur la plateforme de jeu de quizz <br>
            jouer et tester votre niveau de culture général
        </div>
        <div class="player-logout">
            <button><a href="layout/_logout.php">Déconnexion</a></button>
        </div>
    </div>
<?php



// recuperation de la liste des questions générer de façon aleatoire dans les fichiers play.json
$play = file_get_contents('asset/json/play.json');
$play = json_decode($play,true);

//chercher les questions du fischier play.json dans le fichier questionnaires.json
 $questionnaires = file_get_contents('asset/json/questionnaires.json');
 $questionnaires = json_decode($questionnaires,true);

        foreach ($play as $val)
        {
           if (isset($val)) {
                if (isset($questionnaires[$val]))
                {
                    $jeux[] = $questionnaires[$val];
                }
           }
        }
        $_SESSION['jeux'] = $jeux;

        if (isset($_GET['page']) && $_GET['page'] >0)
        {
            $page = intval($_GET['page']);
        }
        else
        {
            $page= 1;
        }
        $jeu = question_perPage($jeux,$page);




// traitement du formulaire par page avec le bonton suivant
       if (isset($_POST['submit']))
        {
            $trues=[];
            for ($i=0; $i < count($jeu['reponses']) ; $i++)
            {
                if (isset($jeu['reponses'][$i]))
                {
                    if ($jeu['reponses'][$i]['statut'] !== "true")
                    {
						$fals[]= $jeu['reponses'][$i]['reponse'];
                    }
                    else
                    {
                        $trues[]= $jeu['reponses'][$i]['reponse'];
                    }
                }
            }

            $verif = [];
            $QR['Q'][] =$jeu['questionnaire']['question'];
            if (empty($_POST['reponse']))
            {
                $verif[]=1;
                $QR['verif'][]=1;
                $QR['R'][]="non";
            }
            else
            {
                for ($i=0; $i < count($_POST['reponse']); $i++)
                {
                    $QR['R'][]=$_POST['reponse'][$i];
                    if (isset($_POST['reponse'][$i]))
                    {
                       if (isset($trues[$i])) {
                            if ($_POST['reponse'][$i] !== $trues[$i])
                            {
                                $verif[]=1;
                                $QR['verif'][]=1;
                            }
                            else
                            {
                                $verif[]=0;
                                $QR['verif'][]=0;
                            }
                       }
                    }
                }
                $_SESSION['QR'][]=$QR;
            }


        //actualiser le score
            if (!in_array(1,$verif))
            {
                $_SESSION['score'] = $_SESSION['score'] + $jeu['questionnaire']['point'];
            }

            header('location:player.php?page='.($page+1).'');
        }

// traitement du formulaire avec le bonton terminer
        if (isset($_POST['terminer']))
        {
            $trues=[];
            for ($i=0; $i < count($jeu['reponses']) ; $i++)
            {
                if (isset($jeu['reponses'][$i]))
                {
                    if ($jeu['reponses'][$i]['statut'] !== "true")
                    {
						$fals[]= $jeu['reponses'][$i]['reponse'];
                    }
                    else
                    {
                        $trues[]= $jeu['reponses'][$i]['reponse'];
                    }
                }
            }

            $verif = [];
            $QR['Q'][] =$jeu['questionnaire']['question'];
            if (empty($_POST['reponse']))
            {
                $verif[]=1;
                $QR['verif'][]=1;
                $QR['R'][]="non";
            }
            else
            {
                for ($i=0; $i < count($_POST['reponse']); $i++)
                {
                    $QR['R'][]=$_POST['reponse'][$i];
                    if (isset($_POST['reponse'][$i]))
                    {
                       if (isset($trues[$i])) {
                            if ($_POST['reponse'][$i] !== $trues[$i])
                            {
                                $verif[]=1;
                                $QR['verif'][]=1;
                            }
                            else
                            {
                                $verif[]=0;
                                $QR['verif'][]=0;
                            }
                       }
                    }
                }
                $_SESSION['QR'][]=$QR;
            }

//actualiser le score
            if (!in_array(1,$verif))
            {
                $_SESSION['score'] = $_SESSION['score'] + $jeu['questionnaire']['point'];
            }

            header('location:terminus.php');
        }
       ?>






    <div class="player-main">
        <div class="player-main-left">
            <div class="main-left-header">
                <span class="questionNumber">
                    Question <?= $page?>/<?= count($jeux)?>
                </span>
                <span class="question">
                    <?= $jeu['questionnaire']['question']?>
                </span>
            </div>

            <div class="main-left-score">
                <?= $jeu['questionnaire']['point'] ?> pts
            </div>

            <div class="main-left-contain">
                <form method="post" class="form-player">
                        <?php
                            for ($i=0; $i < count($jeu['reponses']); $i++)
                            {
                                if (isset($jeu['reponses'][$i]))
                                {
                                    $rep =$jeu['questionnaire']['rep'];
                                    if ($rep == "radio")
                                    {
                                        ?>
                                            <div class="<?php echo $rep?>"><input name="reponse[]" value="<?=$jeu['reponses'][$i]['reponse']?>" type="<?php echo $rep?>"><?= ucfirst($jeu['reponses'][$i]['reponse']) ?></div>
                                        <?php
                                    }
                                    elseif
                                    ($rep == "checkbox")
                                    {
                                        ?>
                                            <div class="<?php echo $rep?>"><input name="reponse[]" value="<?= $jeu['reponses'][$i]['reponse']?>" type="<?php echo $rep?>"><?= ucfirst($jeu['reponses'][$i]['reponse'])?></div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="<?php echo $rep?>"><textarea class="player-textarea" name="reponse[]"></textarea></div>
                                        <?php
                                    }
                                }
                            }
                        ?>

                    </div>
                    <!-- bouton pagination -->
                    <div class="btn">
                    <?php if ($page > 1)
                                    {
                                        ?>
                                        <button class="btn-pre">
                                        <a href="player.php?page=<?= $page -1 ?> ">Précédant</a>
                                        </button>
                                        <?php
                                    }
                                    ?>

                                    <?php if ($page < count($jeux))
                                    {
                                        ?>
                                        <button type="submit" name="submit" class="btn-suiv">Suivant</button>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <button type="submit" name="terminer" class="btn-suiv">Terminer</button>
                                        <?php
                                    }
                                    ?>
                                    <button type="submit" name="terminer" class="btn-leave">Quitter</button>
                    </div>
                </div>
            </form>

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


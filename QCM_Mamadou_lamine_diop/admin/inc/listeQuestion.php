<?php
    if (isset($_POST['submit']))
    {
        $nbrQuestion = $_POST['nbrQuestion'];
        $donnes = file_get_contents('../asset/json/questionnaires.json');
        $donnes = json_decode($donnes,true);



        $tab=[];
        do {
            $random = rand(1,count($donnes));
            if (!in_array($random,$tab)) {
               $tab []=$random;
            }
        } while (count($tab) < $nbrQuestion);

        $quizz =[
            'questionnaire' =>[],
            'reponses' =>[],
        ];



        $play = file_get_contents('../asset/json/play.json');
        $play = json_decode($play,true);
        $play = $tab;
        $play = json_encode($play);
        file_put_contents('../asset/json/play.json',$play);
    }
?>

<div id="listeQuestion">
    <form action="" method="post" id="formNbrPerpage">
        <p class="form-group">
            <label for="">
                Nbre de question/Jeu
            </label>
            <input type="text" name="nbrQuestion" id="nbrQuestion"  value="<?php if(isset($nbrQuestion)){echo $nbrQuestion;}?>">
            <input type="submit" name="submit" value="ok">
        </p>
    </form>
    <span id="erreurNbrQuestion" class="erreur"></span>
    <br>
    <?php
        if (isset($erreur))
        {
            echo $erreur;
        }
    ?>

    <div class="listeQuestion-content">
        <?php
            $questionnaires = file_get_contents('../asset/json/questionnaires.json');
            $questionnaire = json_decode($questionnaires,true);

            for ($i=0; $i < count($questionnaire) ; $i++)
            {
                    if (isset($questionnaire[$i]))
                    {
                    $kestion[] =$questionnaire[$i];
                    }
            }

            if (isset($_GET['page']) && $_GET['page'] >0)
            {
                $page = intval($_GET['page']);
            }
            else
            {
                $page= 1;
            }


            require_once('../src/functions.php');
            $tab = liste_question_perPage($kestion,$page);
        ?>
    </div>
    <div class="btn">
        <?php if ($page > 1): ?>
            <button class="btn-pre">
                <a href="?param=1&page=<?= $page -1 ?>">precedent</a>
            </button>
        <?php endif ;?>

        <button  class="btn-suiv">
            <?php if ($page < 10): ?>
                <a href="?param=1&page=<?= $page + 1 ?> ">suivant</a>
            <?php endif ;?>
        </button>
    </div>
</div>



<script>
    var formNbrPerpage = document.getElementById('formNbrPerpage');
    formNbrPerpage.addEventListener('submit',function(e)
    {
        var nbrQuestion =  document.getElementById('nbrQuestion').value;
        var erreurNbrQuestion =  document.getElementById('erreurNbrQuestion');
        if (nbrQuestion)
        {
            if (!isNaN(nbrQuestion))
            {

                if (nbrQuestion <= 5)
                {
                    erreurNbrQuestion.innerHTML = "être supérieur ou égal à 5 !";
                    e.preventDefault();
                }
            }
            else
            {
                erreurNbrQuestion.innerHTML = "Enter un nombre !";
                e.preventDefault();
            }
        }
        else
        {
            erreurNbrQuestion.innerHTML = "Veuillez saisir un nombre !";
            e.preventDefault();
        }
    });
</script>
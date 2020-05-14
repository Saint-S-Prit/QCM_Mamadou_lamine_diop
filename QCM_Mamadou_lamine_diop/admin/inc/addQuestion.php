
<?php
    if (isset($_POST['question']))

    {

        $quizz =[
            'questionnaire' =>[],
            'reponses' =>[],
        ];

        $quizz['questionnaire']['question'] = $_POST['question'];
        $quizz['questionnaire']['point'] = $_POST['point'];
        $quizz['questionnaire']['choix'] = $_POST['choix'];


        if ($_POST['choix'] == "simple") {
            $quizz['questionnaire']['rep']= "radio";

            for ($i=0; $i <count($_POST['reponse']) && isset($_POST['reponse']) ; $i++)
            {
                if (isset($_POST['reponse'][$i])) {
                    if (isset($_POST['radio'.($i+1).'']) )
                    {
                        $quizz['reponses'][$i]['reponse']=$_POST['reponse'][$i];
                        $quizz['reponses'][$i]['statut']="true";
                    }
                    else
                    {
                     $quizz['reponses'][$i]['reponse']=$_POST['reponse'][$i];
                     $quizz['reponses'][$i]['statut']="false";
                    }
                }
            }
        }
        else if ($_POST['choix'] == "multiple")
        {
            $quizz['questionnaire']['rep'] = "checkbox";
            for ($i=0; $i <count($_POST['reponse']) && isset($_POST['reponse']) ; $i++)
            {
                if (isset($_POST['reponse'][$i])) {
                    if (isset($_POST['checkbox'.($i+1).'']) )
                    {
                        $quizz['reponses'][$i]['reponse']=$_POST['reponse'][$i];
                        $quizz['reponses'][$i]['statut']="true";
                    }
                    else
                    {
                        $quizz['reponses'][$i]['reponse']=$_POST['reponse'][$i];
                        $quizz['reponses'][$i]['statut']="false";
                    }
                }
            }
        }
        else
        {
            $quizz['questionnaire']['rep'] = "textarea";
            $quizz['reponses'][0]['reponse']=$_POST['reponse'];
            $quizz['reponses'][0]['statut']="true";
        }



        $questionnaires = file_get_contents('../asset/json/questionnaires.json');
        $questionnaires = json_decode($questionnaires,true);
        $questionnaires[]=$quizz;
        $questionnaires = json_encode($questionnaires);
        file_put_contents('../asset/json/questionnaires.json',$questionnaires);
    }
?>

<div id="addQuestion">
    <div class="addQuestion-header">
        <span class="addQuestion-header-text">
            paramétrer votre question
        </span>
    </div>

    <div class="addQuestion-content">
        <form  method="post" id="questionnaire" >
                <p>
                    <label for="" class="textarea">
                        Question :
                    </label>
                    <textarea name="question" id="question" ></textarea>
                    <span class="erreur erreurCreatQ" id="erreurQuestion"></span>
                </p>
                <p>
                    <label for="">
                        Nbr de Points :
                    </label>
                    <input type="number" class="point" name="point" id="point" min="0">
                    <span class="erreur erreurCreatQ" id="erreurPoint"></span>
                </p>


                <p>
                    <span class="option">
                    <label for="" class ="labelname">
                        type de reponse :
                    </label>
                    <select name="choix" id="choix" onchange="choisi()">
                        <option>Donnez le type de réponse</option>
                        <option value="multiple">Réponses Multiples</option>
                        <option value="simple">Réponse Simple</option>
                        <option value="saisir">Réponse Texte</option>
                    </select>
                    </span>
                    <button class="addimage" class="addrep" alt="" onclick="Add()">
                        <img src="../asset/Images/Icones/ic-ajout-reponse.png" >
                        <input type="hidden" name="nbr" id="nbr" />
                    </button>
                    <div id="mainn"></div>
                </p>
                <div id="erreur"></div>
                <input type="submit"  value="Enregistre">

        </form>
    </div>
</div>



<script>

var nbr = 1;

function choisi() {
    nbr = 1;
    document.getElementById('mainn').innerHTML = "";
}


function suppdiv(n) {
    alert(n);
}

function Add() {

    document.getElementById('nbr').value = nbr;
    var choix = document.getElementById('choix').value;
    var divmain = document.getElementById('mainn');
    var newInput = document.createElement('div');
    newInput.setAttribute('id','row_'+nbr)
    if (choix === "multiple") {
        newInput.innerHTML = `
        <label for="" class="champs_texte">
            Réponse ${nbr}:
        </label>
        <input type="text" class="champs_text" id="reponse[]" name="reponse[]">
        <input type="checkbox" name="checkbox${nbr}"/>
        <img src="../asset/Images/Icones/ic-supprimer.png" class="delrep" id="nbr" onclick="remove(${nbr})" onclick="Add()">
        `;

    } else if (choix === "simple") {

        newInput.innerHTML = `
        <label for="" class="champs_texte">
            Réponse ${nbr}:
        </label>
        <input type="text" class="champs_text" id="reponse[]" name="reponse[]">
        <input type="radio" name="radio${nbr}" value="${nbr}"/>
        <img src="../asset/Images/Icones/ic-supprimer.png" class="delrep" id="nbr" onclick="remove(${nbr})" onclick="Add()">
        `;
    } else {
        newInput.innerHTML = `
        <textarea name="reponse" id="" cols="70" rows="10"></textarea>
        <img src="../asset/Images/Icones/ic-supprimer.png" class="delrep" id="nbr" onclick="remove(${nbr})" onclick="Add()">
        `;
    }
    divmain.appendChild(newInput);
    nbr++;
}

        function remove(n){
            var target = document.getElementById('row_'+n);
            target.remove();

        }

    var questionnaire = document.getElementById('questionnaire');
    questionnaire.addEventListener('submit',function(e)
    {
        var prenom = document.getElementById('question');
        var point = document.getElementById('point');
        var choix = document.getElementById('choix');
        var reponse = document.getElementById('reponse');

        if (!question.value.trim())
        {
            var erreurQuestion = document.getElementById('erreurQuestion');
            erreurQuestion.innerHTML = "le champs prenom doit être requis";
            e.preventDefault();
        }
        if (!point.value.trim())
        {
            var erreurPoint = document.getElementById('erreurPoint');
            erreurPoint.innerHTML = "donnez le nombre de point";
            e.preventDefault();
        }
        if (!choix.value.trim())
        {
            var erreurChoix = document.getElementById('erreurChoix');
            erreurChoix.innerHTML = "Déterminez le type de reponse";
            e.preventDefault();
        }

    });


    </script>


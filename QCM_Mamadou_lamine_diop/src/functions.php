<?php

function login(string $str)
{
    $val = preg_match('/^[A-Z][a-z]{2,}$/',$str);
    return $val;
}

function limitCar(string $str,$debut, $fin)
{
    $strCar = strlen($str);
    if ($strCar >= $debut  && $strCar <= $fin) {
       return $str;
    }
}

function passwordCarValide(string $mdp)
{
    $val = preg_match('/[A-Z0-9]+/',$mdp);
    return $val;
}


function inscriptionJoueur($prenom,$nom,$login,$password,$avatar)
{
    $users =
    [

        'prenom' =>[],
        'nom' =>[],
        'login' =>[],
        'password' =>[],
        'avatar'=>[],
        'admin'=>[],
        'score'=>[],
    ];
        $users['prenom'] = $prenom;
        $users['nom'] = $nom;
        $users['login'] = $login;
        $users['password'] = $password;
        $users['avatar'] = $avatar;
        $users['admin'] = "0";
        $users['score'] = "0";


        $AdminsJson = file_get_contents('asset/json/donnees.json');

        $AdminsJson = json_decode($AdminsJson,true);

        $AdminsJson[] = $users;

        $AdminsJson = json_encode($AdminsJson);
        file_put_contents('asset/json/donnees.json',$AdminsJson);
}


function inscriptionAdmin($prenom,$nom,$login,$password,$avatar)
{
    $users =
    [

        'prenom' =>[],
        'nom' =>[],
        'login' =>[],
        'password' =>[],
        'avatar'=>[],
        'admin'=>[],
    ];
        $users['prenom'] = $prenom;
        $users['nom'] = $nom;
        $users['login'] = $login;
        $users['password'] = $password;
        $users['avatar'] = $avatar;
        $users['admin'] = "1";


        $AdminsJson = file_get_contents('../asset/json/donnees.json');

        $AdminsJson = json_decode($AdminsJson,true);

        $AdminsJson[] = $users;

        $AdminsJson = json_encode($AdminsJson);
        file_put_contents('../asset/json/donnees.json',$AdminsJson);
}

function connexion()
{
    $donneesJson = file_get_contents('asset/json/donnees.json');

    $donneesJson = json_decode($donneesJson,true);
    return $donneesJson;
}



function tri($tab)
{
    for ($i = 0; $i < count($tab); $i++)
    {
        for ($j = $i+1; $j < count($tab) ; $j++)
        {
            if ($tab[$i] < $tab[$j])
            {
                $svg = $tab[$i];
                $tab[$i] = $tab[$j];
                $tab[$j] = $svg;
            }
        }
    }
    return $tab;
}



function joueurs_perPage($tab,$page)
{
    $perPage=13;
    $count = count($tab);
    $nombreDePages=ceil($count/$perPage);
    $indiceDebut = ($page-1) * $perPage;
    $indiceFin = $indiceDebut + $perPage -1;

    for ($i=$indiceDebut; $i <= $indiceFin ; $i++)
        {
            if (isset($tab[$i]))
            {
                echo '<tr>';
                echo '<td class="nom">'.strtoupper($tab[$i]['nom']).'</td>';
                echo '<td class="prenom">'.$tab[$i]['prenom'].'</td>';
                echo '<td class="score">'.$tab[$i]['score'].' <span class="pts">pts</span></td>';
                echo '</tr>';
            }
        }


}



function liste_question_perPage($tab,$page)
{
    $perPage=5;
    $count = count($tab);
    $nombreDePages=ceil($count/$perPage);
    $indiceDebut = ($page-1) * $perPage;
    $indiceFin = $indiceDebut + $perPage -1;
    for ($i=$indiceDebut; $i <= $indiceFin ; $i++)
        {
            if (isset($tab[$i]))
            {
                $j = $i+1;
                echo "<span class='question'>".$j.".".$tab[$i]['questionnaire']['question']."<br/></span>";

                $choix = $tab[$i]['questionnaire']['choix'];
                if ($choix == "simple" || $choix == "multiple")
                {
                    $reponses = $tab[$i]['reponses'];
                    foreach ($reponses as $reponse)
                    {
                        $rep = $tab[$i]['questionnaire']['rep'];
                        echo "<input class='typeRep' type='$rep' name='reponse'><span class='reponse'><span class='tr'></span>".ucfirst($reponse['reponse'])."<br/></span>";
                    }
                }
                else
                {
                    echo "<textarea cols='30' rows='5'></textarea><br/>";
                }
            }
        }
}

function question_perPage($tab,$page)
{
    $perPage=1;
    $count = count($tab);
    $nombreDePages=ceil($count/$perPage);
    $indiceDebut = ($page-1) * $perPage;
    $indiceFin = $indiceDebut + $perPage -1;

    for ($i=$indiceDebut; $i <= $indiceFin ; $i++)
        {
            if (isset($tab[$i]))
            {
                return $tab[$i];
            }
        }
}






<?php
session_start();
    if (isset($_POST['submit']))
    {
        $login = strip_tags($_POST['login']);
        $password = strip_tags($_POST['password']);

        require_once('src/functions.php');
        $donnees = connexion();

        for ($i=0; $i < count($donnees) ; $i++)
        {
            $bool = false;
            if (isset($donnees[$i]))
            {
                if ($login == $donnees[$i]['login'] && $password == $donnees[$i]['password'])
                {
                    $user = $donnees[$i];
                    $bool = true;
                break;
                }
            }
        }

        if ($bool)
        {
            if ($user['admin'] == 1)
            {
                $_SESSION['admin'] = $user;
                header('Location:admin');
            }
            else if($user['admin'] == 0)
            {
                $_SESSION['joueur'] = $user;
                $_SESSION['scoreInit']=[];
                header('Location:player.php');
            }
        }
        else
        {
            $user = 'Les données entrées ne correspond à aucun compte.<a href="inscription.php">Veuillez créer un compte.?</a>';
        }
    }
?>

<div id="login">
    <div class="login-header">
        <span class="login-header-text">
            Login Form
        </span>
    </div>
    <div class="login-input">
        <form method="post" id="formConnexion">
            <p>
                <input type="text" name="login" id="log">
                <img src="asset/Images/Icones/ic-login.png" alt="">
                    <span class="alert">
                        <span class="erreur" id="erreurLogin"></span>
                    </span>
            </p>
            <p>
                <input type="password" name="password" id="password">
                <img src="asset/Images/Icones/ic-password.png" alt="">
                    <span class="alert">
                        <span class="erreur" id="erreurPassword"></span>
                        <span class="erreur"><?php if (isset($user)) {echo $user;}?></span>
                    </span>
            </p>
            <p>
                <button type="submit" name="submit">Connexion</button>
                <span class="inscrire">
                    <a href="creatPlayer.php">
                        S’inscrire pour jouer?
                    </a>
                </span>
            </p>
        </form>
    </div>
</div>



<!-- vérification de la validité de chaque champs en javaScript -->
<script>
    var formConnexion = document.getElementById('formConnexion');
    formConnexion.addEventListener('submit',function(e){

        var login = document.getElementById('log');
        var password = document.getElementById('password');
        var valide = /^[a-zA-Z-éèê\'\s]+$/;

        if (login.value.trim()) {
            if (valide.test(login.value)== false) 
            {
                var erreurLogin = document.getElementById('erreurLogin');
                erreurLogin.innerHTML = "le login n'est pas valide !";
                e.preventDefault();
            }
            else
            {
                var erreurLogin = document.getElementById('erreurLogin');
                erreurLogin.innerHTML = "";
            }
        }
        else
        {
            var erreurLogin = document.getElementById('erreurLogin');
            erreurLogin.innerHTML = "Le champs Login doit être requis !";
            e.preventDefault();
        }


        if (password.value.trim() == "")
        {
            var erreurPassword = document.getElementById('erreurPassword');
            erreurPassword.innerHTML = "Le champs password doit être requis !";
            erreurPassword.style.color = 'red';
            e.preventDefault();
        }
        else
        {
            var erreurPassword = document.getElementById('erreurPassword');
            erreurPassword.innerHTML = "";
        }
    });
</script>
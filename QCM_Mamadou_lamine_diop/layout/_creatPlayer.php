<?php
    if (isset($_POST['submit']))
    {
        $prenom = strip_tags($_POST['prenom']);
        $nom = strip_tags($_POST['nom']);
        $login = strip_tags($_POST['login']);
        $password = strip_tags($_POST['password']);
        $rpassword = strip_tags($_POST['rpassword']);


        $donnes = file_get_contents('asset/json/donnees.json');
        $donnes = json_decode($donnes,true);

        $bool = false;
        for ($i=0; $i < count($donnes) ; $i++)
        {
            if (isset($donnes[$i]))
            {

                if ($donnes[$i]['login'] == $login)
                {
                    $bool = true;
                break;
                }
            }
        }
        if ($bool) {
             $existe = "le login <span class='loginExit'>".$login."</span> existe déja";
        }
        else
        {

            // importer l'image

            if ($_FILES['avatar']['error'] == 0)
            {

                // taille
                if ($_FILES['avatar']['size'] < 1500000)
                {
                        // test extension
                        $extension = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));

                        if ($extension == 'jpg' || $extension == 'png' )
                        {
                            // Au final
                        if (!isset($error))
                            {
                                $avatar = $_FILES['avatar']['name'];
                                move_uploaded_file($_FILES['avatar']['tmp_name'], "asset/images_joueurs/".$avatar);
                                require_once('src/functions.php');
                                inscriptionJoueur($prenom,$nom,$login,$password,$avatar);
                                $succes = "inscrire avec succés !";
                            }
                        }
                        else
                        {
                        $errors = "votre fichier n'est pas conforme!";
                        }

                }
                else
                {
                    $errors = 'votre fichier est trop lourd';
                }
            }
            else
            {
                $errors = 'probleme formulaire';
            }
        }
    }
?>
<div id="creatPlayer">
<div id="addadmin">
                <div class="addadmin-left">

                    <span class="title">s'inscrire</span>
                    <span class="title2">Pour proposer des quizz</span>
                    <hr>

                        <?php if (isset($existe)) {echo "<p class='loginExite'>" .$existe."</p>";}?>
                        <?php if (isset($succes)) {echo "<p class='succes'>" .$succes."<br/><a href='index.php'>cliquez ici pour vous connecter</a> </p>";}?>

                        <div class="addadmin-formulaire">
                            <form action="" method="post" ENCTYPE="multipart/form-data" id="formInsAdmin">
                                    <label for="">
                                        Prénom
                                    </label>
                                    <input type="text" name="prenom" id="prenom" value="<?php if (isset($prenom)) {echo $prenom ;}?>">
                                    <span class="erreur" id="erreurPrenom"></span>
                                    <label for="">
                                        Nom
                                    </label>
                                    <input type="text" name="nom" id="nom" value="<?php if (isset($nom)) {echo $nom ;}?>">
                                    <span class="erreur" id="erreurNom"></span>
                                    <label for="">
                                        Login
                                    </label>
                                    <input type="text" name="login" id="log" value="<?php if (isset($login)) {echo $login ;}?>" >
                                    <span class="erreur" id="erreurLogin"></span>
                                    <label for="">
                                        Password
                                    </label>
                                    <input type="password" name="password" id="password" >
                                    <span class="erreur" id="erreurPassword"></span>
                                    <span class="erreur" id="identique"></span>
                                    <label for="">
                                        Confirmer Password
                                    </label>
                                    <input type="password" name="rpassword" id="rpassword" >
                                    <span class="erreur" id="erreurRpassword"></span>
                                    <label class="avatar">
                                        Avatar
                                    </label>
                                    <input type="file" class="avatar" name="avatar" onchange="document.getElementById('charcher_img').src = window.URL.createObjectURL(this.files[0])"/>

                                <p class="valide">
                                    <input type="submit" name="submit" value="Créer un compte">
                                </p>
                            </form>
                        </div>
                </div>
                <div class="addadmin-right">
                    <div class="addadmin-image">
                        <img id="charcher_img" alt="">
                    </div>
                            <p id="nomAvatar" class="avatar">
                                Avatar Admin
                            </p>
                            <!-- erreur de l'image -->
                            <?php
                                if (isset($errors)) {
                                    echo "<pan class='erreur'>".$errors."</pan>";
                                }
                            ?>
                </div>
            </div>



            <script>
    var formInsAdmin = document.getElementById('formInsAdmin');
    formInsAdmin.addEventListener('submit',function(e)
    {
        var prenom = document.getElementById('prenom');
        var nom = document.getElementById('nom');
        var login = document.getElementById('log');
        var password = document.getElementById('password');
        var rpassword = document.getElementById('rpassword');
        var file = document.getElementById('file');

        var valide = /^[a-zA-Z\s\']+$/;

// validation du prenom
        if (prenom.value.trim())
        {

            if (valide.test(prenom.value)==true)
            {

                if (prenom.value.length <= 20)
                {
                    var erreurPrenom = document.getElementById('erreurPrenom');
                    erreurPrenom.innerHTML = "";
                }
                else
                {
                    var erreurPrenom = document.getElementById('erreurPrenom');
                    erreurPrenom.innerHTML = "le prenom ne doit pas dépasser 20 caractères";
                    e.preventDefault();
                }

                
            }
            else
            {
                var erreurPrenom = document.getElementById('erreurPrenom');
                erreurPrenom.innerHTML = "le champs prenom doit contenir des lettres et espace seulement";
                e.preventDefault();
            }
            
        }
        else
        {
            var erreurPrenom = document.getElementById('erreurPrenom');
            erreurPrenom.innerHTML = "le champs prenom doit être requis";
            e.preventDefault();
        }


// validation du nom
        if (nom.value.trim())
        {
            if (valide.test(nom.value) == true)
            {
                if (nom.value.length <= 10) {
                    var erreurNom = document.getElementById('erreurNom');
                    erreurNom.innerHTML = "";
                }
                else
                {
                    var erreurNom = document.getElementById('erreurNom');
                    erreurNom.innerHTML = "le nom ne doit pas dépasser 10 caractères";
                    e.preventDefault();
                }
            }
            else
            {
                var erreurNom = document.getElementById('erreurNom');
                erreurNom.innerHTML = "le champs prenom doit contenir des lettres et espace seulement";
                e.preventDefault();
            }
        }
        else
        {
            var erreurNom = document.getElementById('erreurNom');
            erreurNom.innerHTML = "le champs nom doit être requis";
            e.preventDefault();
        }



// validation du login
        if (login.value.trim())
        {
            var validelogin = /^[a-z0-9@éàèê]+$/i;
            if (validelogin.test(login.value == true))
            {
               if (login.value.length <=10)
               {
                var erreurLogin = document.getElementById('erreurLogin');
                erreurLogin.innerHTML = ""; 
               }
               else
               {
                    var erreurLogin = document.getElementById('erreurLogin');
                    erreurLogin.innerHTML = "le nom ne doit pas dépasser 10 caractères";
                    e.preventDefault();
               }
            }
            else
            {
                var erreurLogin = document.getElementById('erreurLogin');
                erreurLogin.innerHTML = "le champs prenom doit contenir des caracteres alphanumériques";
                e.preventDefault();
            }
        }
        else
        {
            var erreurLogin = document.getElementById('erreurLogin');
            erreurLogin.innerHTML = "le champs login doit être requis";
            e.preventDefault();
        }


// validation du password
        if (password.value.trim()) {
            var erreurPassword = document.getElementById('erreurPassword');
            erreurPassword.innerHTML = "";
        }
        else
        {
            var erreurPassword = document.getElementById('erreurPassword');
            erreurPassword.innerHTML = "le champs password doit être requis";
            e.preventDefault();
        }

// validation confirmation password
        if (rpassword.value.trim()) {
            var erreurRpassword = document.getElementById('erreurRpassword');
            erreurRpassword.innerHTML = "";
        }
        else
        {
            var erreurRpassword = document.getElementById('erreurRpassword');
            erreurRpassword.innerHTML = "Confirmer le mot de passe";
            e.preventDefault();
        }


// validation password et password confirmation identiques
        if (password.value == rpassword.value) {
            var identique = document.getElementById('identique');
            identique.innerHTML = "";
        }
        else
        {
            var identique = document.getElementById('identique');
            identique.innerHTML = "les mots de passe ne sont pas identiques !";
            e.preventDefault();
        }

        
    });    
</script>
</div>
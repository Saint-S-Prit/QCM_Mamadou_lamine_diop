<div id="admin">
    <div class="admin-header">
        <div class="admin-header-text">
            créer et paramétrer vos quizz
        </div>
        <div class="admin-header-logout">
            <button><a href="../layout/_logout.php">Déconnexion</a></button>
        </div>
    </div>

    <div class="admin-content">
        <div class="aside">

            <div class="aside-header">
                <span class="aside-left">
                    <span class="image">
                        <img src="images_Admin/<?php echo $_SESSION['admin']['avatar']?>" alt="">
                    </span>
                </span>
                <span class="aside-right">
                    <span class="aside-right-text">
                        <?php echo $_SESSION['admin']['prenom']." ".$_SESSION['admin']['nom']?>
                    </span>
                </span>
            </div>

            <div class="aside-menu">
                <p class="lien">
                    <a href="?param=1">Liste Questions</a>
                    <?php if (!isset($_GET['param']) || $_GET['param']!=1)
                        {echo "<img src='../asset/Images/Icones/ic-liste.png'>";}else{echo "<img src='../asset/Images/Icones/ic-liste-active.png'>";}
                    ?>
                </p>
                <p class="lien">
                <a href="?param=2">créer Admin</a>
                    <?php if (!isset($_GET['param']) || $_GET['param']!=2)
                        {echo "<img src='../asset/Images/Icones/ic-ajout.png'>";}else{echo "<img src='../asset/Images/Icones/ic-ajout-active.png'>";}
                    ?>
                </p>
                <p class="lien">
                    <a href="?param=3">Liste joueurs</a>
                    <?php if (!isset($_GET['param']) || $_GET['param']!=3)
                        {echo "<img src='../asset/Images/Icones/ic-liste.png'>";}else{echo "<img src='../asset/Images/Icones/ic-liste-active.png'>";}
                    ?>
                </p>
                <p class="lien">
                    <a href="?param=4">Créer Questions</a>
                    <?php if (!isset($_GET['param']) || $_GET['param']!=4)
                        {echo "<img src='../asset/Images/Icones/ic-ajout.png'>";}else{echo "<img src='../asset/Images/Icones/ic-ajout-active.png'>";}
                    ?>
                </p>
            </div>
        </div>
        <div class="main">
        <?php
            if (isset($_GET['param'])) {
                $param = intval($_GET['param']);
                switch ($param) {
                    case 1:
                        include_once("inc/listeQuestion.php");
                        break;
                    case 2:
                        include_once("inc/addAdmin.php");
                        break;
                    case 3:
                        include_once("inc/listePlayer.php");
                        break;
                    case 4:
                        include_once("inc/addQuestion.php");
                        break;
                    
                    default:
                        include_once("inc/listeQuestion.php");
                        break;
                }
            }
        ?>







        </div>
    </div>
</div>
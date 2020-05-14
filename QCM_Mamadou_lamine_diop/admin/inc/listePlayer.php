<div id="listePlayer">
    <div class="listePlayer-header">
        liste des joueurs par score
    </div>
    <div class="listePlayer-content">
        <div class="listes">
            <table>
                <tr>
                    <th class="nom">
                        Nom
                    </th>
                    <th class="titre">
                        Prénom
                    </th>
                    <th class="score">
                        Score
                    </th>
                </tr>

                <?php

                        include_once('../src/functions.php');
                        $donnees = file_get_contents('../asset/json/donnees.json');
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


                        if (isset($_GET['page']) && $_GET['page'] >0)
                        {
                            $page = intval($_GET['page']);
                        }
                        else
                        {
                            $page= 1;
                        }
                        joueurs_perPage($joueurs,$page);
                ?>
            </table>
        </div>
    </div>

    <div class="btn">
        <button class="btn-pre">
            <?php if ($page > 1): ?>
                <a href="?param=3&page=<?= $page -1 ?>">Precedent</a>
            <?php endif ;?>
        </button>

        <button class="btn-suiv">
            <?php if ($page < 10): ?>
                <a href="?param=3&page=<?= $page + 1 ?> ">Suivant</a>
            <?php endif ;?>
        </button>
    </div>
</div>
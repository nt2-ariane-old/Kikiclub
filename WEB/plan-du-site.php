<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/PlanDuSiteAction.php");

	$action = new PlanDuSiteAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
<main>
    <div class='sheet'>
        <h2>Plan du Site</h2>
        <p>Bienvenue sur le plan du Kikiclub. Ici vous pourrez-vous retrouvez si vous êtes perdu.</p>

        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li> Les Informations
                    <li><a href="workshops.php">Nos Ateliers</a></li>
                    <li><a href="robots.php">Nos Robots</a></li>
            </li>
            
            <?php
                if($action->isLoggedIn())
                {
                    ?>
            <li> Les Informations Membres
                <ul>
                    <li></li>
                </ul>
            </li>
                    <?
                }
            ?>

            
        </ul>
    </div>
</main>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");
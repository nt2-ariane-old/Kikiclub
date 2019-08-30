<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ReferenceAction.php");

	$action = new ReferenceAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
<div class="sheet">

<?php
if($action->error || $action->success)
{
    ?>
<div class="<?php if($action->error) echo 'error'; else echo 'success'; ?>">
<?= $action->msg ?>
</div>
    <?php
}
?>

    <?php
        if($action->first)
		{
    ?>
    	<h2>Bienvenue sur le Kikiclub</h2>
    	<p>Le Kikiclub est une plateforme pour Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, illo accusantium! Quam porro laborum officiis et fugit quibusdam placeat qui obcaecati iste perferendis totam possimus neque itaque, commodi quaerat illo.</p>
   		<form action="reference.php" method="post">
           <h5>Si vous avez un code de référence, vous pouvez l'entrez ici :</h5>
           <input type="text" maxlength="8" name="code">
           <button type="submit">Envoyer</button>
        </form>
    <?php
        }
    ?>
        <h2>Recommandez à votre ami!</h2>
        <p>Envoyez votre code à votre ami, et à sa première connexion, chacun des membres de votre famille et de la sienne recevra 50 points!</p>

        <p><b>Votre code : </b> <?= $action->user_token ?></p>
           
         <h5>Partagez!</h5>
         <input id="link" type="text" value="https://www.doutreguay.com/reference.php?token=<?= $action->user_token?>">
         <button id="copy" type="button">Copy in clipboard</button>

</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");
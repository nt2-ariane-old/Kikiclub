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
    	<h2><?= $action->trans->read('reference','welcome_kikiclub')?></h2>
    	<p><?= $action->trans->read('reference','what_kikiclub')?></p>
   		<form action="reference.php" method="post">
           <h5><?= $action->trans->read('reference','if_code')?></h5>
           <input type="text" maxlength="8" name="code">
           <button type="submit"><?= $action->trans->read('reference','submit')?></button>
        </form>
    <?php
        }
    ?>
        <h2><?= $action->trans->read('reference','refered_to_friend')?></h2>
        <p><?= $action->trans->read('reference','refered_txt')?></p>

        <p><b><?= $action->trans->read('reference','your_code')?> : </b> <?= $action->user_token ?></p>

         <h5><?= $action->trans->read('reference','share')?></h5>
         <input id="link" type="text" value="https://www.kikicode.club/reference.php?token=<?= $action->user_token?>">

         <!-- <button id="copy" type="button"><?= ''//$action->trans->read('reference','copy')?></button> -->
         <a id="send-button" href='mailto:?subject=Rejoins%20Kikiclub!&amp;body=https://www.kikicode.club/reference.php?token=<?= $action->user_token?>' ><?= $action->trans->read('reference','send')?></a>

</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");
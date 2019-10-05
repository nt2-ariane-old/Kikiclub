<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/TodayMembersAction.php");

	$action = new TodayMembersAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>

    <main>
        <h2>Ajouter des Membres</h2>
        <div>
            <div class="autocomplete" style="width:300px;">
                <input id="search-member-firstname" type="text" name="search" placeholder="<?= $action->trans->read("admin","firstname") ?>">
            </div>
            <div class="autocomplete" style="width:300px;">
                <input id="search-member-lastname" type="text" name="search" placeholder="<?= $action->trans->read("admin","lastname") ?>">
            </div>
        </div>
        <h2>Membres d'Aujourd'hui</h2>
        <?php
            foreach ($action->today_members as $member) {
                ?>
                    <button onclick='change_page("assign-member.php",{"member_id":<?= $member["id"] ?>});' > <?= $member['firstname'] ?> <?= $member['lastname'] ?> </button>
                <?php
            }
        ?>
    </main>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");
<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/action/EditTextAction.php");

    $action = new EditTextAction();
    $action->execute();

    require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
    <form id="edit-text">
        <p>
            Page : 
            <select id="page"></select>
        </p>
        <p>
            Phrase :
            <select id="word"></select>
        </p>
        <p>
            Valeur Fr :
            <input type="text" id="fr">
        </p>
        <p>
            Valeur En :
            <input type="text" id="en">
        </p>
        <button type="button" onclick="editLang()">Envoyer</button>
    </form>
<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");
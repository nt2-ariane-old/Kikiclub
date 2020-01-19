<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/MaterialsAction.php");

	$action = new MaterialsAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
    <main>
        <div class="sheet">  
            <form action="materials" method="post">
                <div id='materials'>

                    <?php
                    
                    foreach ($action->materials as $material) {
                        ?>
                            <p> Matériel <?= $material["id"]?> : <input onkeypress="modifycheck(this.parentElement.querySelector('button'))" type="text" id='<?= $material["id"]?>' value="<?= $material['name']?>"> <button onclick="deleteMaterial(this.parentElement.querySelector('input')"; type="button">x</button> </p>
                            <?php
                    }
                    ?>
                </div>
                <button onclick="addMaterial()" type="button">+</a>
                <button class="submit-btn" type="submit">Appliquer</button>
            </form>
        </div>
    </main>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");
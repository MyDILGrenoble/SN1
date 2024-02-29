<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['idProjet']) && $_POST['idProjet'] != 'auto' ? $_POST['idProjet'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    //$phone = isset($_POST['illustration']) ? $_POST['illustration'] : '';
    $creation = isset($_POST['creation']) ? $_POST['creation'] : date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO projet (idProjet, nomProjet, descriptionProjet, dateCreation) VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $nom, $description, $creation]);
    // Output message
    $msg = 'Projet ajouté!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Ajouter un projet</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nom">Nom</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="nom" placeholder="Un beau projet" id="nom">
        <label for="description">Description</label>
        <input type="text" name="description" placeholder="Bla bla bla..." id="description">
       
        <label for="creation">Date de création</label>
        <input type="datetime-local" name="creation" value="<?=date('Y-m-d\TH:i')?>" id="creation">
        <input type="submit" value="Ajouter">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
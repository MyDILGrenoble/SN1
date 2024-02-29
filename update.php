<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Vérifie si l'id du projet existe, par example update.php?id=1 récupère le projet dont l'id est 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $illustration = isset($_POST['illustration']) ? $_POST['illustration'] : '';
        $createur = isset($_POST['createur']) ? $_POST['createur'] : '';
        $creation = isset($_POST['creation']) ? $_POST['creation'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE projet SET idProjet = ?, nomProjet = ?, descriptionProjet = ?, dateCreation = ? WHERE idProjet = ?');
        $stmt->execute([$id, $nom, $description, $creation, $_GET['id']]);
        $msg = 'Projet mis à jour!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM projet WHERE idProjet = ?');
    $stmt->execute([$_GET['id']]);
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$projet) {
        exit('Pas de projet avec cet ID!');
    }
} else {
    exit('Aucun id précisé!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Modifier le projet #<?=$projet['idProjet']?></h2>
    <form action="update.php?id=<?=$projet['idProjet']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Nom</label>
        <input type="text" name="id" placeholder="1" value="<?=$projet['idProjet']?>" id="id">
        <input type="text" name="nom" placeholder="Ce projet" value="<?=$projet['nomProjet']?>" id="nom">
        <label for="description">Description</label>
        <label for="illustration">Illustration</label>
        <input type="text" name="description" placeholder="Patati patata" value="<?=$projet['descriptionProjet']?>" id="description">
        <input type="text" name="illustration" placeholder="Upload image" value="<?=$projet['illustration']?>" id="illustration">
        <label for="created">Date de création</label>
        <input type="datetime-local" name="creation" value="<?=date('Y-m-d\TH:i', strtotime($projet['dateCreation']))?>" id="creation">
        <input type="submit" value="Mettre à jour">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
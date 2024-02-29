<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Vérifie si $_POST n'est pas vide
if (!empty($_POST)) {
    // Pas vide -> insertion des nouvelles données
    //Vérification des variables . Si vide -> NULL
    $id = isset($_POST['id']) && !empty($_POST['idProjet']) && $_POST['idProjet'] != 'auto' ? $_POST['idProjet'] : NULL;
    // Vérification de nom
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    //$illustration = isset($_POST['illustration']) ? $_POST['illustration'] : '';
    $creation = isset($_POST['creation']) ? $_POST['creation'] : date('Y-m-d H:i:s');
    // Insertion dans la table projet
    $stmt = $pdo->prepare('INSERT INTO projet (idProjet, nomProjet, descriptionProjet, dateCreation) VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $nom, $description, $creation]);
    // Message de réussite
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

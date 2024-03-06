<?php
include 'functions.php';
// Connection BDD
$pdo = pdo_connect_mysql();
// On récupère le n° de la page(URL param: page), s'il n'existe pas alors page=1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Nombre d'enregistrements par page
$records_per_page = 5;


// Récupération des catégories
//$pdo = pdo_connect_mysql();
$stmt = $pdo->query('SELECT * FROM categorie');
$categories = $stmt->fetchAll();

// Vérification de la sélection de catégorie
if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
    $categorieFiltre = $_GET['categorie'];
   // On prepare la requête SQL pour récupérer les enregistrements de la table projet, LIMIT determine la page 
    $stmt = $pdo->prepare('SELECT * FROM projet p JOIN appartenir a ON p.idProjet = a.idProjet WHERE a.idCategorie = :categorie ORDER BY p.idProjet LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':categorie', $categorieFiltre);
} else {
    // Aucun filtre, récupération de tous les projets
    //$stmt = $pdo->query('SELECT * FROM projet');
    //$stmt = $pdo->prepare('SELECT * FROM projet ORDER BY idProjet LIMIT :current_page, :record_per_page');
    $stmt = $pdo->prepare('SELECT * FROM projet ORDER BY idProjet LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
}
$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_projets = $pdo->query('SELECT COUNT(*) FROM projet')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Tous les projets</h2>
    <div class = 'caption'>
        <a href="create.php" class="create-contact">Ajouter un projet</a>
        <form method="get">
            <select name="categorie" class='create-contact'>
            <option value="">Toutes les catégories</option>
            <?php 
                foreach ($categories as $categorie) {
                    $selected = ($categorieFiltre == $categorie['idCategorie']) ? 'selected' : '';
                    echo '<option value="' . $categorie['idCategorie'] . '" ' . $selected . '>' . htmlspecialchars($categorie['label']) . '</option>';
}
?>
</select>
<input class="create-contact" type="submit" value="Filtrer">
</form>
    </div>
	
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nom</td>
                <td>Description</td>
                <td>Illustration</td>
                <td>Creation</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projets as $projet): ?>
            <tr>
                <td><?=$projet['idProjet']?></td>
                <td><?=$projet['nomProjet']?></td>
                <td><?=$projet['descriptionProjet']?></td>
                <td><img class="images" src="<?=$projet['illustration']?>"></td>
                <td><?=$projet['dateCreation']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$projet['idProjet']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$projet['idProjet']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_projets): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
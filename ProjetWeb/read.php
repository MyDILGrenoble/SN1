<?php
include 'functions.php';
// Connection BDD
$pdo = pdo_connect_mysql();
// On récupère le n° de la page(URL param: page), s'il n'existe pas alors page=1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Nombre d'enregistrements par page
$records_per_page = 5;

// On prepare la requête SQL pour récupérer les enregistrements de la table projet, LIMIT determine la page

$stmt = $pdo->prepare('SELECT * FROM projet ORDER BY idProjet LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
/*
$stmt = $pdo->prepare('SELECT * FROM projet ORDER BY idProjet');
*/
$stmt->execute();
// On récupère les enregistrements pour les afficher.
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Obtenir le nombre total de projets, pour savoir s'il faut un bouton suivant/précédent
$num_projets = $pdo->query('SELECT COUNT(*) FROM projet')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Tous les projets</h2>
	<a href="create.php" class="create-contact">Ajouter un projet</a>
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

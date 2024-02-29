<?php
include 'functions.php';
// Connection BDD
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page

$stmt = $pdo->prepare('SELECT * FROM projet ORDER BY idProjet LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
/*
$stmt = $pdo->prepare('SELECT * FROM projet ORDER BY idProjet');
*/
$stmt->execute();
// Fetch the records so we can display them in our template.
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
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
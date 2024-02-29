<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM projet WHERE idProjet = ?');
    $stmt->execute([$_GET['id']]);
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$projet) {
        exit('Aucun projet avec cet id!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM projet WHERE idProjet = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Le projet a été supprimé!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Supprimer le projet #<?=$projet['idProjet']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Sûr de vouloir supprimer le projet #<?=$projet['idProjet']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$projet['idProjet']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$projet['idProjet']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
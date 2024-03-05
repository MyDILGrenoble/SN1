<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
//Vérifie si l'ID existe
if (isset($_GET['id'])) {
    // Selectionne l'enregistrement à supprimer
    $stmt = $pdo->prepare('SELECT * FROM projet WHERE idProjet = ?');
    $stmt->execute([$_GET['id']]);
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$projet) {
        exit('Aucun projet avec cet id!');
    }
    // Demander confirmation avant suppression
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'oui') {
            // L'utilisateur a clické sur le bouton "Oui", on supprime
            $stmt = $pdo->prepare('DELETE FROM projet WHERE idProjet = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Le projet a été supprimé!';
        } else {
            // L'utilisateur a clické sur le bouton "Non", on renvoie à la liste
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('Aucun Id spécifié!');
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
        <a href="delete.php?id=<?=$projet['idProjet']?>&confirm=oui">Oui</a>
        <a href="delete.php?id=<?=$projet['idProjet']?>&confirm=non">Non</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>

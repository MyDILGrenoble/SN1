<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'wiki';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// Si la connection échoue, on arrête tout et on affiche l'erreur.
    	exit('La connexion a échoué!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Wiki du MyDIL</h1>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
    		<a href="read.php"><i class="fas fa-users-cog"></i>Projets</a>
			<!-- <i class="fa-thin fa-users-gear"><i class="fas fa-users-cog"> -->
			
    	</div>
    </nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>

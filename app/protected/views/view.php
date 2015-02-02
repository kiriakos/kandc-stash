<!DOCTYPE html>
<html>
	<head>
		<?php include "views/header-ios-links.php"; ?>
		<?php include "views/header-css.php"; ?>

		<title>K&amp;C's stash</title>
	</head>
	<body>
		<div id="title">
		<?php 
			if($path_current)
			    echo "<h3>$path_current</h3>";
			else
			    echo "<h3>K and C's stash</h3>";
		?>
		</div>
        
		<?php include 'views/navigation-dirs.php'; ?>
        <?php include 'views/navigation-assets.php'; ?>
		<?php include 'views/asset.php'; ?>
		<?php include 'views/upload.php'; ?>
	</body>
</html>


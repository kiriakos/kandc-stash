<!DOCTYPE html>
<html>
	<head>
		<?php include $templates_path. DIRECTORY_SEPARATOR. "header-ios-links.php"; ?>
		<?php include $templates_path. DIRECTORY_SEPARATOR. "header-css.php"; ?>
        <?php include $templates_path. DIRECTORY_SEPARATOR. "header-javascript.php"; ?>

		<title>K&amp;C's stash</title>
	</head>
	<body>
		
        
		<?php include $templates_path. DIRECTORY_SEPARATOR. 'navigation-dirs.php'; ?>
        <?php include $templates_path. DIRECTORY_SEPARATOR. 'navigation-assets.php'; ?>
		<?php include $templates_path. DIRECTORY_SEPARATOR. 'asset.php'; ?>
		<?php include $templates_path. DIRECTORY_SEPARATOR. 'upload.php'; ?>
        
        <div id="title">
		<?php 
			if($path_current)
			    echo "<h3>$path_current</h3>";
			else
			    echo "<h3>K and C's stash</h3>";
		?>
		</div>
	</body>
</html>


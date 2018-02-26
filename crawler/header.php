<?php
	require_once "initFB.php";
	
	?>
	<html>
	<head>
		<title>
			hello you
		</title>	
		<meta charset = "utf-8"/>
	</head>
	
	<body>
		<nav>
		<ul>
        <?php
		if (!isset($_SESSION['facebook_access_token'])) {
	    ?>
			<li><a href = <?php echo "login.php"?> >login</a></li>
		<?php }
		?>
			<li><a href = <?php echo "data.php"?> >search post for all groups</a></li>
			<li><a href = <?php echo "search.php" ?> >search video</a></li>

		</ul>

			
		
		</nav>

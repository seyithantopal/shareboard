<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Shareboard</title>
	<link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>public/css/bootstrap.css">
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo ROOT_URL;?>">Shareboard</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="<?php echo ROOT_URL;?>home">Home</a></li>
					<li><a href="<?php echo ROOT_URL;?>share">Share</a></li>
					<li><a href="<?php echo ROOT_URL;?>user">Users</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
				<?php 
				@session_start();
				if(isset($_SESSION['user_data'])) : ?>					
					<li><a href="<?php echo ROOT_URL;?>profile/<?php echo $_SESSION['user_data']['username']; ?>"><?php echo $_SESSION['user_data']['name']; ?></a></li>
					<li><a href="<?php echo ROOT_URL;?>user/logout">Logout</a></li>
				<?php else : ?>
					<li><a href="<?php echo ROOT_URL;?>user/login">Login</a></li>
					<li><a href="<?php echo ROOT_URL;?>user/register">Register</a></li>
				<?php endif;?>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>

<div class="container">
		<div class="row-fluid"></div>
		<?php require $viewPath; ?>
	</div>
</div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>404 - Error Page</title>
	<link rel="stylesheet" type="text/css" href="<?php echo APP_URL; ?>public/css/bootstrap.css">
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<h1 class="danger">An Error has occured</h1>

			<p class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				<?php echo $this->message; ?>
			</p>
			<a href="<?php echo ROOT_URL; ?>" class="btn btn-primary">Home</a>
		</div>
	</div>
</body>
</html>
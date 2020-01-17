<div class="text-center">
	<h1>Welcome to Shareboard</h1>
	<p class="lead">Find something cool? Share it with our community. Look at other shares as well</p>
	<a class="btn btn-primary text-center" href="<?php echo ROOT_URL;?>share/add">Share Now</a>
</div>
<?php
echo 'Users: <br>';
foreach($viewData as $user) {
	echo $user['id'] . ' - ' . $user['username'] . '<br>';
}
?>
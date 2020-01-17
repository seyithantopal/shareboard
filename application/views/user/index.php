<div>
	<?php foreach($viewData as $data) : ?>
		<div class="well" style="margin-top:10px;">
			<h3><?php echo $data['name']; ?></h3>
			<small><?php echo $data['register_date']; ?></small><br /><br />
			<p style="text-align:justify;"><?php echo $data['email']; ?></p>
			<hr style="border-color:silver;"/>
			<a class="btn btn-default" href="<?php echo ROOT_URL . 'profile/' . $data['username'];?>" target="__blank">Go To Profil Page</a>
		</div>
	<?php endforeach;?>
</div>
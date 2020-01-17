<div>
	<?php foreach($viewData as $data) : ?>
		<div class="well" style="margin-top:10px;">
		<h3><?php echo $data['title']; ?></h3>
			<small><?php echo $data['create_date']; ?></small>
			<hr style="border-color:silver;"/>
			<p style="text-align:justify;"><?php echo $data['content']; ?></p>
			<br />
			<a class="btn btn-default" href="<?php echo $data['link']; ?>" target="__blank">Go To Website</a>
		</div>
	<?php endforeach;?>
</div>
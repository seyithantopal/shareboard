<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Share Something!</h3>
  </div>
  <div class="panel-body">
  	<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
  		<div class="form-group">
  			<label>Share Title</label>
  			<input type="text" name="title" class="form-control" />
  		</div>

  		<div class="form-group">
  			<label>Body</label>
  			<textarea name="content" class="form-control" rows="7" style="resize:none;" /></textarea>
  		</div>
  		
  		<div class="form-group">
  			<label>Link</label>
  			<input type="text" name="link" class="form-control" />
  		</div>
  		<input type="submit" class="btn btn-primary" name="submit" value="Submit">
  		<a class="btn btn-danger" href="<?php echo ROOT_URL;?>share">Cancel</a>
  	</form>
  </div>
</div>
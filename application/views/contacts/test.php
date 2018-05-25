<html>
<body>
	<form method="post" enctype="multipart/form-data" action="<?php echo base_url().'index.php/contacts/sendTest'; ?>" >
		<input type="file" name="up1" multiple/>
		<input type="file" name="up2" multiple/>

		<input type="submit">
	</form>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulaire Javascript et PHP avec code anti-spam</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script type="text/javascript" src="js/form.js"></script>
	<script type="text/javascript" src="js/md5.js"></script>
</head>
<body>
	<div class="conteneur">
		<form id="form" onsubmit="return VerifForm(this)" method="post" action="">
			<div id="msg_erreur"></div>
			<p><label>Nom</label><input type="text" name="nom" id="nom" value="<?php echo $nom; ?>" /></p>
			<p><label>E-mail</label><input type="text" name="email" id="email" value="<?php echo $email; ?>" /></p>
			<p><label><?php echo $question; ?><br /><small>Répondre en minuscule</small></label><input type="text" name="captch id="captcha" /></p>
			<p><label>&nbsp;</label>
			<input type="submit" name="valider" value="Valider" /></p>
			<input type="hidden" name="crypt" id="crypt" value="<?php echo $crypt; ?>" />
		</form>
	</div>
</body>
</html>
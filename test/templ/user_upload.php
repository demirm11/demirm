<h2>
<?php

/*templ/user_upload.php */
echo "Willkommen im SEXCLUB <br> Benutzername => ".Controller::getUserName();



 ?>

<h3> Dateien uploaden </h3>

<h4><?php echo $data ?></h4>

<form method="post" action="index.php" enctype="multipart/form-data">
  <input type="hidden" name="upload">
  <textarea placeholder="Suchworte angeben mit Komma" name="keys" required></textarea><br>
  <input type="checkbox" name="online" checked > freigeben <br><br>
  <input type="file" name="userfile" placeholder="Datei" required><br><br>
  <input type="submit" value="upload">






</form>
</h2>

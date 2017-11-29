<?php
 //templ/register.php

echo '
  <h2>Registrierung</h2>
  <form>
  <input type="hidden" name="savereg" value="true">
  <input type="text" placeholder="Name" name="rname" required><br>
  <input type="email" placeholder="E-Mail" name="rmail" required><br>
  <input type="pass" placeholder="Password" name="rpass" required><br>
  <input type="radio" name="rsex" value="w" required >w
  <input type="radio" name="rsex" value="m" required >m
  <input type="radio" name="rsex" value="n" required >n <br>
  <input type="submit" value="registrieren">
  </form>
 '
 
?>
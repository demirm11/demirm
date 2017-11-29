<!-- tmpl/login.php -->

<!--
get: 
 - Querystring in Adresszeile v. Browser
 - max. Länge 1024(2048)
 - bookmarkbar
 - Login, Anfrageformulare, Shop
post:
 - Querystring nicht zu sehen
 - max. Grundeinstellung 2MB erweiterbar je nach System upload
 - www.amazon.de? (domain + seitenname)
 - upload Filme, Grafiken, CMS
-->
<?php  
    if (!isset($_SESSION["user"])){ // User ist nicht angemeldet
    echo '
    <form method="get">
    <input type="email" placeholder="e-Mail" name="mail" required><br>
    <input type="password" placeholder="Passwort" name="pass" required><br>
    <input type="submit" value="anmelden">
    <a href="?register=true">Registrieren</a><br>
    </form>
    
    ';
    }else{
      echo '<a href="?logout=true">logout</a><br>';  
    }
?>        

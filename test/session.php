<?php
//Session anlegen
// archivtect/session.php

echo "Sessiontest";
session_start();//startet Session 1.Mal pro Script
echo "<br>Meine Sessionid:". session_id();//vom Server bereitgestellt
//0 = Disable
//1 = None
//2= Active

echo "<br>".session_status()."<br>";


//$_SESSION['user'] = "Otto";
if(isset($_SESSION['user'])){
    
    echo "<br>Angemeldet?:".$_SESSION['user'];
}else{
    echo "<br>User abgemeldet";
}

echo ini_get("session.gc_maxlifetime");
?>
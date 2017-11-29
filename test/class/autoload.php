<?php
// class/autoload.php
// Automatisches laden von benötigten
// Klassen
spl_autoload_register(function($class_name){
    include "class_".$class_name."_inc.php";
});
?>
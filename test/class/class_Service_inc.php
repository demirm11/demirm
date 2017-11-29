<?php
// class/class_Service_inc.php
// Datenbankergebnisse als array liefern
class Service {
    private static $myPDO; // einmalig für alle Objekte
    
    private static function connectDB(){
    $host = "localhost";// domain
    $db_name = "db_archivtect";
    $user = "root"; //Grundeinstellung MySQl Apache
    $pass = "";//Grundeinsatellung MySQl Apache
    SELF::$myPDO = new PDO("mysql:host=".$host,$user,$pass);
    try{
      SELF::$myPDO->query("USE ".$db_name);// Bereitstellung
      SELF::$myPDO->exec('SET NAMES utf8; SET CHARACTER SET UTF8'); 
    }
    catch(PDOException $e){
      exit("Error: ".$e->getMessage());
    }
 }// end Service class
    
// Methode zur Anfrage an DB
public static function getOne($sql){ //gib 1 Wert zurück
    SELF::connectDB();// DB verbinden
    $res = SELF::$myPDO->query($sql);// DB Anfrage starten   
    return $res->fetchColumn();// 1 String zurück
}  
//Methode zum schreiben in DB    
public static function setExec($sql){
      SELF::connectDB();// DB verbinden
      SELF::$myPDO->exec($sql);//ausführen
      return SELF::$myPDO->lastInsertId();// aktuelle id
}    
    
    
    
    // getter
    function getFetchAll(){
      return "DB Ergebnis = erfolgreich"; 
    }
}
//$arr = SELF::$myPDO->errorInfo();// Fehlermeldung SQL
//    echo $arr[2]; 
?>

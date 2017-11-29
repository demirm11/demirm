<?php
//php/db_init.php

$host = "localhost";// domain
$db_name = "db_archivtect";
$user = "root"; //Grundeinstellung MySQl Apache
$pass = "";//Grundeinsatellung MySQl Apache

// erstellen einer Instanz von PDO PHP Data Objects //(Schnittstelle)

$myPDO = new PDO("mysql:host=".$host,$user,$pass);
try{
  $myPDO->exec('CREATE DATABASE IF NOT EXISTS '.$db_name);
}
catch(PDOException $e){
                  //Instanz->Methode
    exit("Error: ".$e->getMessage());
}
$myPDO->query("USE ".$db_name);// Bereitstellung der Datenbank

$sql = 'SET NAMES utf8; SET CHARACTER SET UTF8';
$myPDO->exec($sql);

$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_password(
             id INT(11) AUTO_INCREMENT UNIQUE PRIMARY KEY,
             hash CHAR(128)
             )';

$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_user(
            id INT(11) AUTO_INCREMENT UNIQUE PRIMARY KEY,
            name VARCHAR(40),
            email VARCHAR(256) UNIQUE,
            sex CHAR(1),
            id_pass INT,
            FOREIGN KEY(id_pass) REFERENCES tb_password(id)
            )';

$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_salt(
             id INT(11) AUTO_INCREMENT UNIQUE PRIMARY KEY,
             salt CHAR(255),
             id_pass INT,
             FOREIGN KEY(id_pass) REFERENCES tb_password(id)
             )';

$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_archiv(
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            id_user INT(11),
            name VARCHAR(255),
            datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,/*1.1.1970*/
            path VARCHAR(255),
            online BOOLEAN NOT NULL,
            FOREIGN KEY(id_user) REFERENCES tb_user(id)
            )';

$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_key(
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            search VARCHAR(255) UNIQUE
            )';

$sqlArr[] = 'CREATE TABLE IF NOT EXISTS tb_key_archiv(
            id_key INT(11),
            id_archiv INT(11),
            FOREIGN KEY(id_archiv) REFERENCES tb_archiv(id),
            FOREIGN KEY(id_key) REFERENCES tb_key(id)
            )';



// Mehrere Tabellen gleichzeitig anlegen
foreach($sqlArr as $sql){
    $myPDO->exec($sql);
    // Überprüfung SQL Konformität vom letzten SQL
    $arr = $myPDO->errorInfo();// Fehlermeldung SQL
    echo $arr[2];
}


echo "Datenbank angelegt ? Wenn nicht hast du was zusuchen :D";
?>

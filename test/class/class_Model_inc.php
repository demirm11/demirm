<?php
// class/class_Model_inc.php
// das Modellieren der DB Anfrage
// Ergebnisse werden zurückgeliefert

class Model{
 public static function getPassOk($mail,$pass){
    $sql = "SELECT T1.id
            FROM tb_user T1, tb_password T2
            WHERE T1.email='{$mail}' AND T2.hash='{$pass}'
            AND T1.id_pass = T2.id
            ";
    return Service::getOne($sql);
 }

 public static function getSalt($mail){
    $sql = "SELECT T2.salt
            FROM tb_user T1, tb_salt T2
            WHERE T1.email = '{$mail}' AND
                  T1.id_pass = T2.id_pass
           ";
    return Service::getOne($sql); //hier gibts das Salz
 }

 public static function setRegister($name,$mail,$pass,$sex){
     $salt ='';//leer
     for($i=1;$i<=10;$i++){ //Schleife
       $salt .= rand(0,9);//
     }
     $hash = hash("sha512",$pass.$salt);// Hash erzeugen aus password und salt

     $sql = "INSERT INTO tb_password
             (hash) VALUES('{$hash}')";
     $id  = Service::setExec($sql);

     $sql = "INSERT INTO tb_salt
             (salt,id_pass) VALUES('{$salt}',{$id})";
     Service::setExec($sql);

     $sql = "INSERT INTO tb_user
            (name,email,sex,id_pass) VALUES('{$name}','{$mail}','{$sex}',{$id})";
     return Service::setExec($sql);//user id
 }

 /*function __construct(){
  echo "Die Model Instanz entsteht";
 }*/

 //function getData(){
  //Modellierung der Anfrage
  // Rückgabe der Datenbankergebnisse
  //return SERVICE::getFetchAll();
 //}

 /*function __destruct(){
  echo "ich war die Instanz Model";
 }*/
public static function getUserNameFromId($id){
  $sql="SELECT name FROM tb_user WHERE id={$id}";
  return Service::getOne($sql);
}

//SCHREIBEN in Archivdatei-----------------------
public static function setArchiv($a,$b,$c,$d){
  $sql="INSERT INTO tb_archiv
        (id_user,name,path,online)
        VALUES({$a},'{$b}','{$c}',{$d})";
      return Service::setExec($sql);
 //Modell::setArchiv($_SESSION('user'),$datei,SELF::UPATH),$this->request['online']);
}
###################  Keys schreiben  ################
public static function setKeys($key){
  $sql="INSERT INTO tb_key
    (search) VALUES (UPPER('{$key}'))";
    return Service::setExec($sql);
}
####################  Verbindungstabelle Suchwort->medium ########################
public static function setKeyArchiv($id_key,$id_archiv){
  $sql="INSERT INTO tb_key_archiv
    (id_key,id_archiv) VALUES({$id_key},{$id_archiv})";
    return Service::setExec($sql);
}








}//end class Modell

?>

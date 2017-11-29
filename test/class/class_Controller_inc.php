<?php
// class/class_Controller_inc.php

class Controller{
  private $request;
  private $tpl = "start"; //Starttemplate
  const UPATH = "upload/"; //upload path
  private $data = ""; //
  // initialisierung
  function __construct(){
      session_start();
      $this->request = $_REQUEST;//Eingang
    //  var_dump(array_keys($this->request));
      // Test auf query string name
      switch(key($this->request)){
          case 'mail' ; case 'pass': $this->setLogin();
                        break;
          case 'logout':$this->setLogout();
                        break;
          case 'register': $this->tpl = "register";
                        break;
          case 'savereg':$this->setRegister();
                        break;

          case 'upload':$this->setUpload();
                        break;
          default: ;
      }
      //$data = Model::getData();
    //  $data = "";
      $view = new View();//Rückgabe an Screen
      $view->setTemplate($this->tpl);//Login
      $view->setLayout($this->data);
      $view->toDisplay();
  }// end constructor

  private function setRegister(){
      $data = Model::setRegister($this->request['rname'],
      $this->request['rmail'],$this->request['rpass'],
      $this->request['rsex']);
      if($data !=0){
         $this->tpl = "register_ok";//Erfolgreich Seite
      }else{
         $this->tpl = "register_no";//Fehlerseite
      }
  }

   private function setLogin(){
      $salt = Model::getSalt($this->request['mail']);
      //$salt = "987654321";
      //echo hash('sha512','123'.$salt);
      $hash = hash('sha512',$this->request['pass'].$salt) ;
      $data = Model::getPassOk($this->request['mail'],$hash);
      if($data){// id muß vorhanden sein  //user vorhanden
           $_SESSION['user']= $data;//session
           $this->tpl = "user_upload";//template user upload geladen werden
      }
   }

   private function setLogout(){
      session_destroy();//Session auflösen
      header("Location: index.php");// Startseit neu
   }
   public function getUserName(){
     $data=Model::getUserNameFromId($_SESSION['user']);
     return $data;
   }

   private function setUpload(){
     $datei = $_FILES['userfile']['name'];
     $uploadfile = SELF::UPATH.$datei;    //$upath oben gegeben
########################Größe einschränken #####################################
if($_FILES['userfile']['size'] >=1047527424){ //als byte gibt man das an   1 MB= 1048576
  $this->data="Ihre Datei ist > 999 MB ";

}//bzw. php.ini max_max_filesize Standard 2M


//MIME Type erkennen bestimmte sachen zulassen
$zugelassen = array('video/mpeg','video/quicktime','video/x-sgi-movie','image/pjpeg','image/jpeg','image/jpg','image/png','image/gif','application/pdf','video/mpeg'); //er guckt header datei
if(!in_array($_FILES['userfile']['type'],$zugelassen)){
$this->data=" Datei ist nicht zugelassen";
}

 ///////////////////////////Upload starten//////////////////////////////
if($this->data==""){ //upload zugelassen



     if(move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfile)){
       $this->data ="Ihre Datei wurde Erfolgreich hochgeladen..";

       //checkbox sendet 2 sachen on oder garnicht
       if(isset($this->request['online'])) $on = 1;
       else $on = 0;

       $id_archiv = Model::setArchiv($_SESSION['user'], $datei ,SELF::UPATH, $on);
       //,$this->request['keys'],
       //echo "test:" .$this->request['online'];//checkbox

###################################Parsen der Key########################################
        //Sonne,Wärme,Luft  ""Worte aus Textarea
      $arr=explode(",",$this->request['keys']);
      foreach ($arr as $key){
          if(trim($key)== '') continue; //1 Mal nicht schreiben
        $id_key = Model::setKeys(trim($key));//einzelne Keys werden übertragen

      //Model::setKeys($this->request['keys']);

    Model::setKeyArchiv($id_key,$id_archiv);//setzen $id_key, $id_archiv
  }





     }else{
       $this->$data = "Upload ist abgebrochen Warum ? Wie auch immer..";
       switch($_FILES['userfile']['name']){
            case 1:$this->data =  "Server läßt diese größe nicht zu";
              break;
            case 2:$this->data = "Datei ist zu groß";
              break;
            case 3:$this->data = "Datei unvollständig beim Server angekommen";
              break;
            case 4:$this->data = "Es wurde keine Datei hochgeladen";
              break;
            case 6:$this->data = "kein temporäres Verzeichens";
              break;
            case 7:$this->data = "Schreibschutz Zielverzeichnes";
              break;
            case 8:$this->data = "eine php erweiterung verhindert das speichern";
              break;

              }//ende upload zugelassen
       }
     }
     $this->tpl = "user_upload"; //zuladene Seite

   } //ende Methode setupload



}
?>

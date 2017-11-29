<?php
// class/class_view_inc.php
class View{
 private $template;
 private $output;
 private const TEMPL = "templ/";// Konstante

 //function __construct($data){
  //echo "<h2>".$data."</h2>";//Layout wiedergeben
 //}

 function setTemplate($thema){
  $this->template = $thema;
 }

 function setLayout($data){
    ob_start(); //eröffnet Puffer auf Server
    //
    include_once(SELF::TEMPL."header.php");
    include_once(SELF::TEMPL.$this->template.".php");
    include_once(SELF::TEMPL."footer.php");


    $this->output = ob_get_contents();
    ob_end_clean();// Puffer löschen
 }

 function toDisplay(){
    echo $this->output;
 }
}

?>

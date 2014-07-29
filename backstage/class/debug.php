<?php

if (isset($_POST)){
  foreach ($_POST as $k1 => $v1){
    if(is_array($v1)){
      foreach ($v1 as $k2 => $v2){
        echo '$_POST['.$k1.']['.$k2.']='.$v2."<br>\n";
        if (is_array($v2)){
          foreach ($v2 as $k3 => $v3){
            echo '$_POST['.$k1.']['.$k2.']['.$k3.']='.$v3."<br>\n";
          }
        }
      }
    }
    else{
      echo '$_POST['.$k1.']='.$v1."<br>\n";
    }
  }
}

if (isset($_GET)){
  foreach ($_GET as $k => $v){
    echo '$_GET['.$k.']='.$v."<br>\n";
  }
}

if (isset($_FILES)){
  foreach ($_FILES as $k1 => $v1){
    foreach ($v1 as $k2 => $v2){
      if(is_array($v2)){
        foreach ($v2 as $k3 => $v3){
          echo '$_FILES['.$k1.']['.$k2.']['.$k3.']='.$v3."<br>\n";
          //$file[$k1][$k2][$k3]=$v3;        
          //echo 'q: $file['.$k3.']['.$k1.']['.$k2.']='.$v3."<br>\n";
        }
      }
      else{
        echo '$_FILES['.$k1.']['.$k2.']='.$v2."<br>\n";      
      }
    }
  }
}




?>
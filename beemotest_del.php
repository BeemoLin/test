<?php

require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS); //�]class   data_function
//require_once(INCLUDES.'/PHPMailer/class.phpmailer.php');

//1.submit�ϥ�POST�覡;���Xsubmit��������T(�@���}�C)
if(isset($_POST))
{
	foreach($_POST as $key => $value)
  {
		$$key = $value;
		//echo '$'.$key.'='.$value."<br />\n";
	}
}
 if(isset($_POST['ot1_id'])) //���i�H����if�����F���b��
  {
    $ot1_id = $_POST['ot1_id'];
    $data_function = new data_function;
    $data_function->setDb('opinion_tab1');
    $where = "AND `ot1_id` = '".$ot1_id."' ";
    $expression = " `ot1_disable` = '1' ";
    $data_function->update($where,$expression); 
    //$data_function->delete_category($opinion_id);
  }
  header("location: beemotest.php");//��}�u��ϥ�GET�覡?page=2
 /*
if($type=="PART")
{
  //die("PART");
  header("location: reservation_list.php?equipment_id=".$equipment_id);//��}
}
else
{
  
  header("location: beemotest.php");//��}
}
  */
?>

<?php


require_once('define.php');
//require_once(CONNSQL);session�ˬd������
require_once(PAGECLASS);
require_once(INCLUDES.'/processdbcols.php');



//urldecode
//��HTML�Ҧ����󪺤��e�ϥ�action=get
if(isset($_GET))
{
	foreach($_GET as $key => $value){
		$$key = $value;
		//echo '$'.$key.'='.$value."<br />\n";
	}
}
$page=(isset($_GET['page']))?$_GET['page']:1;
//echo "���ư��D:".$page;
//$m_id = $_SESSION['MM_UserID'];
//$logoutAction = 'logout.php';
//�}�l�������
	$select = '
		`equipment_reservation_list`.*, 
		`equipment_reservation`.`equipment_name`,	
		`equipment_reservation`.`equipment_exclusive`,	
		`equipment_reservation`.`equipment_max_people`,	
		`equipment_reservation`.`advance_end`,	
		`memberdata`.`m_username`
	';
	//equipment_reservation_list(�q���O��) �P equipment_reservation(�]�Ƹ��) �p�� ����O1.���ۤv��ID�P�q�������ID�P2.�]�ƪ�ID�P�q�����]��ID
	$from_DB = '
		`equipment_reservation_list` 
		LEFT JOIN `equipment_reservation` 
			ON `equipment_reservation_list`.`equipment_id` = `equipment_reservation`.`equipment_id` 
		LEFT JOIN `memberdata`
			ON `equipment_reservation_list`.`m_id` = `memberdata`.`m_id`
	';

//�����n�����ƥ\�ध��A�[

//$pages = new sam_pages_class;
$pages = new data_function;
//---------------------------------------------------------------------
//���I�w�w���M�����
//�W�s�� a href="" �ϥ���},�ҥH���n href�ݩʫܭ��n(a href="#")

if(isset($equipment_id)) //VIEW�ϥΰ}�C�]�^��ҥH�n�P�O�O�_���}�C
{
  //echo  "�]�ƦW��:".$equipment_id;
  //die("�U���]�ƦW��");
  //	AND
	//		`equipment_reservation_list`.`list_disable` = '0'
	
	//��᪺����令���������
	$where = "
		AND 
			`equipment_reservation_list`.`equipment_id` = '".$equipment_id."'
		AND
			(`equipment_reservation_list`.`list_date`>='".$list_startdate."' AND `equipment_reservation_list`.`list_date`<='".$list_enddate."')
		AND
			`equipment_reservation_list`.`list_disable` = '0'
		ORDER BY 
		  `equipment_reservation_list`.`list_datetime` ASC, 
			`equipment_reservation_list`.`equipment_id`  ASC
		";
	//die($select.$from_DB.$where);
  $pages->setDb($from_DB);

  $array=$pages->select($where, $select);//�Ǧ^��ƶ��X�G���}�C
  
  /*
   $pages->setDb($from_DB, $where, $select);
  $pages->setPerpage(10,$page);//�C��10��
  $pages->set_base_page("reservation_list.php?equipment_id=".$equipment_id);
  
  $pages->action_mode("view_equipment_detail");
 //20121110��ƭn�a�J����Ѽ�;�o�n���Ѽ�,�]���n�a?equipment_id�ѼƳo�ˤ~��isset($equipment_id)��ܥ��T
 //20121111�N�o�ӰѼ�
  $Firstpage = $pages->getFirstpage3($equipment_id);//�Ĥ@��
  //die($Firstpage);
   //$equipment_id,
  $Listpage = $pages->getListpage3($equipment_id,$page,2);//�Ʀr:1,2,3....$page�I�쪺����
  //die($Listpage);
  
  $Endpage = $pages->getEndpage3($equipment_id);//;//�̲׭�
   //die($Endpage);
   
  $array = $pages->getData(); //���o���e*/
  
  if(is_array($array))//�ܭ��n���}�C�P�O�_�h�|�X��
  {
    //$returnData["$i"]["$key"] = $value;
    $checklisttime=new processdbcols;//�����ܪ��榡�b�o�B�z���n��VIEW�B�z
    foreach($array as $key2=>$value2)//$key2���ޭ�
    {
      
      $timeformat= $checklisttime->equipment_reservation_list_list_endtime($value2['list_endtime'],$value2['list_time'],$value2['advance_end'],$value2['equipment_id'],$value2['list_datetime']);
      //echo "-->".$key2."----".$timeformat; //$value2['list_datetime']
      //�ϥΦh�C�@��
      $timeformatList[$key2]["0"]=$timeformat;//$key2�����
      
    }
  }
}

//---------------------------------------------------------------------
include(PATH."/view/reservation_list__full_view.php");
/*
//�]���䪺LIST�]�ƦW��
function select_sql($equipment_picture = NULL)
{
	return $a = "
		SELECT *
		FROM `equipment_reservation`
		WHERE 
			`equipment_hidden` = '0'
		AND
			`equipment_disable` = '0'
		".$equipment_picture."
		ORDER BY
			`equipment_reservation`.`equipment_id` ASC
	";
}

$equ_menu_sql = select_sql();
$equ_menu_data = mysql_query($equ_menu_sql) or die(mysql_error());
//�]���䪺LIST�]�ƦW��
*/
?>

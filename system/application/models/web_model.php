<?php
class Web_model extends Model
	{
		function Web_model()
		{
			parent::Model();
		}
		function Data_Login($user,$pass)
		{
			$this->oracle_db=$this->load->database('oracle',true);

			$user_bersih=$this->oracle_db->escape($user);
			$pass_bersih=md5($pass);
			$query=$this->oracle_db->query("SELECT * from TBL_USER_WEB where USERNAME =".$this->oracle_db->escape($user)."  and PASSWORD = '".$pass_bersih."'");
			return $query;
		}
		function Update_Password($nim,$pwd)
		{
			$this->db->query("update tblkepegawaian set password=md5('$pwd') where username='$nim'");
		}
	}
?>

<?php
class Master_proses_model extends Model
{
	public function Master_proses_model()
		{
			parent::Model();
		}

	public function getProses()
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $t=$this->oracle_db->query("select * from tbl_master_proses");
			return $t->result();
		}

	
}
<?php
class Master_bapob_model extends Model
{
	public function Master_bapob_model()
		{
			parent::Model();
		}

	public function getDefaultBapob()
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $t=$this->oracle_db->query("select * from tbl_master_bapob a inner join tbl_master_bahan b on a.id_kode_bahan = b.kode_bahan  where a.status_default = 1");
			return $t->result();
			// $this->oracle_db->select('*');
		 //    $this->oracle_db->from('tbl_master_bapob');
		 //    $this->oracle_db->join('tbl_master_bahan', 'tbl_master_bapob.id_kode_bahan = tbl_master_bahan.kode_bahan', 'inner'); 
		 //    $query = $this->oracle_db->get();
		 //    return $query->result();

		}

}
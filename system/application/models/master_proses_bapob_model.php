<?php
class Master_proses_bapob_model extends Model
{
	public function Master_proses_bapob_model()
		{
			parent::Model();
		}

	public function getProses()
		{
		    $this->oracle_db=$this->load->database('oracle',true);
		    $t=$this->oracle_db->query("select * from tbl_master_proses_bapob");
			return $t->result();
		}

	public function findProsesByBapobAndMesin($idBapob, $idMesin){
		$this->oracle_db=$this->load->database('oracle',true);
		$t=$this->oracle_db->query("SELECT * FROM TBL_MASTER_PROSES_BAPOB where ID_MESIN = '$idMesin' and ID_BAPOB = '$idBapob'");
		return $t->result();
	}

	function findByName($namaProses){
		$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_MASTER_PROSES_BAPOB');
    	$this->oracle_db->where('NAMA_PROSES', $namaProses);
		$t=$this->oracle_db->get();
		return $t->row();
	}
}
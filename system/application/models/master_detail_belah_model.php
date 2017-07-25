<?php
class Master_detail_belah_model extends Model
{
	public function Master_detail_belah_model()
	{
		parent::Model();
	}

	function getMaxNumber()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select_max('NO_URUT_BELAH');
		$t=$this->oracle_db->get('TBL_DETAIL_BELAH');
		return $t->result();
	}

	function getLastCode()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->order_by("NO_URUT_BELAH", 'desc');
		$t=$this->oracle_db->get('TBL_DETAIL_BELAH');
		return $t->result();
	}

	function saveLaporanSensi($data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$success = $this->oracle_db->insert('TBL_DETAIL_BELAH', $data);
		$this->oracle_db->trans_commit();
		$this->oracle_db->trans_complete();
			if(!$success){
				$success = false;
				$errNo   = $this->oracle_db->_error_number();
				$errMess = $this->oracle_db->_error_message();
				array_push($errors, array($errNo, $errMess));
			}

		return $success;
	}

	function updateLaporanBelah($data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_URUT_BELAH',$id);
		$success = $this->oracle_db->update('TBL_DETAIL_BELAH', $data);
		$this->oracle_db->trans_commit();
		$this->oracle_db->trans_complete();
			if(!$success){
				$success = false;
				$errNo   = $this->oracle_db->_error_number();
				$errMess = $this->oracle_db->_error_message();
				array_push($errors, array($errNo, $errMess));
			}

		return $success;
	}

	function findByRollAndMutasi($kodeRoll, $noMutasi){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_BELAH');
	   	$this->oracle_db->where('KODE_ROLL',$kodeRoll);
	   	$this->oracle_db->where('NO_MUTASI_SENSI',$noMutasi);
	   	$this->oracle_db->order_by('NO_URUT_BELAH','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function getDataForMutation(){
		$this->oracle_db=$this->load->database('oracle',true);
		// $this->oracle_db->select('kode_roll, nomor_kk, sum(baik_meter) as total_bahan');
		$this->oracle_db->where("(STATUS_MUTASI = 'BELUM MUTASI')", NULL, FALSE);
		$this->oracle_db->order_by('NO_URUT_BELAH','asc');
		$t=$this->oracle_db->get('TBL_DETAIL_BELAH');
		return $t->result();
	}

	function getAllData(){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->order_by('NO_URUT_BELAH','asc');
		$t=$this->oracle_db->get('TBL_DETAIL_BELAH');
		return $t->result();
	}
	function findByDateRange($startDate,$endDate){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_BELAH');
		$this->oracle_db->where('tgl_produksi >=', $startDate);
		$this->oracle_db->where('tgl_produksi <=', $endDate);
	   	$this->oracle_db->order_by('NO_URUT_BELAH','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByKK($nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_BELAH');
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->order_by('NO_URUT_BELAH','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}
	function findByDateRangeAndKK($startDate,$endDate,$nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_BELAH');
		$this->oracle_db->where('tgl_produksi >=', $startDate);
		$this->oracle_db->where('tgl_produksi <=', $endDate);
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->order_by('NO_URUT_BELAH','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}
	
	function countTimeProses($nomorKK, $bulan){
		$this->oracle_db=$this->load->database('oracle',true);
		$success = $this->oracle_db->query("
		SELECT  SUM (
            TO_DATE(FINISH_JAM_PRODUKSI, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_PRODUKSI, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_PROSES,
		SUM (
            TO_DATE(FINISH_JAM_PERSIAPAN, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_PERSIAPAN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_PERSIAPAN,
		SUM (
            TO_DATE(FINISH_JAM_TROUBLE_PRODUKSI, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_TROUBLE_PRODUKSI, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_TROUBLE_PROSES_PROD,
		SUM (
            TO_DATE(FINISH_JAM_TROUBLE_MESIN, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_TROUBLE_MESIN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_TROUBLE_MESIN,
		SUM (
            TO_DATE(FINISH_JAM_TUNGGU_BAHAN, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_TUNGGU_BAHAN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_TUNGGU_BAHAN,
		SUM (
            TO_DATE(FINISH_JAM_TUNGGU_CORE, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_TUNGGU_CORE, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_TUNGGU_CORE,
		SUM (
            TO_DATE(FINISH_JAM_GANTI_SILINDER_SERI, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_GANTI_SILINDER_SERI, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_GANTI_SILINDER,
		SUM (
            TO_DATE(FINISH_JAM_FORCE_MAJOR, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_FORCE_MAJOR, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_FORCE_MAJOR,
		SUM (
            TO_DATE(FINISH_JAM_LAIN_LAIN, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_LAIN_LAIN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_LAIN_LAIN
		
		FROM   TBL_DETAIL_BELAH

		where NOMOR_KK = '".$nomorKK."'");
		return $success->result();

	}

	function findByDate($date){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_BELAH');
		$this->oracle_db->where('tgl_produksi', $date);
	   	$this->oracle_db->order_by('NO_URUT_BELAH','ASC');
		$t=$this->oracle_db->get();
		return $t->result();
	}

}
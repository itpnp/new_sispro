<?php
class Master_detail_sensi_model extends Model
{
	public function Master_detail_sensi_model()
	{
		parent::Model();
	}

	function getDataByKodeRoll($kodeRoll)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(KODE_ROLL like '%$kodeRoll%')", NULL, FALSE);
		$this->oracle_db->order_by("NO_URUT_EMBOSS", 'desc');
		$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
		return $t->result();
	}

	function saveLaporanSensi($data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$success = $this->oracle_db->insert('TBL_DETAIL_SENSI', $data);
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

	function getMaxNumber()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select_max('NO_URUT_SENSI');
		$t=$this->oracle_db->get('TBL_DETAIL_SENSI');
		return $t->result();
	}

	function getLastCode()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->order_by("NO_URUT_SENSI", 'desc');
		$t=$this->oracle_db->get('TBL_DETAIL_SENSI');
		return $t->result();
	}

	function getAllData(){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->order_by('NO_URUT_SENSI','asc');
		$t=$this->oracle_db->get('TBL_DETAIL_SENSI');
		return $t->result();
	}

	// function chooseKodeRoll(){
	//    	$this->oracle_db=$this->load->database('oracle',true);
	//    	$this->oracle_db->select('*');
	//    	$this->oracle_db->from('TBL_MUTASI_REWIND');
	// 	$this->oracle_db->where('STATUS_SENSI','progress');
	// 	$t=$this->oracle_db->get();
	// 	return $t->result();
	// }
	function chooseKodeRoll(){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('kode_roll, no_mutasi, sum(total_bahan) as total_bahan');
	   	$this->oracle_db->from('TBL_MUTASI_REWIND');
		$this->oracle_db->where('STATUS_SENSI','progress');
	   	$this->oracle_db->group_by('kode_roll');
		$this->oracle_db->group_by('no_mutasi'); 
		$t=$this->oracle_db->get();
		return $t->result();
	}
	function findByRoll($kodeRoll){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_REWIND');
	   	$this->oracle_db->where('KODE_ROLL',$kodeRoll);
	   	$this->oracle_db->order_by('NO_URUT_REWIND','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByRollAndMutasi($kodeRoll,$noMutasi){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_SENSI');
	   	$this->oracle_db->where('KODE_ROLL',$kodeRoll);
	   	$this->oracle_db->where('NO_MUTASI_REWIND',$noMutasi);
	   	$this->oracle_db->order_by('NO_URUT_SENSI','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	// function getDataForMutation(){
	// 	$this->oracle_db=$this->load->database('oracle',true);
	// 	$this->oracle_db->where("(NO_MUTASI_DEMET = '0')", NULL, FALSE);
	// 	$this->oracle_db->order_by('NO_URUT_DEMET','asc');
	// 	$t=$this->oracle_db->get('TBL_DETAIL_DEMET');
	// 	return $t->result();
	// }

	function getDataForMutation(){
		$this->oracle_db=$this->load->database('oracle',true);
		// $this->oracle_db->select('kode_roll, nomor_kk, sum(baik_meter) as total_bahan');
		$this->oracle_db->where("(STATUS_MUTASI = 'BELUM MUTASI')", NULL, FALSE);
		// $this->oracle_db->group_by('kode_roll');
		// $this->oracle_db->group_by('nomor_kk'); 
		$t=$this->oracle_db->get('TBL_DETAIL_SENSI');
		return $t->result();
	}

	function saveMutasi($kodeRoll, $nomorKk,$data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('KODE_ROLL',$kodeRoll);
		$this->oracle_db->where('NOMOR_KK',$nomorKk);
		$success = $this->oracle_db->update('TBL_DETAIL_SENSI', $data);
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
	function findByDateRange($startDate,$endDate){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_SENSI');
		$this->oracle_db->where('tgl_produksi >=', $startDate);
		$this->oracle_db->where('tgl_produksi <=', $endDate);
	   	$this->oracle_db->order_by('NO_URUT_SENSI','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByKK($nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_SENSI');
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->order_by('NO_URUT_SENSI','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}
	function findByDateRangeAndKK($startDate,$endDate,$nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_SENSI');
		$this->oracle_db->where('tgl_produksi >=', $startDate);
		$this->oracle_db->where('tgl_produksi <=', $endDate);
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->order_by('NO_URUT_SENSI','desc');
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
		
		FROM   TBL_DETAIL_SENSI

		where NOMOR_KK = '".$nomorKK."'");
		return $success->result();

	}

	function findByDate($date){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_SENSI');
		$this->oracle_db->where('tgl_produksi', $date);
	   	$this->oracle_db->order_by('NO_URUT_SENSI','ASC');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function groupByKodeRoll($nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('KODE_ROLL');
	   	$this->oracle_db->from('TBL_DETAIL_SENSI');
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->group_by('KODE_ROLL');
		$t=$this->oracle_db->get();
		return $t->result();
	}
	function laporanPerKK($nomorKK){
		$this->oracle_db=$this->load->database('oracle',true);
		$success = $this->oracle_db->query("
		SELECT TGL_PRODUKSI, MESIN_SENSI, NOMOR_KK,SHIFT_SENSI, KODE_ROLL, TOTAL_BAHAN, BAIK_METER, WASTE_METER, REJECT_METER, SISA_BAIK,(TO_DATE(FINISH_JAM_PRODUKSI, 'YYYY-MM-DD HH24:MI')
            - TO_DATE(START_JAM_PRODUKSI, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS JAM_PROSES,
		( TO_DATE(FINISH_JAM_PERSIAPAN, 'YYYY-MM-DD HH24:MI')
          - TO_DATE(START_JAM_PERSIAPAN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS A,
		 ( TO_DATE(FINISH_JAM_TROUBLE_PRODUKSI, 'YYYY-MM-DD HH24:MI')
           - TO_DATE(START_JAM_TROUBLE_PRODUKSI, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS B,
		( TO_DATE(FINISH_JAM_TROUBLE_MESIN, 'YYYY-MM-DD HH24:MI')
          - TO_DATE(START_JAM_TROUBLE_MESIN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS C,
		( TO_DATE(FINISH_JAM_TUNGGU_BAHAN, 'YYYY-MM-DD HH24:MI')
          - TO_DATE(START_JAM_TUNGGU_BAHAN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS D,
		(  TO_DATE(FINISH_JAM_TUNGGU_CORE, 'YYYY-MM-DD HH24:MI')
           - TO_DATE(START_JAM_TUNGGU_CORE, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS E,
		( TO_DATE(FINISH_JAM_GANTI_SILINDER_SERI, 'YYYY-MM-DD HH24:MI')
           - TO_DATE(START_JAM_GANTI_SILINDER_SERI, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS F,
		( TO_DATE(FINISH_JAM_FORCE_MAJOR, 'YYYY-MM-DD HH24:MI')
          - TO_DATE(START_JAM_FORCE_MAJOR, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS G,
		( TO_DATE(FINISH_JAM_LAIN_LAIN, 'YYYY-MM-DD HH24:MI')
          - TO_DATE(START_JAM_LAIN_LAIN, 'YYYY-MM-DD HH24:MI')
        ) * (24 * 60)*60
        AS H
		FROM TBL_DETAIL_SENSI WHERE NOMOR_KK = '".$nomorKK."'"
		);
		return $success->result();
	}
}
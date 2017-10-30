<?php
class Master_detail_emboss_model extends Model
{
	public function Master_detail_emboss_model()
	{
		parent::Model();
	}

	function getMaxNumber()
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->select_max('NO_URUT_EMBOSS');
		$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
		return $t->result();
	}

	// function getKodeEmboss($noEmboss){

	// 	$this->oracle_db=$this->load->database('oracle',true);
	// 	$this->oracle_db->where("(NO_URUT_EMBOSS = '$noEmboss')", NULL, FALSE);
	// 	$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
	// 	return $t->result();
	// }

	function getKodeEmboss($noEmboss){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(NO_URUT_EMBOSS = '$noEmboss')", NULL, FALSE);
		$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
		return $t->result();
	}

	function saveLaporanEmboss($data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$success = $this->oracle_db->insert('TBL_DETAIL_EMBOSS', $data);
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

	function countTimeProses($nomorKK){
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
		
		FROM   TBL_DETAIL_EMBOSS

		where NOMOR_KK = '".$nomorKK."'");
		return $success->result();

	}
	function getAllData(){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->order_by('NO_URUT_EMBOSS','asc');
		$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
		return $t->result();
	}

	function getDataBeforeMutation(){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("(STATUS_MUTASI = 'BELUM MUTASI')", NULL, FALSE);
		$this->oracle_db->order_by('NO_URUT_EMBOSS','asc');
		$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
		return $t->result();
	}

	function saveMutasi($id,$data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_URUT_EMBOSS',$id);
		$success = $this->oracle_db->update('TBL_DETAIL_EMBOSS', $data);
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
	function findByRoll($kodeRoll){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where("(KODE_ROLL like '%$kodeRoll%')", NULL, FALSE);
	   	$this->oracle_db->order_by('NO_URUT_EMBOSS','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByRollBeforeMutation($kodeRoll){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('KODE_ROLL', $kodeRoll);
	   	$this->oracle_db->where("(STATUS_MUTASI ='BELUM MUTASI')", NULL, FALSE);
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByDateRange($startDate,$endDate){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('tgl_produksi >=', $startDate);
		$this->oracle_db->where('tgl_produksi <=', $endDate);
	   	$this->oracle_db->order_by('TGL_PRODUKSI','asc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByKK($nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->order_by('TGL_PRODUKSI','asc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByDateRangeAndKK($startDate,$endDate,$nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('tgl_produksi >=', $startDate);
		$this->oracle_db->where('tgl_produksi <=', $endDate);
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->order_by('TGL_PRODUKSI','asc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByDate($date){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('tgl_produksi', $date);
	   	$this->oracle_db->order_by('NO_URUT_EMBOSS','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function laporanPerKK($nomorKK){
		$this->oracle_db=$this->load->database('oracle',true);
		$success = $this->oracle_db->query("
		SELECT TGL_PRODUKSI, MESIN_EMBOSS, NOMOR_KK,SHIFT_EMBOSS, KODE_ROLL, TOTAL_BAHAN, BAIK_METER, RETUR_METER, REJECT_METER, SISA_BAIK,(TO_DATE(FINISH_JAM_PRODUKSI, 'YYYY-MM-DD HH24:MI')
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
		FROM TBL_DETAIL_EMBOSS WHERE NOMOR_KK = '".$nomorKK."' order by tgl_produksi"
		);
		return $success->result();
	}
	function groupByKodeRoll($nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('KODE_ROLL');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->group_by('KODE_ROLL');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByMonth($bulan,$tahun,$mesin){
		$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where("to_char(tgl_produksi,'MM')",$bulan);
    	$this->oracle_db->where("to_char(tgl_produksi,'YYYY')",$tahun);
    	$this->oracle_db->where('MESIN_EMBOSS', $mesin);
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function groupByProductionDate($bulan,$tahun,$mesin)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$success = $this->oracle_db->query("
		SELECT  tgl_produksi, SUM (
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
		
		FROM   TBL_DETAIL_EMBOSS
		WHERE to_char(tgl_produksi,'MM') = '".$bulan."' AND to_char(tgl_produksi,'YYYY') = '".$tahun."'
		AND MESIN_EMBOSS = '".$mesin."' 
		group by tgl_produksi");
		return $success->result();
	}

	function countResultBySeriAndDate($tanggal,$seri,$mesin)
	{

		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, SUM(baik_meter) as hasil, b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI is null AND a.MESIN_EMBOSS = '".$mesin."' 
			group by a.tgl_produksi, b.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, SUM(baik_meter) as hasil, b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI = '".$seri."' AND a.MESIN_EMBOSS = '".$mesin."' 
			group by a.tgl_produksi, b.seri");
			
		}
		return $success->row();
		
	}

	function findById($id){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->where("NO_URUT_EMBOSS", $id);
		$t=$this->oracle_db->get('TBL_DETAIL_EMBOSS');
		return $t->row();
	}

	function updateData($noUrut, $data){
		$this->oracle_db=$this->load->database('oracle',true);
		$this->oracle_db->trans_begin();
		$this->oracle_db->where('NO_URUT_EMBOSS',$noUrut);
		$success = $this->oracle_db->update('TBL_DETAIL_EMBOSS', $data);
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
	function dataMutasi(){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('kode_roll, no_mutasi, sum(total_bahan) as total_bahan');
	   	$this->oracle_db->from('TBL_MUTASI_EMBOSS');
	   	$this->oracle_db->group_by('kode_roll');
		$this->oracle_db->group_by('no_mutasi'); 
		$t=$this->oracle_db->get();
		return $t->result();
	}
}
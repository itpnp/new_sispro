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
		
		FROM   TBL_DETAIL_EMBOSS

		where NOMOR_KK = '".$nomorKK."'");
		return $success->result();

	}
	// function saveLaporanEmboss($data){
		// $this->oracle_db=$this->load->database('oracle',true);
		// $this->oracle_db->trans_begin();
		// $this->oracle_db->set('NO_URUT_EMBOSS',$data['NO_URUT_EMBOSS']);
		// $this->oracle_db->set('KODE_EMBOSS',$data['KODE_EMBOSS']);
		// $this->oracle_db->set('NO_BON_EMBOSS',$data['NO_BON_EMBOSS']);
		// $this->oracle_db->set('KODE_ROLL',$data['KODE_ROLL']);
		// $this->oracle_db->set('TGL_BON_EMBOSS',$data['TGL_BON_EMBOSS']);
		// $this->oracle_db->set('SHIFT_EMBOSS',$data['SHIFT_EMBOSS']);
		// $this->oracle_db->set('BAIK_METER',$data['BAIK_METER']);
		// $this->oracle_db->set('REJECT_METER',$data['REJECT_METER']);
		// $this->oracle_db->set('RETUR_METER',$data['RETUR_METER']);
		// $this->oracle_db->set('NOMOR_KK',$data['NOMOR_KK']);
		// $this->oracle_db->set('TOTAL_BAHAN',$data['TOTAL_BAHAN'] );
		// $this->oracle_db->set('SISA_BAIK',$data['SISA_BAIK']);
		// $this->oracle_db->set('MESIN_EMBOSS',$data['MESIN_EMBOSS']);
		// $this->oracle_db->set('STATUS_MUTASI',$data['STATUS_MUTASI']);
		// $this->oracle_db->set('ID_ROLL',$data['ID_ROLL']);
		// $this->oracle_db->set('TGL_PRODUKSI',$data['TGL_PRODUKSI']);
		// $this->oracle_db->set('KODE_BAHAN_BARU',$data['KODE_BAHAN_BARU']);
		// $this->oracle_db->set('START_JAM_PRODUKSI',"to_date('".$data['START_JAM_PRODUKSI']."','DD-MM-YYYY HH24:MI:SS')",FALSE);
		// $this->oracle_db->set('FINISH_JAM_PRODUKSI',"to_date('".$data['FINISH_JAM_PRODUKSI']."','DD-MM-YYYY HH24:MI:SS')",FALSE);
		// $data['START_JAM_PERSIAPAN'] = $this->input->post('startTimePersiapan');
		// $data['FINISH_JAM_PERSIAPAN'] = $this->input->post('endTimePersiapan');
		// $data['START_JAM_TROUBLE_PRODUKSI'] = $this->input->post('startTimeTroubleProduksi');
		// $data['FINISH_JAM_TROUBLE_PRODUKSI'] = $this->input->post('endTimeTroubleProduksi');
		// $data['START_JAM_TROUBLE_MESIN'] = $this->input->post('startTimeTroubleMesin');
		// $data['FINISH_JAM_TROUBLE_MESIN'] = $this->input->post('endTimeTroubleMesin');
		// $data['START_JAM_TUNGGU_BAHAN'] = $this->input->post('startTimeTungguBahan');
		// $data['FINISH_JAM_TUNGGU_BAHAN'] = $this->input->post('endTimeTungguBahan');
		// $data['START_JAM_TUNGGU_CORE'] = $this->input->post('startTimeTungguCore');
		// $data['FINISH_JAM_TUNGGU_CORE'] = $this->input->post('endTimeTungguCore');
		// $data['START_JAM_FORCE_MAJOR'] = $this->input->post('startTimeForceMajor');
		// $data['FINISH_JAM_FORCE_MAJOR'] = $this->input->post('endTimeForceMajor');
		// $data['START_JAM_GANTI_SILINDER_SERI'] = $this->input->post('startTimeGantiSilinder');
		// $data['FINISH_JAM_GANTI_SILINDER_SERI'] = $this->input->post('endTimeGantiSilinder');
		// $data['START_JAM_LAIN_LAIN'] = $this->input->post('startTimelain');
		// $data['FINISH_JAM_LAIN_LAIN'] = $this->input->post('endTimelain');
		
		// $success = $this->oracle_db->insert('TBL_DETAIL_EMBOSS', $data);
	// 	$success = $this->oracle_db->insert('TBL_DETAIL_EMBOSS');
	// 	$this->oracle_db->trans_commit();
	// 	$this->oracle_db->trans_complete();
	// 		if(!$success){
	// 			$success = false;
	// 			$errNo   = $this->oracle_db->_error_number();
	// 			$errMess = $this->oracle_db->_error_message();
	// 			array_push($errors, array($errNo, $errMess));
	// 		}

	// 	return $success;
	// }

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

	function findByDateRange($startDate,$endDate){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('tgl_produksi >=', $startDate);
		$this->oracle_db->where('tgl_produksi <=', $endDate);
	   	$this->oracle_db->order_by('NO_URUT_EMBOSS','desc');
		$t=$this->oracle_db->get();
		return $t->result();
	}

	function findByKK($nomorKK){
	   	$this->oracle_db=$this->load->database('oracle',true);
	   	$this->oracle_db->select('*');
	   	$this->oracle_db->from('TBL_DETAIL_EMBOSS');
		$this->oracle_db->where('NOMOR_KK', $nomorKK);
	   	$this->oracle_db->order_by('NO_URUT_EMBOSS','desc');
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
	   	$this->oracle_db->order_by('NO_URUT_EMBOSS','desc');
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
		FROM TBL_DETAIL_EMBOSS WHERE NOMOR_KK = '".$nomorKK."'"
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
}
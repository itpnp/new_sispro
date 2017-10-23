<?php
class Master_neraca extends Model
{
	public function Master_neraca()
	{
		parent::Model();
	}

	function embossByProductionMonth($bulan,$tahun)
	{
		$this->oracle_db=$this->load->database('oracle',true);
		$success = $this->oracle_db->query("
		SELECT  tgl_produksi		
		FROM   TBL_DETAIL_EMBOSS
		WHERE to_char(tgl_produksi,'MM') = '".$bulan."' AND to_char(tgl_produksi,'YYYY') = '".$tahun."'
		group by tgl_produksi
		order by tgl_produksi");
		return $success->result();
	}

	// function embossCountResultBySeriAndDate($tanggal,$seri)
	// {

	// 	$this->oracle_db=$this->load->database('oracle',true);

	// 	if($seri == "MMEA"){
	// 		$success = $this->oracle_db->query("
	// 		SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(baik_meter) as hasil, SUM(retur_meter) as waste, SUM(reject_meter) as reject, SUM(selisih_bahan) as selisih,b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
	// 		WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI is null
	// 		group by a.tgl_produksi, a.NOMOR_KK, b.seri");
	// 	}else{
	// 		$success = $this->oracle_db->query("
	// 		SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(baik_meter) as hasil,SUM(retur_meter) as waste, SUM(reject_meter) as reject,SUM(selisih_bahan) as selisih, b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
	// 		WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI = '".$seri."'
	// 		group by a.tgl_produksi, a.NOMOR_KK, b.seri");
			
	// 	}
	// 	return $success->row();
	// }

	function embossCountWasteBySeriAndDate($tanggal,$seri)
	{

		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(baik_meter) as hasil, SUM(retur_meter) as waste, SUM(reject_meter) as reject, SUM(selisih_bahan) as selisih,b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI is null
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(baik_meter) as hasil,SUM(retur_meter) as waste, SUM(reject_meter) as reject,SUM(selisih_bahan) as selisih, b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI = '".$seri."'
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
			
		}
		return $success->row();
	}

	function embossCountResultBySeriAndDate($tanggal,$seri)
	{
		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_EMBOSS a JOIN ( SELECT KODE_ROLL,KODE_BAHAN_BARU FROM TBL_DETAIL_EMBOSS GROUP BY KODE_ROLL, KODE_BAHAN_BARU ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN_BARU 			WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_EMBOSS a JOIN ( SELECT KODE_ROLL,KODE_BAHAN_BARU FROM TBL_DETAIL_EMBOSS GROUP BY KODE_ROLL, KODE_BAHAN_BARU ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN_BARU 			WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI = '".$seri."' GROUP BY  a.tgl_mutasi, c.seri");
			
		}
		return $success->row();
	}

	function demetCountResultBySeriAndDate($tanggal,$seri)
	{
		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_DEMET a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_DEMET GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_DEMET a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_DEMET GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI = '".$seri."' GROUP BY  a.tgl_mutasi, c.seri");
			
		}
		return $success->row();
	}

	function rewindCountResultBySeriAndDate($tanggal,$seri)
	{
		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_REWIND a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_REWIND GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_REWIND a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_REWIND GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI = '".$seri."' GROUP BY  a.tgl_mutasi, c.seri");
			
		}
		return $success->row();
	}

	function sensiCountResultBySeriAndDate($tanggal,$seri)
	{
		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_SENSI a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_SENSI GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_SENSI a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_SENSI GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI = '".$seri."' GROUP BY  a.tgl_mutasi, c.seri");
			
		}
		return $success->row();
	}

	function belahCountResultBySeriAndDate($tanggal,$seri)
	{
		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_BELAH a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_SENSI GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_BELAH a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_SENSI GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE a.TGL_MUTASI = '".$tanggal."' AND c.SERI = '".$seri."' GROUP BY  a.tgl_mutasi, c.seri");
			
		}
		return $success->row();
	}

	function countTotalDebit($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT (SUM(a.baik_meter) + SUM(a.reject_meter) + SUM(a.selisih_bahan)) meter_bon,a.tgl_bon_emboss,a.kode_bahan_baru FROM TBL_DETAIL_EMBOSS a join TBL_MASTER_BAHAN b on a.kode_bahan_baru = b.kode_bahan WHERE b.SERI = '".$seri."' AND a.tgl_bon_emboss < '".$batasAtas."' AND b.AKTIF = '1' AND b.DESAIN = '".$desain."' GROUP BY a.kode_bahan_baru,a.tgl_bon_emboss");
		return $query->row();

	}

	function countTotalKredit($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT (SUM(a.baik_meter) + SUM(a.reject_meter) + SUM(a.selisih_bahan)) meter_produksi,a.tgl_produksi,a.kode_bahan_baru  FROM TBL_DETAIL_EMBOSS a join TBL_MASTER_BAHAN b on a.kode_bahan_baru = b.kode_bahan WHERE b.SERI = '".$seri."' AND a.tgl_produksi< '".$batasAtas."' AND b.AKTIF = '1' AND b.DESAIN = '".$desain."' GROUP BY a.kode_bahan_baru,a.tgl_produksi ORDER BY a.tgl_produksi");

		return $query->row();
	}

	function countTotalDebitDemet($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_DEMET a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_DEMET GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE c.SERI = '".$seri."' AND a.TGL_MUTASI < '".$batasAtas."' AND c.AKTIF = '1' AND c.DESAIN = '".$desain."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		return $query->row();
	}

	function countTotalKreditDemet($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT (SUM(a.baik_meter) + SUM(a.reject_meter) + SUM(a.waste_meter)) meter_produksi,a.tgl_produksi,a.kode_bahan  FROM TBL_DETAIL_DEMET a join TBL_MASTER_BAHAN b on a.kode_bahan = b.kode_bahan WHERE b.SERI = '".$seri."' AND a.tgl_produksi< '".$batasAtas."' AND b.AKTIF = '1' AND b.DESAIN = '".$desain."' GROUP BY a.kode_bahan,a.tgl_produksi ORDER BY a.tgl_produksi");
		return $query->row();
	}

	function countTotalDebitRewind($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_REWIND a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_REWIND GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE c.SERI = '".$seri."' AND a.TGL_MUTASI < '".$batasAtas."' AND c.AKTIF = '1' AND c.DESAIN = '".$desain."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		return $query->row();
	}

	function countTotalKreditRewind($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT (SUM(a.baik_meter) + SUM(a.reject_meter) + SUM(a.waste_meter)) meter_produksi,a.tgl_produksi,a.kode_bahan  FROM TBL_DETAIL_REWIND a join TBL_MASTER_BAHAN b on a.kode_bahan = b.kode_bahan WHERE b.SERI = '".$seri."' AND a.tgl_produksi< '".$batasAtas."' AND b.AKTIF = '1' AND b.DESAIN = '".$desain."' GROUP BY a.kode_bahan,a.tgl_produksi ORDER BY a.tgl_produksi");
		return $query->row();
	}

	function countTotalDebitSensi($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_SENSI a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_SENSI GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE c.SERI = '".$seri."' AND a.TGL_MUTASI < '".$batasAtas."' AND c.AKTIF = '1' AND c.DESAIN = '".$desain."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		return $query->row();
	}

	function countTotalKreditSensi($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT (SUM(a.baik_meter) + SUM(a.reject_meter) + SUM(a.waste_meter)) meter_produksi,a.tgl_produksi,a.kode_bahan  FROM TBL_DETAIL_SENSI a join TBL_MASTER_BAHAN b on a.kode_bahan = b.kode_bahan WHERE b.SERI = '".$seri."' AND a.tgl_produksi< '".$batasAtas."' AND b.AKTIF = '1' AND b.DESAIN = '".$desain."' GROUP BY a.kode_bahan,a.tgl_produksi ORDER BY a.tgl_produksi");
		return $query->row();
	}

	function countTotalDebitBelah($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT a.TGL_MUTASI, SUM(a.TOTAL_BAHAN) as TOTAL_BAHAN, c.SERI from TBL_MUTASI_BELAH a JOIN ( SELECT KODE_ROLL,KODE_BAHAN FROM TBL_DETAIL_BELAH GROUP BY KODE_ROLL, KODE_BAHAN ) b on a.KODE_ROLL = b.KODE_ROLL JOIN TBL_MASTER_BAHAN c on c.KODE_BAHAN = b.KODE_BAHAN	WHERE c.SERI = '".$seri."' AND a.TGL_MUTASI < '".$batasAtas."' AND c.AKTIF = '1' AND c.DESAIN = '".$desain."' AND c.SERI is null GROUP BY  a.tgl_mutasi, c.seri");
		return $query->row();
	}

	function countTotalKreditBelah($batasAtas,$desain,$seri){
		$this->oracle_db=$this->load->database('oracle',true);
		$query = $this->oracle_db->query("SELECT (SUM(a.baik_meter) + SUM(a.reject_meter) + SUM(a.waste_meter)) meter_produksi,a.tgl_produksi,a.kode_bahan  FROM TBL_DETAIL_BELAH a join TBL_MASTER_BAHAN b on a.kode_bahan = b.kode_bahan WHERE b.SERI = '".$seri."' AND a.tgl_produksi< '".$batasAtas."' AND b.AKTIF = '1' AND b.DESAIN = '".$desain."' GROUP BY a.kode_bahan,a.tgl_produksi ORDER BY a.tgl_produksi");
		return $query->row();
	}

	function findBonGudang($tanggalBon, $seri){
		$this->oracle_db=$this->load->database('oracle',true);
		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT  a.TGL_BON_EMBOSS, (SUM(baik_meter) + SUM(reject_meter) + SUM(selisih_bahan) ) as HASIL, b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
			WHERE a.TGL_BON_EMBOSS = '".$tanggalBon."' AND b.SERI is null
			group by a.tgl_bon_emboss, b.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT  a.TGL_BON_EMBOSS, (SUM(baik_meter) + SUM(reject_meter) + SUM(selisih_bahan) ) as HASIL, b.seri from tbl_detail_emboss a join tbl_master_bahan b on a.kode_bahan_baru = b.kode_bahan
			WHERE a.TGL_BON_EMBOSS = '".$tanggalBon."'  AND b.SERI = '".$seri."'
			group by a.tgl_bon_emboss, b.seri");
			
		}
		return $success->row();
	}

	function demetCountWasteBySeriAndDate($tanggal,$seri)
	{

		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject,b.seri from tbl_detail_demet a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI is null
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject, b.seri from tbl_detail_demet a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI = '".$seri."'
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
			
		}
		return $success->row();
	}

	function rewindCountWasteBySeriAndDate($tanggal,$seri)
	{

		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject,b.seri from tbl_detail_rewind a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI is null
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject, b.seri from tbl_detail_rewind a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI = '".$seri."'
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
			
		}
		return $success->row();
	}

	function sensiCountWasteBySeriAndDate($tanggal,$seri)
	{

		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject,b.seri from tbl_detail_sensi a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI is null
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject, b.seri from tbl_detail_sensi a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI = '".$seri."'
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
			
		}
		return $success->row();
	}

	function belahCountWasteBySeriAndDate($tanggal,$seri)
	{

		$this->oracle_db=$this->load->database('oracle',true);

		if($seri == "MMEA"){
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject,b.seri from tbl_detail_belah a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI is null
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
		}else{
			$success = $this->oracle_db->query("
			SELECT a.TGL_PRODUKSI, a.NOMOR_KK, SUM(waste_meter) as waste, SUM(reject_meter) as reject, b.seri from tbl_detail_belah a join tbl_master_bahan b on a.kode_bahan = b.kode_bahan
			WHERE a.TGL_PRODUKSI = '".$tanggal."' AND b.SERI = '".$seri."'
			group by a.tgl_produksi, a.NOMOR_KK, b.seri");
			
		}
		return $success->row();
	}

}
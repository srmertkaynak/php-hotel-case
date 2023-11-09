<?php 
class HotelManagement
{
	private $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	// Hotel ile alakalı CRUD alanları Başlangıç
	public function getAllHotels()
	{
		$query = $this->db->prepare("SELECT * FROM oteller ORDER BY otel_id DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addHotel($otel_adi, $otel_aktif)
	{
		$otel_aktif = $otel_aktif != 1 ? 0 : 1;
		$query = $this->db->prepare("INSERT INTO oteller (otel_adi, otel_aktif) VALUES (:otel_adi, :otel_aktif)");
		$query->bindParam(":otel_adi", $otel_adi);
		$query->bindParam(":otel_aktif", $otel_aktif);
		return $query->execute();
	}

	public function updateHotel($otel_adi, $otel_id)
	{
		$query = $this->db->prepare("UPDATE oteller SET otel_adi = :otel_adi WHERE otel_id = :otel_id");
		$query->bindParam(":otel_id", $otel_id);
		$query->bindParam(":otel_adi", $otel_adi);
		return $query->execute();
	}

	public function deleteHotel($otel_id)
	{
		$query = $this->db->prepare("DELETE FROM oteller WHERE otel_id = :otel_id");
		$query->bindParam(":otel_id", $otel_id);
		return $query->execute();
	}

	public function updateHotelStatus($otel_id, $status)
	{
		$query = $this->db->prepare("UPDATE oteller SET otel_aktif = :otel_aktif WHERE otel_id = :otel_id ");
		$query->bindParam(":otel_aktif", $status);
		$query->bindParam(":otel_id", $otel_id);
		return $query->execute();
	}
	// Hotel ile alakalı CRUD alanları Bitiş

	// Oda ile alakalı CRUD alanları Başlangıç
	public function getHotelRooms($otel_id)
	{
		$query = $this->db->prepare("SELECT * FROM otel_oda_tanim WHERE otel_id = :otel_id ORDER BY oda_id DESC");
		$query->bindParam(":otel_id", $otel_id);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addHotelRoom($otel_id, $oda_adi, $oda_aktif, $satis_durum, $sil_durum)
	{
		$query = $this->db->prepare("INSERT INTO otel_oda_tanim (otel_id, oda_adi, oda_aktif, satis_durum, sil_durum) VALUES (:otel_id, :oda_adi, :oda_aktif, :satis_durum, :sil_durum)");
		$query->bindParam(":otel_id", $otel_id);
		$query->bindParam(":oda_adi", $oda_adi);
		$query->bindParam(":oda_aktif", $oda_aktif);
		$query->bindParam(":satis_durum", $satis_durum);
		$query->bindParam(":sil_durum", $sil_durum);
		return $query->execute();
	}

	public function updateHotelRoom($oda_adi, $oda_id)
	{
		$query = $this->db->prepare("UPDATE otel_oda_tanim SET oda_adi = :oda_adi WHERE oda_id = :oda_id");
		$query->bindParam(":oda_adi", $oda_adi);
		$query->bindParam(":oda_id", $oda_id);
		return $query->execute();
	}

	public function updateHotelRoomStatus($oda_id, $type, $status)
	{
		$query = $this->db->prepare("UPDATE otel_oda_tanim SET $type = :type WHERE oda_id = :oda_id ");
		$query->bindParam(":type", $status);
		$query->bindParam(":oda_id", $oda_id);
		return $query->execute();
	}
	// Oda ile alakalı CRUD alanları Bitiş

	// Oda özellik ile alakalı CRUD alanları Başlangıç
	public function getHotelRoomFeatures($oda_id)
	{
		$query = $this->db->prepare("SELECT * 
			FROM otel_oda_ozellik
			INNER JOIN oda_ozellik_tanim ON otel_oda_ozellik.ozellik_id = oda_ozellik_tanim.ozellik_id
			WHERE oda_id = :oda_id
			ORDER BY otel_oda_ozellik.ozellik_id DESC");
		$query->bindParam(":oda_id", $oda_id);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addHotelRoomFeature($otel_id, $oda_id, $ozellik_adi)
	{
		$query = $this->db->prepare("INSERT INTO oda_ozellik_tanim (ozellik_adi) VALUES (:ozellik_adi)");
		$query->bindParam(":ozellik_adi", $ozellik_adi);
		$query->execute();

		$son_eklenen_id = $this->db->lastInsertId();
		$this->addOdaOzellikTanim($otel_id, $oda_id, $son_eklenen_id);

		return "ok";
	}

	public function addOdaOzellikTanim($otel_id, $oda_id, $ozellik_id)
	{
		$query2 = $this->db->prepare("INSERT INTO otel_oda_ozellik (otel_id, oda_id, ozellik_id) VALUES (:otel_id, :oda_id, :ozellik_id)");
		$query2->bindParam(":otel_id", $otel_id);
		$query2->bindParam(":oda_id", $oda_id);
		$query2->bindParam(":ozellik_id", $ozellik_id);
		return $query2->execute();
	}

	public function updateHotelRoomFeature($ozellik_adi, $ozellik_id)
	{
		$query = $this->db->prepare("UPDATE oda_ozellik_tanim SET ozellik_adi = :ozellik_adi WHERE ozellik_id = :ozellik_id");
		$query->bindParam(":ozellik_adi", $oda_adi);
		$query->bindParam(":ozellik_id", $ozellik_id);
		return $query->execute();
	}
	// Oda özellik ile alakalı CRUD alanları Bitiş

	// Özelliksiz Odalar Başlangıç
	public function getHotelWithoutFeature()
	{
		$query = $this->db->prepare("SELECT oteller.otel_adi, otel_oda_tanim.oda_adi
			FROM oteller
			LEFT JOIN otel_oda_tanim ON oteller.otel_id = otel_oda_tanim.otel_id
			WHERE oteller.otel_id NOT IN (SELECT otel_id FROM otel_oda_ozellik)
			ORDER BY oteller.otel_id DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	// Özelliksiz Odalar Bitiş

	// Özellikli Odalar Başlangıç
	public function getHotelWithFeature()
	{
		$query = $this->db->prepare("SELECT oteller.otel_adi, otel_oda_tanim.oda_adi, oda_ozellik_tanim.ozellik_adi
			FROM oteller
			INNER JOIN otel_oda_tanim ON oteller.otel_id = otel_oda_tanim.otel_id
			INNER JOIN otel_oda_ozellik ON oteller.otel_id = otel_oda_ozellik.otel_id AND otel_oda_tanim.oda_id = otel_oda_ozellik.oda_id 
			INNER JOIN oda_ozellik_tanim ON otel_oda_ozellik.ozellik_id = oda_ozellik_tanim.ozellik_id
			WHERE oteller.otel_id = otel_oda_ozellik.otel_id AND oteller.otel_aktif = '1' AND otel_oda_tanim.satis_durum = '0' AND otel_oda_tanim.sil_durum = '0' AND otel_oda_tanim.oda_aktif = '1'
			ORDER BY oteller.otel_id DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	// Özellikli Odalar Bitiş
}

$host = "localhost";
$db_name = "mertkayn_hotelcase";
$db_user = "mertkayn_hotelcase";
$db_pass = "e2cea84ca99ea3040f79da846117943f793fbabd";

try{

	$db = new PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8",$db_user,$db_pass);


}catch(PDOException $e) {

	die($e->getMessage());

}

$hotelManagement = new HotelManagement($db);

?>
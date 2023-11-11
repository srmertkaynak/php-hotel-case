<?php 
class HotelManagement
{
	private $db;

	public function __construct($host, $username, $password, $database)
	{
		try {
			$this->db = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("Veritabanına bağlanılamadı: " . $e->getMessage());
		}
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

	public function addHotelRoom($otel_id, $oda_adi, $ozellikler, $oda_aktif, $satis_durum, $sil_durum)
	{
		$query = $this->db->prepare("INSERT INTO otel_oda_tanim (otel_id, oda_adi, oda_aktif, satis_durum, sil_durum) VALUES (:otel_id, :oda_adi, :oda_aktif, :satis_durum, :sil_durum)");
		$query->bindParam(":otel_id", $otel_id);
		$query->bindParam(":oda_adi", $oda_adi);
		$query->bindParam(":oda_aktif", $oda_aktif);
		$query->bindParam(":satis_durum", $satis_durum);
		$query->bindParam(":sil_durum", $sil_durum);

		$query->execute();
		if (isset($ozellikler)) {
			$son_eklenen_oda_id = $this->db->lastInsertId();
			$this->addPivotTable($otel_id, $son_eklenen_oda_id, $ozellikler);
		}

		return "ok";
	}

	public function addPivotTable($otel_id, $son_eklenen_oda_id, $ozellikler)
	{
		foreach ($ozellikler as $fieldId) {
			$query2 = $this->db->prepare("INSERT INTO otel_oda_ozellik (otel_id, oda_id, ozellik_id) VALUES (:otel_id, :oda_id, :ozellik_id)");
			$query2->bindParam(':otel_id', $otel_id);
			$query2->bindParam(':oda_id', $son_eklenen_oda_id);
			$query2->bindParam(':ozellik_id', $fieldId);
			$query2->execute();
		}
		return "kayıtlar eklendi";
	}

	public function updateHotelRoom($oda_adi, $oda_id, $ozellikler)
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
	public function showCheckboxes()
	{
		$query = $this->db->prepare("SELECT * FROM oda_ozellik_tanim");
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			echo '<div class="col-lg-4"><div class="form-check form-check-flat form-check-primary"><label class="form-check-label"><input type="checkbox" name="ozellikler[]" value="' . $row['ozellik_id'] . '" class="form-check-input">' . $row['ozellik_adi'] . ' <i class="input-helper"></i></label></div></div>';
		}
	}

	public function showSelectedCheckboxes($ozellikler)
	{
            // Veritabanındaki seçilmiş alanları seç
		$selectedQuery = "SELECT fieldId FROM your_selected_fields_table";
		$selectedStmt = $this->db->query($selectedQuery);

            // Seçilmiş checkboxları ekrana bas
		$selectedCheckboxIds = [];
		while ($selectedRow = $selectedStmt->fetch(PDO::FETCH_ASSOC)) {
			$selectedCheckboxIds[] = $selectedRow['fieldId'];
		}

		$query = "SELECT id, fieldName FROM your_table_name";
		$stmt = $this->db->query($query);

            // Checkboxları ekrana bas ve seçili olanları checked yap
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$checked = in_array($row['ozellik_id'], $selectedCheckboxIds) ? 'checked' : '';
			echo '<input type="checkbox" name="ozellikler[]" value="' . $row['ozellik_id'] . '" ' . $checked . '>' . $row['ozellik_adi'] . '<br>';
		}
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
			WHERE oteller.otel_id = otel_oda_ozellik.otel_id AND oteller.otel_aktif = '1' AND otel_oda_tanim.satis_durum = '1' AND otel_oda_tanim.sil_durum = '0' AND otel_oda_tanim.oda_aktif = '1'
			ORDER BY oteller.otel_id DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	// Özellikli Odalar Bitiş

	public function __destruct()
	{
		$this->db = null;
	}
}

$hotelManagement = new HotelManagement("localhost", "mertkayn_hotelcase", "e2cea84ca99ea3040f79da846117943f793fbabd", "mertkayn_hotelcase");

?>
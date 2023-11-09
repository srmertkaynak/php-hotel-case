<?php
include "hotelmanagement.php";

$rooms = $hotelManagement->getHotelRoomFeatures($_GET['oda_id']);

if(isset($_POST['odaOzellikEkle'])){
  $otel_id = htmlspecialchars($_GET['otel_id']);
  $oda_id = htmlspecialchars($_GET['oda_id']);
  $ozellik_adi = htmlspecialchars($_POST['ozellik_adi']);

  if ($hotelManagement->addHotelRoomFeature($otel_id, $oda_id, $ozellik_adi)) {
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }else{
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }
}

if(isset($_POST['odaOzellikDuzenle'])){
  $ozellik_adi = htmlspecialchars($_POST['ozellik_adi']);
  $ozellik_id = htmlspecialchars($_POST['ozellik_id']);

  if ($hotelManagement->updateHotelRoom($ozellik_adi, $ozellik_id)) {
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }else{
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <title>Özellikler</title>

  <?php include "inc/header.php" ?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="card-title">Özellikler</h4>
                  <p class="card-description">
                    Tüm özellik kayıtları burada görüntülenmektedir.
                  </p>
                </div>
                <div class="mb-3">
                  <a href="odalar.php?otel_id=<?php echo $_GET['otel_id'] ?>" class="btn btn-outline-secondary btn-fw">Geri Dön</a>
                  <button type="button" data-toggle="modal" data-target="#odaOzellikEkle" class="btn btn-outline-primary btn-fw">Yeni Özellik Ekle</button>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table" id="listeTablo">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Özellik Adı</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($rooms as $room) { ?>
                      <tr>
                        <td><?php echo $room['ozellik_id'] ?></td>
                        <td><?php echo $room['ozellik_adi'] ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->

    <?php include "inc/footer.php" ?>

    <!-- Yeni Oda Özellik Ekle -->
    <div class="modal fade" id="odaOzellikEkle" tabindex="-1" role="dialog" aria-labelledby="odaOzellikEkleTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Yeni Özellik Ekle</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="POST">
                <div class="form-group">
                  <label for="exampleInputUsername1">Özellik Adı</label>
                  <input type="text" class="form-control" name="ozellik_adi" id="exampleInputUsername1" placeholder="Özellik Adı">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
              <button type="submit" name="odaOzellikEkle" class="btn btn-primary">Ekle</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Oda Özellik Düzenle -->
    <?php foreach ($rooms as $room) { ?>
      <div class="modal fade" id="odaOzellikDuzenle<?php echo $room['ozellik_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="odaOzellikDuzenleTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Özellik Düzenle</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card">
              <div class="card-body">
                <form class="forms-sample" method="POST">
                  <div class="form-group">
                    <label for="exampleInputUsername1">Özellik Adı</label>
                    <input type="text" class="form-control" name="ozellik_adi" value="<?php echo $room['ozellik_adi'] ?>" id="exampleInputUsername1" placeholder="Oda Adı">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="ozellik_id" value="<?php echo $room['ozellik_id'] ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="submit" name="odaOzellikDuzenle" class="btn btn-primary">Kaydet</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
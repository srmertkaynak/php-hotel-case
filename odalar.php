<?php include "hotelmanagement.php";

$rooms = $hotelManagement->getHotelRooms($_GET['otel_id']);

if(isset($_POST['odaEkle'])){
  $otel_id = htmlspecialchars($_GET['otel_id']);
  $oda_adi = htmlspecialchars($_POST['oda_adi']);

  if($_POST['oda_aktif'] == ""){
    $oda_aktif = '0';
  }else{
    $oda_aktif = '1';
  }

  if($_POST['satis_durum'] == ""){
    $satis_durum = '0';
  }else{
    $satis_durum = '1';
  }

  if($_POST['sil_durum'] == ""){
    $sil_durum = '0';
  }else{
    $sil_durum = '1';
  }

  if ($hotelManagement->addHotelRoom($otel_id, $oda_adi, $oda_aktif, $satis_durum, $sil_durum)) {
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }else{
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }
}

if(isset($_POST['odaDuzenle'])){
  $oda_adi = htmlspecialchars($_POST['oda_adi']);
  $oda_id = htmlspecialchars($_POST['oda_id']);

  if ($hotelManagement->updateHotelRoom($oda_adi, $oda_id)) {
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }else{
    header('location: '.$_SERVER['REQUEST_URI']);
    exit;
  }
}

if(isset($_POST['updateHotelRoomStatus'])){
  $oda_id = htmlspecialchars($_POST['oda_id']);
  $type = htmlspecialchars($_POST['type']);
  $status = htmlspecialchars($_POST['status']);

  if ($hotelManagement->updateHotelRoomStatus($oda_id, $type, $status)) {
    echo "basarili";
    exit;
  }else{
    echo "basarisiz";
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <title>Odalar</title>

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
                  <h4 class="card-title">Odalar</h4>
                  <p class="card-description">
                    Tüm oda kayıtları burada görüntülenmektedir.
                  </p>
                </div>
                <div class="mb-3">
                  <a href="index.php" class="btn btn-outline-secondary btn-fw">Geri Dön</a>
                  <button type="button" data-toggle="modal" data-target="#odaEkle" class="btn btn-outline-primary btn-fw">Yeni Oda Ekle</button>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table" id="listeTablo">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Oda Adı</th>
                      <th>Durum</th>
                      <th>Satış Durumu</th>
                      <th>Silme Durumu</th>
                      <th>İşlem</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($rooms as $room) { ?>
                      <tr>
                        <td><?php echo $room['oda_id'] ?></td>
                        <td><?php echo $room['oda_adi'] ?></td>
                        <td>
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input aktiflik" data-id="oda_aktif" data-field="<?php echo $room['oda_id'] ?>" id="durum<?php echo $room['oda_id'] ?>" <?php echo $room['oda_aktif'] == 1 ? "checked" : "" ?>>
                            <label class="custom-control-label" for="durum<?php echo $room['oda_id'] ?>"></label>
                          </div>
                        </td>
                        <td>
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input aktiflik" data-id="satis_durum" data-field="<?php echo $room['oda_id'] ?>" id="satis<?php echo $room['oda_id'] ?>" <?php echo $room['satis_durum'] == 1 ? "checked" : "" ?>>
                            <label class="custom-control-label" for="satis<?php echo $room['oda_id'] ?>"></label>
                          </div>
                        </td>
                        <td>
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input aktiflik" data-id="sil_durum" data-field="<?php echo $room['oda_id'] ?>" id="silme<?php echo $room['oda_id'] ?>" <?php echo $room['sil_durum'] == 1 ? "checked" : "" ?>>
                            <label class="custom-control-label" for="silme<?php echo $room['oda_id'] ?>"></label>
                          </div>
                        </td>
                        <td>
                          <a href="oda-ozellikleri.php?otel_id=<?php echo $room['otel_id'] ?>&oda_id=<?php echo $room['oda_id'] ?>" class="btn btn-primary btn-icon-text otelAktiflik">
                            <i class="ti-file btn-icon-prepend"></i>
                            Özellikler
                          </a>
                          <button type="button" data-toggle="modal" data-target="#odaDuzenle<?php echo $room['oda_id'] ?>" class="btn btn-dark btn-icon-text">
                            <i class="ti-pencil btn-icon-append pr-1"></i>        
                            Düzenle                  
                          </button>
                        </td>
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

    <!-- Yeni Oda Ekle -->
    <div class="modal fade" id="odaEkle" tabindex="-1" role="dialog" aria-labelledby="odaEkleTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Yeni Oda Ekle</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="POST">
                <div class="form-group">
                  <label for="exampleInputUsername1">Oda Adı</label>
                  <input type="text" class="form-control" name="oda_adi" id="exampleInputUsername1" placeholder="Oda Adı">
                </div>
                <label>Durum</label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="switchDurum" value="1" name="oda_aktif">
                  <label class="custom-control-label" for="switchDurum"></label>
                </div>

                <label>Satış Durum</label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="switchSatis" value="1" name="satis_durum">
                  <label class="custom-control-label" for="switchSatis"></label>
                </div>

                <label>Sil Durum</label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="switchIptal" value="1" name="sil_durum">
                  <label class="custom-control-label" for="switchIptal"></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
              <button type="submit" name="odaEkle" class="btn btn-primary">Ekle</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Oda Düzenle -->
    <?php foreach ($rooms as $room) { ?>
      <div class="modal fade" id="odaDuzenle<?php echo $room['oda_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="odaDuzenleTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Oda Düzenle</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card">
              <div class="card-body">
                <form class="forms-sample" method="POST">
                  <div class="form-group">
                    <label for="exampleInputUsername1">Oda Adı</label>
                    <input type="text" class="form-control" name="oda_adi" value="<?php echo $room['oda_adi'] ?>" id="exampleInputUsername1" placeholder="Oda Adı">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="oda_id" value="<?php echo $room['oda_id'] ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="submit" name="odaDuzenle" class="btn btn-primary">Kaydet</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
      $(document).ready(function() {

        $("#listeTablo").on("click", ".aktiflik", function(){

          var oda_id = $(this).attr("data-field");
          var type = $(this).attr("data-id");
          var status = $(this).is(":checked") ? '1' : '0';
          var updateHotelRoomStatus = "guncelle";

          $.ajax({
            type: "POST",
            url: "odalar.php",
            data: {oda_id:oda_id,type:type,status:status,updateHotelRoomStatus:updateHotelRoomStatus},
            success: function(x) {
              console.log(x);
              if (x == 'basarili') {
                Swal.fire({
                  icon: 'success',
                  title: 'Kayıt Güncellendi!',
                  text: 'Kaydınız başarıyla güncellendi.',
                  confirmButtonColor: '#232A30',
                  confirmButtonText: 'Tamam'
                });
              } else {
                Swal.fire({
                  icon: 'warning',
                  title: "Bir Hata Oluştu!",
                  text: 'Kaydınızı güncellerken bir hata oluştu. Tekrar deneyiniz.',
                  confirmButtonColor: '#232A30',
                  confirmButtonText: 'Tamam'
                });
              }
            }

          });

        });

      });
    </script>
<?php include "hotelmanagement.php";

$hotels = $hotelManagement->getAllHotels();

if(isset($_POST['otelEkle'])){
  $otel_adi = htmlspecialchars($_POST['otel_adi']);
  $otel_aktif = htmlspecialchars($_POST['otel_aktif']);

  if ($hotelManagement->addHotel($otel_adi, $otel_aktif)) {
    header('location: index.php');
    exit;
  }else{
    header('location: index.php');
    exit;
  }
}

if(isset($_POST['otelDuzenle'])){
  $otel_adi = htmlspecialchars($_POST['otel_adi']);
  $otel_id = htmlspecialchars($_POST['otel_id']);

  if ($hotelManagement->updateHotel($otel_adi, $otel_id)) {
    header('location: index.php');
    exit;
  }else{
    header('location: index.php');
    exit;
  }
}

if(isset($_POST['otelSil'])){
  $otel_id = htmlspecialchars($_POST['otel_id']);

  if ($hotelManagement->deleteHotel($otel_id)) {
    echo "basarili";
    exit;
  }else{
    echo "basarisiz";
    exit;
  }
}

if(isset($_POST['updateHotelStatus'])){
  $otel_id = htmlspecialchars($_POST['otel_id']);
  $status = htmlspecialchars($_POST['status']);

  if ($hotelManagement->updateHotelStatus($otel_id, $status)) {
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
  <title>Dashboard</title>

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
                  <h4 class="card-title">Oteller</h4>
                  <p class="card-description">
                    Tüm otel kayıtları burada görüntülenmektedir.
                  </p>
                </div>
                <div class="mb-3">
                  <button type="button" data-toggle="modal" data-target="#otelekle" class="btn btn-outline-primary btn-fw">Yeni Otel Ekle</button>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table" id="listeTablo">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Otel Adı</th>
                      <th>Durum</th>
                      <th>İşlem</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($hotels as $hotel) { ?>
                      <tr>
                        <td><?php echo $hotel['otel_id'] ?></td>
                        <td><?php echo $hotel['otel_adi'] ?></td>
                        <td>
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input aktiflik" id="<?php echo $hotel['otel_id'] ?>" <?php echo $hotel['otel_aktif'] == 1 ? "checked" : "" ?>>
                            <label class="custom-control-label" for="<?php echo $hotel['otel_id'] ?>"></label>
                          </div>
                        </td>
                        <td>
                          <a href="odalar.php?otel_id=<?php echo $hotel['otel_id'] ?>" class="btn btn-primary btn-icon-text otelAktiflik">
                            <i class="ti-file btn-icon-prepend"></i>
                            Odalar
                          </a>
                          <button type="button" data-toggle="modal" data-target="#otelduzenle<?php echo $hotel['otel_id'] ?>" class="btn btn-dark btn-icon-text">
                            <i class="ti-pencil btn-icon-append pr-1"></i>        
                            Düzenle                  
                          </button>
                          <button type="button" data-id="<?php echo $hotel['otel_id'] ?>" class="btn btn-danger btn-icon-text otelSil">
                            <i class="ti-trash btn-icon-prepend"></i>                                                    
                            Sil
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

    <!-- Yeni Otel Ekle -->
    <div class="modal fade" id="otelekle" tabindex="-1" role="dialog" aria-labelledby="otelekleTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Yeni Otel Ekle</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="POST">
                <div class="form-group">
                  <label for="exampleInputUsername1">Otel Adı</label>
                  <input type="text" class="form-control" name="otel_adi" id="exampleInputUsername1" placeholder="Otel Adı">
                </div>
                <label>Durum</label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="switchEkle" value="1" name="otel_aktif" checked>
                  <label class="custom-control-label" for="switchEkle"></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
              <button type="submit" name="otelEkle" class="btn btn-primary">Ekle</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Otel Düzenle -->
    <?php foreach ($hotels as $hotel) { ?>
      <div class="modal fade" id="otelduzenle<?php echo $hotel['otel_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="otelduzenleTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Otel Düzenle</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card">
              <div class="card-body">
                <form class="forms-sample" method="POST">
                  <div class="form-group">
                    <label for="exampleInputUsername1">Otel Adı</label>
                    <input type="text" class="form-control" name="otel_adi" value="<?php echo $hotel['otel_adi'] ?>" id="exampleInputUsername1" placeholder="Otel Adı">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="otel_id" value="<?php echo $hotel['otel_id'] ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="submit" name="otelDuzenle" class="btn btn-primary">Kaydet</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $(".otelSil").on("click", function() {

        var idAl = $(this).attr("data-id");

        Swal.fire({
          title: 'Emin misiniz?',
          text: "Kaydınız silinecektir. Emin misiniz?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#232A30',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Evet',
          cancelButtonText: 'Hayır'
        }).then((result) => {

          if (result.isConfirmed) {

            var serializedData = {
              "otel_id": idAl,
              "otelSil": "var"
            };

            $.ajax({
              type: "POST",
              url: "index.php",
              data: serializedData,
              success: function(x) {
                if (x == 'basarili') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Kayıt Silindi!',
                    text: 'Kaydınız başarıyla sistemden kaldırıldı.',
                    confirmButtonColor: '#232A30',
                    confirmButtonText: 'Tamam'
                  }).then(() => {
                    window.location.href = "index.php";
                  });
                } else {
                  Swal.fire({
                    icon: 'warning',
                    title: "Bir Hata Oluştu!",
                    text: 'Kaydınızı silerken bir hata oluştu. Tekrar deneyiniz.',
                    confirmButtonColor: '#232A30',
                    confirmButtonText: 'Tamam'
                  });
                }
              }
            });

          }
        })

      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {

        $("#listeTablo").on("click", ".aktiflik", function(){

          var otel_id = $(this).attr("id");
          var status = $(this).is(":checked") ? '1' : '0';
          var updateHotelStatus = "guncelle";

          $.ajax({
            type: "POST",
            url: "index.php",
            data: {otel_id:otel_id,status:status,updateHotelStatus:updateHotelStatus},
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
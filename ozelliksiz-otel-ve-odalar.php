<?php
include "hotelmanagement.php";

$hotels = $hotelManagement->getHotelWithoutFeature();

?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <title>Özelliksiz Otel ve Odalar</title>

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
                  <h4 class="card-title">Özelliksiz Otel ve Odalar</h4>
                  <p class="card-description">
                    Tüm özelliksiz otel ve oda kayıtları burada görüntülenmektedir.
                  </p>
                </div>
              </div>
              <div class="row">
                <?php

                $groupedHotels = array();

                foreach ($hotels as $row) {
                  $otelAdi = $row['otel_adi'];
                  $odaAdi = $row['oda_adi'];

                  if (!isset($groupedHotels[$otelAdi])) {
                    $groupedHotels[$otelAdi] = array();
                  }

                  $groupedHotels[$otelAdi][] = $odaAdi;
                }

                foreach ($groupedHotels as $otelAdi => $odalar) { 
                  ?>
                  <div class="col-lg-3">
                    <div class="card" style="width: 18rem; border: 1px solid #c1c1c1;">
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $otelAdi ?></h5>
                      </div>
                      <ul class="list-group list-group-flush">
                        <?php foreach($odalar as $odalaritem){ ?>
                          <li class="list-group-item"><?php echo $odalaritem ?></li>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->

    <?php include "inc/footer.php" ?>
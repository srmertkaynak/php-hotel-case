<?php
include "hotelmanagement.php";

$hotels = $hotelManagement->getHotelWithFeature();

?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <title>Özellikli Otel ve Odalar</title>

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
                  <h4 class="card-title">Özellikli Otel ve Odalar</h4>
                  <p class="card-description">
                    Tüm özellikli otel ve oda kayıtları burada görüntülenmektedir.
                  </p>
                </div>
              </div>
              <div class="row">
                <?php

                $groupedHotels = array();

                foreach ($hotels as $row) {
                  $otelAdi = $row['otel_adi'];
                  $odaAdi = $row['oda_adi'];
                  $ozellikAdi = $row['ozellik_adi'];

                  if (!isset($groupedHotels[$otelAdi][$odaAdi])) {
                    $groupedHotels[$otelAdi][$odaAdi] = array();
                  }

                  $groupedHotels[$otelAdi][$odaAdi][] = $ozellikAdi;
                }

                foreach ($groupedHotels as $otelAdi => $odalar) { 
                  ?>
                  <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card" style="border: 1px solid #c1c1c1;">
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $otelAdi ?></h5>
                      </div>
                      <ul class="list-group list-group-flush">
                        <?php foreach($odalar as $odaAdi => $ozellikler){ ?>
                          <li class="list-group-item" style="font-size: 14px;"><mark class="bg-success text-white p-1"><?php echo $odaAdi ?></mark>
                          <ul class="list-group list-group-flush">
                            <?php foreach($ozellikler as $odalarozellikitem){ ?>
                              <li class="list-group-item"><i class="ti-check-box mr-1"></i> <?php echo $odalarozellikitem ?></li>
                            <?php } ?>
                          </ul>
                        </li>
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
<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('home/navbar') ?>
    <div class="content-wrapper p-4 text-navy">
      <div class="card my-3">
        <div class="row gutter-0">
          <div class="col-lg-4 p-4 d-flex flex-column justify-content-center">
            <h3>Penjualan Neto</h3>
            <p>2019 - 2023</p>
          </div>
          <div class="col-lg-8 d-none d-lg-block">
            <canvas id="penjualanNeto"></canvas>
          </div>
        </div>
      </div>
      <div class="card my-3">
        <div class="row gutter-0">
          <div class="col-lg-4 p-4 d-flex flex-column justify-content-center">
            <h3>Laba Tahun Berjalan</h3>
            <p>2019 - 2023</p>
          </div>
          <div class="col-lg-8 d-none d-lg-block">
            <canvas id="labaTahunBerjalan"></canvas>
          </div>
        </div>
      </div>
      <div class="card my-3">
        <div class="row gutter-0">
          <div class="col-lg-4 p-4 d-flex flex-column justify-content-center">
            <h3>Total Aset</h3>
            <p>2019 - 2023</p>
          </div>
          <div class="col-lg-8 d-none d-lg-block">
            <canvas id="totalAset"></canvas>
          </div>
        </div>
      </div>
      <div class="card my-3">
        <div class="row gutter-0">
          <div class="col-lg-4 p-4 d-flex flex-column justify-content-center">
            <h3>Hasil Dividen</h3>
            <p>2019 - 2023</p>
          </div>
          <div class="col-lg-8 d-none d-lg-block">
            <canvas id="hasilDividen"></canvas>
          </div>
        </div>
      </div>
      <div class="card mb-3">
      </div>
    </div>
  </div>
  <?= view('shared/chartjs') ?>
</body>

</html>
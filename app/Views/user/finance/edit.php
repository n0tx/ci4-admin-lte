<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('user/navbar') ?>
    <?php /** @var \App\Entities\FinancialPerformance $item */ ?>
    <div class="content-wrapper p-4">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <form method="post">
              <div class="d-flex mb-3">
                <h1 class="h3 mb-0 mr-auto">Edit Financial Performance</h1>
                <a href="/user/finance/" class="btn btn-outline-secondary ml-2">Back</a>
              </div>
              <label class="d-block mb-3">
                <span>Penjualan Neto</span>
                <input type="text" class="form-control" name="penjualan_neto" value="<?= esc($item->penjualan_neto) ?>" required>
              </label>
              <label class="d-block mb-3">
                <span>Laba Tahun Berjalan</span>
                <input type="text" class="form-control" name="laba_tahun_berjalan" value="<?= esc($item->laba_tahun_berjalan) ?>" required>
              </label>
              <label class="d-block mb-3">
                <span>Total Aset</span>
                <input type="text" class="form-control" name="total_aset" value="<?= esc($item->total_aset) ?>" required>
              </label>
              <label class="d-block mb-3">
                <span>Hasil Dividen</span>
                <input type="text" class="form-control" name="hasil_dividen" value="<?= esc($item->hasil_dividen) ?>" required>
              </label>
              <label class="d-block mb-3">
                <span>Tahun</span>
                <input type="text" class="form-control" name="tahun" value="<?= esc($item->tahun) ?>" required>
              </label>
              <div class="d-flex mb-3">
                <input type="submit" value="Save" class="btn btn-primary mr-auto">
                <?php if ($item->id) : ?>
                  <label for="delete-form" class="btn btn-danger mb-0"><i class="fa fa-trash"></i></label>
                <?php endif ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="/user/finance/delete/<?= $item->id ?>">
    <input type="submit" hidden id="delete-form" onclick="return confirm('Do you want to delete this finance data permanently?')">
  </form>
</body>

</html>
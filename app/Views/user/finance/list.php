<!DOCTYPE html>
<html lang="en">

<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('user/navbar') ?>
    <div class="content-wrapper p-4">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <?php /** @var \App\Entities\FinancialPerformance[] $data */ ?>
            <div class="d-flex">
              <div class="ml-left">
                <?= view('shared/button', [
                  'actions' => ['generate_pdf'],
                  'target' => '',
                  'size' => 'btn-lg'
                ]); ?>
              </div>
              <div class="ml-auto">
                <?= view('shared/button', [
                  'actions' => ['add'],
                  'target' => '',
                  'size' => 'btn-lg'
                ]); ?>
                
              </div>
            </div>
            <?= view('shared/table', [
              'data' => $data,
              'columns' => [
                'Penjualan Neto' => function (\App\Entities\FinancialPerformance $x) {
                  return $x->penjualan_neto;
                },
                'Laba Tahun Berjalan' => function (\App\Entities\FinancialPerformance $x) {
                  return $x->laba_tahun_berjalan;
                },
                'Total Aset' => function (\App\Entities\FinancialPerformance $x) {
                  return $x->total_aset;
                },
                'Hasil Dividen' => function (\App\Entities\FinancialPerformance $x) {
                  return $x->hasil_dividen;
                },
               'Tahun' => function (\App\Entities\FinancialPerformance $x) {
                  return $x->tahun;
                },
                'Edit' => function (\App\Entities\FinancialPerformance $x) {
                  return view('shared/button', [
                    'actions' => ['edit'],
                    'target' => $x->id,
                    'size' => 'btn-sm'
                  ]);
                }
              ]
            ]) ?>
            <?= view('shared/pagination') ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<?= view('shared/head_pdf') ?>
<body>
        <?= view('shared/chart_pdf', ['image_urls' => $image_urls]) ?>
        <?= view('shared/table_pdf', [
          'data' => $financial_performance,
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
            }
          ]
        ]) ?>
</body>

</html>
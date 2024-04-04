<script>   
    const ctxDynamicJs = document.getElementById('myChartDynamicJs');
    
    <?= $test = json_encode(get_financial_performance()); ?>

    let kinerja_keuangan = <?= $test ?>

    let tahun = collect(kinerja_keuangan).map(function(item) {
        return item.tahun
    }).all()

    let penjualan_neto = collect(kinerja_keuangan).map(function(item) {
        return item.penjualan_neto
    }).all()

    new Chart(ctxDynamicJs, {
        type: 'bar',
        data: {
            labels: tahun,
            datasets: [{
                label: '# Penjualan Neto',
                data: penjualan_neto,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
        					'rgba(54, 162, 235, 0.2)',
        					'rgba(255, 206, 86, 0.2)',
        					'rgba(75, 192, 192, 0.2)',
        					'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
					        'rgba(255,99,132,1)',
        					'rgba(54, 162, 235, 1)',
        					'rgba(255, 206, 86, 1)',
        					'rgba(75, 192, 192, 1)',
        					'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
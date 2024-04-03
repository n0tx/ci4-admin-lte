<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
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

    const ctxDynamic = document.getElementById('myChartDynamic');

    new Chart(ctxDynamic, {
        type: 'bar',
        data: {
            labels: ['Page', 'Info', 'News'],
            datasets: [{
                label: '# Number Of Categories',
                data: [
                    <?=find_count_rows('page')?>,
                    <?=find_count_rows('info')?>,
                    <?=find_count_rows('news')?>
                ],
                backgroundColor: [
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
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
    const ctxDynamicJs = document.getElementById('myChartDynamicJs');
    console.log('get_financial_performance(): ' + <?= echo get_financial_performance() ?>)
    let kinerja_keuangan = JSON.parse('<?= echo json_encode(get_financial_performance()) ?>')
		console.log('kinerja_keuangan: ' + kinerja_keuangan)

				let tahun = collect(kinerja_keuangan).map(function(item) {
					return item.tahun
				}).all()
				console.log('tahun:' + tahun)

				let penjualan_neto = collect(kinerja_keuangan).map(function(item) {
					return item.penjualan_neto
				}).all()
				console.log('penjualan_neto:' + penjualan_neto)
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
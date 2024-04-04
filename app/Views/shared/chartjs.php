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
    let laba_tahun_berjalan = collect(kinerja_keuangan).map(function(item) {
        return item.laba_tahun_berjalan
    }).all()
    const labaTahunBerjalan = document.getElementById('labaTahunBerjalan');
    new Chart(labaTahunBerjalan, {
        type: 'bar',
        data: {
            labels: tahun,
            datasets: [{
                label: '# Laba Tahun Berjalan',
                data: laba_tahun_berjalan,
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
    let total_aset = collect(kinerja_keuangan).map(function(item) {
        return item.total_aset
    }).all()
    const totalAset = document.getElementById('totalAset');
    new Chart(totalAset, {
        type: 'bar',
        data: {
            labels: tahun,
            datasets: [{
                label: '# Total Aset',
                data: total_aset,
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
    let hasil_dividen = collect(kinerja_keuangan).map(function(item) {
        return item.hasil_dividen
    }).all()
    const hasilDividen = document.getElementById('hasilDividen');
    new Chart(hasilDividen, {
        type: 'bar',
        data: {
            labels: tahun,
            datasets: [{
                label: '# Hasil Dividen',
                data: hasil_dividen,
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
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
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
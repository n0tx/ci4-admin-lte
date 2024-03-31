<script>
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
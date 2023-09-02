<link rel="stylesheet" href="<?= base_url() ?>/plugins/chart.js/Chart.min.css">
<script src="<?= base_url() ?>/plugins/chart.js/Chart.bundle.min.js"></script>


<canvas id="myChart" style="height: 300px;width:500px"></canvas>


<?php
$tanggal = "";
$total = "";

foreach ($grafik as $row) :
    $tgl = $row['tgl'];
    $tanggal .= "'$tgl'" . ",";

    $totalHarga = $row['totalharga'];
    $total  .= "'$totalHarga'" . ",";
endforeach;

?>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        responsive: true,
        data: {
            labels: [<?= $tanggal; ?>],
            datasets: [{
                label: 'Total Harga',
                backgroundColor: ['rgb(150,0,0)', 'rgb(0,0,150)', 'rgb(0,150,0)', 'rgb(90,120,80)', 'rgb(90,200,80)', 'rgb(200,120,200)'],
                borderColor: ['rgb(10,10,10)'],
                data: [<?= $total; ?>]
            }]
        },
        duration: 1000
    })
</script>
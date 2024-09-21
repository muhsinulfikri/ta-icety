<!-- Content Wrapper START -->
<div class="main-content">
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-dollar"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">
                                <?= isset($total_revenue[0]->TOTAL) && $total_revenue[0]->TOTAL !== null ? $total_revenue[0]->TOTAL : '0' ?>
                                IDR</h2>
                            <p class="m-b-0 text-muted">Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                            <i class="anticon anticon-profile"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">
                                <?= isset($total_event[0]->TOTAL) && $total_event[0]->TOTAL !== null ? $total_event[0]->TOTAL : '0' ?>
                            </h2>
                            <p class="m-b-0 text-muted">Event</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-gold">
                            <i class="anticon anticon-profile"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">
                                <?= isset($total_course[0]->TOTAL) && $total_course[0]->TOTAL !== null ? $total_course[0]->TOTAL : '0' ?>
                            </h2>
                            <p class="m-b-0 text-muted">Course</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (session('user')[0]['ID_ROLE'] == 1) { ?>
        <div class="col-md-6 col-lg-2">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-purple">
                            <i class="anticon anticon-user"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0"><?= $total_user[0]->TOTAL ?></h2>
                            <p class="m-b-0 text-muted">User</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
    <div class="row">
        <div class="col-md-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Total Revenue</h5>
                        <!-- <div>
                            <div class="btn-group">
                                <button class="btn btn-default active">
                                    <span>Month</span>
                                </button>
                                <button class="btn btn-default">
                                    <span>Year</span>
                                </button>
                            </div>
                        </div> -->
                    </div>
                    <div class="m-t-50" style="height: 330px">
                        <canvas class="chart" id="profit-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="m-b-0">Customers</h5>
                    <div class="m-v-60 text-center" style="height: 200px">
                        <canvas class="chart" id="customers-chart"></canvas>
                    </div>
                    <div class="row border-top p-t-25">
                        <div class="col-4">
                            <div class="d-flex justify-content-center">
                                <div class="media align-items-center">
                                    <span class="badge badge-success badge-dot m-r-10"></span>
                                    <div class="m-l-5">
                                        <h4 class="m-b-0">350</h4>
                                        <p class="m-b-0 muted">New</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-center">
                                <div class="media align-items-center">
                                    <span class="badge badge-secondary badge-dot m-r-10"></span>
                                    <div class="m-l-5">
                                        <h4 class="m-b-0">450</h4>
                                        <p class="m-b-0 muted">Returning</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-center">
                                <div class="media align-items-center">
                                    <span class="badge badge-warning badge-dot m-r-10"></span>
                                    <div class="m-l-5">
                                        <h4 class="m-b-0">100</h4>
                                        <p class="m-b-0 muted">Others</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #legend ul {
        list-style: none;
        font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
        font-size: 12px;
    }

    #legend ul span {
        display: inline-block;
        height: 1em;
        width: 1em;
        margin-right: 0.5em;
    }
</style>
<script>
    var myChart = new Chart("profit-chart", {
        type: 'line',
        maintainAspectRatio: false,
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OKT', 'NOV', 'DES'],
            datasets: []
        },
        options: {
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var value = data.datasets[0].data[tooltipItem.index];
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);
                        value = value.join(',');
                        return data.datasets[0].label + ' : ' + value;
                    }
                }
            },
            legend: {
                display: true,
                position: 'bottom',
                fullWidth: true
            },
            scales: {
                xAxes: [{
                    gridLines: [{
                        display: false,
                    }],
                    ticks: {
                        display: true,
                        fontColor: '#77838f',
                        fontSize: 13,
                        padding: 10
                    }
                }],
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        drawTicks: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineBorderDash: [3, 4]
                    }
                }],
            },
        }
    });

    var getData = function() {
        var month = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OKT', 'NOV', 'DES']
        $.ajax({
            url: '<?= asset('chart/revenue') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $.each(response, function(key, value) {
                    myChart.data.datasets.push({
                        label: 'Revenue ' + value.YEAR,
                        backgroundColor: getRandomColor(key),
                        borderColor: getRandomColor(key),
                        pointBackgroundColor: getRandomColor(key),
                        pointBorderColor: '#ffffff',
                        pointHoverBackgroundColor: getRandomColor(key),
                        pointHoverBorderColor: 'rgba(63, 135, 245, 0.15)',
                        data: value.REVENUE
                    });
                });
                myChart.update();
            }
        });
    };

    getData()

    function getRandomColor(key) {
        var color = '#';
        var index = key + 1
        if (index == 1) {
            color += '3fb6f5';
        }
        if (index == 2) {
            color += '553ff5';
        }
        if (index == 3) {
            color += '3fc4f5';
        }
        if (index == 4) {
            color += '973ff5';
        }
        if (index == 5) {
            color += '7a3ff5';
        }
        if (index == 6) {
            color += '5c3ff5';
        }
        if (index == 7) {
            color += '3faef5';
        }
        if (index == 8) {
            color += '3fc4f5';
        }
        if (index == 9) {
            color += '3fdaf5';
        }
        return color;
    }
</script>
<!-- Content Wrapper END -->

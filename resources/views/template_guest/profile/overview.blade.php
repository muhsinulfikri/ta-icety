@extends('template_guest.profile.profile_template')
@section('content')
<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-2" style="color:#5580E9">Overview</h3>
    <div class="row my-4">
        <div class="col-6">
            <div class="card mx-2 border-0 shadow rounded-4">
                <div class="card-body">
                    <div class="m-l-15">
                        <strong class="fs-6 text-muted">Today's Revenue</strong>
                        <h2 class="mb-3 mt-4">IDR 25.000</h2>
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mx-2 border-0 shadow rounded-4">
                <div class="card-body">
                    <div class="m-l-15">
                        <strong class="fs-6 text-muted">Today's Order</strong>
                        <h2 class="mb-3 mt-4">5</h2>
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-6">
            <div class="card mx-2 border-0 shadow rounded-4">
                <div class="card-body">
                    <div class="m-l-15">
                        <strong class="fs-6 text-muted">Total Courses</strong>
                        <h2 class="mb-3 mt-4">8</h2>
                        <canvas id="coursesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mx-2 border-0 shadow rounded-4">
                <div class="card-body">
                    <div class="m-l-15">
                        <strong class="fs-6 text-muted">Total Purchase</strong>
                        <h2 class="mb-3 mt-4">48</h2>
                        <canvas id="purchaseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-6">
            <div class="card mx-2 border-0 shadow rounded-4">
                <div class="card-body">
                    <div class="m-l-15">
                        <strong class="fs-6 text-muted">Total Profit</strong>
                        <h2 class="mb-3 mt-4">IDR 700.000</h2>
                        <canvas id="profitChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" mt-5 p-4 rounded-3 shadow">
        <span class="fw-semibold fs-5">Withdraw</span>
        <div class="my-3 float-label-control">
            <input type="email" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Email" name="email" aria-describedby="" required="">
        </div>
        <div class="my-3 float-label-control">
            <input type="text" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Your Name" name="name" aria-describedby="" required="">
        </div>
        <div class="my-3 float-label-control">
            <input type="text" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Your Bank" name="bank" aria-describedby="" required="">
        </div>
        <div class="my-3 float-label-control">
            <input type="number" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Account Number" name="acc" aria-describedby="" required="">
        </div>
        <div class="my-3 float-label-control">
            <input type="number" class="form-control input-text woocommerce-Input woocommerce-Input--text" id="exampleInputEmail1" placeholder="Nominal" name="nominal" aria-describedby="" required="">
        </div>
        <div class="d-flex w-100 align-items-center justify-content-center">
            <button type="submit" class="btn btn-third btn-main rounded rounded-4 fw-semibold py-2 w-auto mt-4" style="--bs-btn-padding-x: 4.5rem;">Send</button>
        </div>
    </div>

    <div class="mt-5 d-flex flex-column">
        <span class="fw-semibold fs-5">Recent Activities</span>
        <span class="text-muted text-uppercase mt-3 fs-6">Today</span>
        <hr class="mb-1">
        <!-- Item activities start -->
        <div class="d-flex flex-row justify-content-between align-items-center">
            <div class="d-flex flex-row align-items-center">
                <div class="">
                    <i class="fs-2 bi bi-wallet2"></i>
                </div>
                <div class="d-flex flex-column ms-3 pt-2">
                    <h6 class="mb-1  fw-semibold">Take</h6>
                    <h6 style="font-size:0.9rem;" class="text-muted fw-semibold">December 32, 2022</h6>
                </div>
            </div>
            <div>
                <h6 class="mb-3 mt-4 fw-semibold">IDR 700.000</h6>
            </div>
        </div>
        <!-- Item activities end -->

        <div class="d-flex flex-row justify-content-between align-items-center">
            <div class="d-flex flex-row align-items-center">
                <div class="">
                    <i class="fs-2 bi bi-wallet2"></i>
                </div>
                <div class="d-flex flex-column ms-3 pt-2">
                    <h6 class="mb-1  fw-semibold">Take</h6>
                    <h6 style="font-size:0.9rem;" class="text-muted fw-semibold">December 32, 2022</h6>
                </div>
            </div>
            <div>
                <h6 class="mb-3 mt-4 fw-semibold">IDR 1.000.000</h6>
            </div>
        </div>
        <span class="text-muted text-uppercase mt-3 fs-6">Yesterday</span>
        <hr class="mb-1">

        <div class="d-flex flex-row justify-content-between align-items-center">
            <div class="d-flex flex-row align-items-center">
                <div class="">
                    <i class="fs-2 bi bi-wallet2"></i>
                </div>
                <div class="d-flex flex-column ms-3 pt-2">
                    <h6 class="mb-1  fw-semibold">Take</h6>
                    <h6 style="font-size:0.9rem;" class="text-muted fw-semibold">December 31, 2022</h6>
                </div>
            </div>
            <div>
                <h6 class="mb-3 mt-4 fw-semibold">IDR 1.000.000</h6>
            </div>
        </div>

    </div>

</div>

<script>
    const crevenue = document.getElementById('revenueChart');
    new Chart(crevenue, {
        type: 'line',
        data: {
            labels: ['01:00', '12:00', '19:00', '23:00'],
            datasets: [{
                label: "Today's Revenue",

                data: [0, 5000, 20000, 25000],
                borderColor: "#5580e9",
                backgroundColor: "#ffff"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Today Revenue'
                },
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
                        fontColor: '# 77838 f ',
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
        },
    });
    const corder = document.getElementById('orderChart');
    new Chart(corder, {
        type: 'line',
        data: {
            labels: ['01:00', '12:00', '19:00', '23:00'],
            datasets: [{
                label: "Today's Order",
                data: [0, 1, 3, 5],
                borderColor: "#5580e9",
                backgroundColor: "#ffff"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Today Revenue'
                },
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
                        fontColor: '# 77838 f ',
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
        },
    });
    const ccourses = document.getElementById('coursesChart');
    new Chart(ccourses, {
        type: 'line',
        data: {
            labels: ['01:00', '12:00', '19:00', '23:00'],
            datasets: [{
                label: 'Total Courses',
                data: [0, 2, 5, 8],
                borderColor: "#5580e9",
                backgroundColor: "#ffff"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Today Revenue'
                },
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
                        fontColor: '# 77838 f ',
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
        },
    });
    const cpurchase = document.getElementById('purchaseChart');
    new Chart(cpurchase, {
        type: 'line',
        data: {
            labels: ['01:00', '12:00', '19:00', '23:00'],
            datasets: [{
                label: 'Total Purchase',
                data: [0, 17, 25, 48],
                borderColor: "#5580e9",
                backgroundColor: "#ffff"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Today Revenue'
                },
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
                        fontColor: '# 77838 f ',
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
        },
    });
    const cprofit = document.getElementById('profitChart');
    new Chart(cprofit, {
        type: 'line',
        data: {
            labels: ['Sep', 'Oct', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Profit',
                data: [100000, 50000, 350000, 200000],
                borderColor: "#5580e9",
                backgroundColor: "#ffff"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Today Revenue'
                },
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
                        fontColor: '# 77838 f ',
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
        },
    });
</script>
@endsection
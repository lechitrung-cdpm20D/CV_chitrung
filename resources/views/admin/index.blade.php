@extends('admin.layouts.app-admin')
@section('content')
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Bảng điều khiển</h4>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-2 col-xlg-3">
                    <div class="card card-hover">
                        <a href="/admin">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                <h6 class="text-white">Bảng điều khiển</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xlg-3">
                    <div class="card card-hover">
                        <a href="{{ route('indexDonHang', ['token' => Auth::user()->token]) }}">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white"><i class="me-2 mdi mdi-cart-outline"></i></h1>
                                <h6 class="text-white">Đơn hàng</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2 col-xlg-3">
                    <div class="card card-hover">
                        <a onclick="customerclick()" style="cursor: pointer;">
                            <div class="box bg-warning text-center">
                                <h1 class="font-light text-white"><i class="me-2 mdi mdi-account-multiple-outline"></i></h1>
                                <h6 class="text-white">Khách hàng</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xlg-3">
                    <div class="card card-hover">
                        <a onclick="productclick()" style="cursor: pointer;">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><i class="me-2 mdi mdi-cellphone-iphone"></i></h1>
                                <h6 class="text-white">Sản phẩm</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xlg-3">
                    <div class="card card-hover">
                        <a onclick="accessoriesclick()" style="cursor: pointer;">
                            <div class="box bg-secondary text-center">
                                <h1 class="font-light text-white"><i class="me-2 mdi mdi-border-inside"></i></h1>
                                <h6 class="text-white">Linh kiện</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2 col-xlg-3">
                    <div class="card card-hover">
                        <a onclick="staffclick()" style="cursor: pointer;">
                            <div class="box bg-secondary text-center" style="background-color: #e18293 !important;">
                                <h1 class="font-light text-white"><i class="me-2 mdi mdi-clipboard-account"></i></h1>
                                <h6 class="text-white">Nhân viên</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xlg-3">
                    <div class="card card-hover">
                        <a onclick="accountclick()" style="cursor: pointer;">
                            <div class="box bg-secondary text-center" style="background-color: #78a422 !important;">
                                <h1 class="font-light text-white"><i class="me-2 mdi mdi-account-outline"></i></h1>
                                <h6 class="text-white">Tài khoản</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2 col-xlg-3">
                    <div class="card card-hover">
                        <a onclick="storeclick()" style="cursor: pointer;">
                            <div class="box bg-secondary text-center" style="background-color: #553D67 !important;">
                                <h1 class="font-light text-white"><i class="me-2 mdi mdi-home-variant"></i></h1>
                                <h6 class="text-white">Kho, cửa hàng</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- column -->
                                <div class="col-lg-12">
                                    {{-- <div class="flot-chart">
                                        <div class="flot-chart-content" id="flot-line-chart"></div>
                                    </div> --}}
                                    <div id="column-chart" style="height: 300px; width: 100%;">
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="bg-dark p-10 text-white text-center">
                                                <i class="fa fa-user mb-1 font-16"></i>
                                                <h5 class="mb-0 mt-1">{{ $tongSoND }}</h5>
                                                <small class="font-light">Tổng số người dùng</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-dark p-10 text-white text-center">
                                                <i class="fas fa-mobile-alt"></i>
                                                <h5 class="mb-0 mt-1">{{ $tongSoSP }}</h5>
                                                <small class="font-light">
                                                    Tổng số sản phẩm</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="bg-dark p-10 text-white text-center">
                                                <i class="fas fa-home"></i>
                                                <h5 class="mb-0 mt-1">{{ $tongSoCH }}</h5>
                                                <small class="font-light">Tổng số cửa hàng</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="bg-dark p-10 text-white text-center">
                                                <i class="fas fa-shopping-cart"></i>
                                                <h5 class="mb-0 mt-1">{{ $tongSoDH }}</h5>
                                                <small class="font-light">Tổng số đơn hàng</small>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- column -->
                            </div>
                            <div class="d-md-flex align-items-center">
                                <form action='/layDoanhThu' method="POST"
                                    style="position: relative;margin-top: 20px;left: 28%;">
                                    @csrf
                                    <div style="display: flex;">
                                        <h4 class="card-title">Số liệu năm:</h4>
                                        <div style="position: relative;bottom: 8px;left: 5px;">
                                            <select name="nam"
                                                class="select2 form-select shadow-none select2-hidden-accessible"
                                                style="width: 100%; height:36px;" tabindex="-1" aria-hidden="true">
                                                @foreach ($doanhThuTungNam as $tp)
                                                    @if ($tp->nam == $nam)
                                                        <option value="{{ $tp->nam }}" selected>{{ $tp->nam }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $tp->nam }}">{{ $tp->nam }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="position: relative;bottom: 6px;height: 41px;left: 10px;">
                                            <button type="submit" class="btn btn-primary">Chọn</button>
                                        </div>
                                    </div>
                                </form>
                                <form action='/export-csv' method="POST"
                                    style="position: relative;margin-top: 20px;left: 28%;">
                                    @csrf
                                    <input type='hidden' name='doanh_thu_nam' value='{{ $nam }}'>
                                    <div style="position: relative;bottom: 9px;left: 15px;">
                                        <button type="submit" class="btn btn-primary">Xuất file Excel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- column -->
                <div class="col-lg-6">
                    <div id="pie-chart" style="height: 400px; width: 100%;"></div>
                </div>
                <div class="col-lg-6">
                    <div id="line-chart" style="height: 400px; width: 100%;"></div>
                </div>
                <!-- column -->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    <script>
        function customerclick() {
            var tabcustomer = document.querySelector('.tabcustomer');
            tabcustomer.click();
        }

        function productclick() {
            var tabproduct = document.querySelector('.tabproduct');
            tabproduct.click();
        }

        function accessoriesclick() {
            var tabaccessories = document.querySelector('.tabaccessories');
            tabaccessories.click();
        }

        function staffclick() {
            var tabstaff = document.querySelector('.tabstaff');
            tabstaff.click();
        }

        function accountclick() {
            var tabaccount = document.querySelector('.tabaccount');
            tabaccount.click();
        }

        function storeclick() {
            var tabstore = document.querySelector('.tabstore');
            tabstore.click();
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    </script>
    <script type="text/javascript">
        window.onload = function() {
            var thang = 0;
            var doanhThuTemp = <?php echo json_encode($doanhThuTungThang); ?>;
            var doanhThuCaoNhat = doanhThuTemp[0].doanhthu;
            doanhThuTemp.forEach(element => {
                if (element.doanhthu >= doanhThuCaoNhat) {
                    doanhThuCaoNhat = element.doanhthu;
                }
                thang++;
            });
            doanhThuCaoNhat = doanhThuCaoNhat + 100000;
            // console.log(number_format(doanhThuCaoNhat, 0, '.', '.'));
            var temp = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            for (var i = 0; i < thang; i++) {
                temp[doanhThuTemp[i].thang - 1] = doanhThuTemp[i].doanhthu;
            }
            var chart = new CanvasJS.Chart("column-chart", {
                exportEnabled: true,
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Doanh thu từng tháng năm " + <?php echo json_encode($nam); ?>,
                    fontFamily: "Arial, Helvetica, sans-serif",
                },
                axisY: {
                    // title: "Doanh thu (VNĐ)",
                    valueFormatString: "#,###,##0 VNĐ", //try properties here
                },
                data: [{
                    type: "column",
                    // showInLegend: true,
                    legendMarkerColor: "grey",
                    // legendText: "VNĐ = Việt Nam Đồng",
                    dataPoints: [{
                            y: temp[0],
                            label: "Tháng 1"
                        },
                        {
                            y: temp[1],
                            label: "Tháng 2"
                        },
                        {
                            y: temp[2],
                            label: "Tháng 3"
                        },
                        {
                            y: temp[3],
                            label: "Tháng 4"
                        },
                        {
                            y: temp[4],
                            label: "Tháng 5"
                        },
                        {
                            y: temp[5],
                            label: "Tháng 6"
                        },
                        {
                            y: temp[6],
                            label: "Tháng 7"
                        },
                        {
                            y: temp[7],
                            label: "Tháng 8"
                        },
                        {
                            y: temp[8],
                            label: "Tháng 9"
                        },
                        {
                            y: temp[9],
                            label: "Tháng 10"
                        },
                        {
                            y: temp[10],
                            label: "Tháng 11"
                        },
                        {
                            y: temp[11],
                            label: "Tháng 12"
                        },
                    ],
                    toolTipContent: "{label} có doanh thu là {y} VNĐ"
                }]
            });
            chart.render();

            //Biểu đồ tròn
            <?php
            $dataPoints = [];
            for ($i = 0; $i < count($danhSachThuongHieu); $i++) {
                $dataPoints[$i]['label'] = $danhSachThuongHieu[$i]->ten_thuong_hieu;
                $dataPoints[$i]['y'] = $danhSachThuongHieu[$i]->sl_sp_ban_ra;
            }
            ?>
            var dataBieuDoTron = <?php echo json_encode($danhSachThuongHieu); ?>;
            var chart = new CanvasJS.Chart("pie-chart", {
                exportEnabled: true,
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Tỉ lệ số lượng sản phẩm các hãng bán ra năm " + <?php echo json_encode($nam); ?>,
                    fontSize: 20,
                    fontFamily: "Arial, Helvetica, sans-serif",
                },
                legend: {
                    cursor: "pointer",
                    itemclick: explodePie
                },
                data: [{
                    type: "pie",
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabelFontSize: 16,
                    // toolTipContent: "{label}: <strong>{y} cái</strong>",
                    indexLabel: "{label} - #percent%",
                    yValueFormatString: "#,##0 chiếc",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();


            // console.log(<?php echo json_encode($doanhThuTungNam); ?>)
            //Biểu đồ đường
            <?php
            $dataPoints = [];
            for ($i = 0; $i < count($doanhThuTungNam); $i++) {
                $dataPoints[$i]['x'] = $doanhThuTungNam[$i]->nam;
                $dataPoints[$i]['y'] = $doanhThuTungNam[$i]->doanhthu;
            }
            ?>
            var chart = new CanvasJS.Chart("line-chart", {
                exportEnabled: true,
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Doanh thu từng năm",
                    fontSize: 25,
                    fontFamily: "Arial, Helvetica, sans-serif",
                },
                axisY: {
                    // title: "Doanh thu (VNĐ)",
                    valueFormatString: "#,###,##0 VNĐ", //try properties here
                },
                data: [{
                    yValueFormatString: "#,### VNĐ",
                    xValueFormatString: "YYYY",
                    type: "spline",
                    dataPoints: [{
                            x: new Date(<?php echo json_encode($doanhThuTungNam[0]->nam); ?>, 0),
                            y: <?php echo json_encode($doanhThuTungNam[0]->doanhthu); ?>
                        },
                        {
                            x: new Date(<?php echo json_encode($doanhThuTungNam[1]->nam); ?>, 0),
                            y: <?php echo json_encode($doanhThuTungNam[1]->doanhthu); ?>
                        },
                        {
                            x: new Date(<?php echo json_encode($doanhThuTungNam[2]->nam); ?>, 0),
                            y: <?php echo json_encode($doanhThuTungNam[2]->doanhthu); ?>
                        },
                        {
                            x: new Date(<?php echo json_encode($doanhThuTungNam[3]->nam); ?>, 0),
                            y: <?php echo json_encode($doanhThuTungNam[3]->doanhthu); ?>
                        },
                        {
                            x: new Date(<?php echo json_encode($doanhThuTungNam[4]->nam); ?>, 0),
                            y: <?php echo json_encode($doanhThuTungNam[4]->doanhthu); ?>
                        },
                    ],
                    toolTipContent: "Năm {x} có doanh thu là {y}"
                }]
            });
            chart.render();
        }

        function explodePie(e) {
            if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e
                    .dataPointIndex].exploded) {
                e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
            } else {
                e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
            }
            e.chart.render();
        }
    </script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection

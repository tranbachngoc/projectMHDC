<?php $this->load->view('home/common/account/header'); ?>
    <style>
        #statistic .box_item {
            height: 130px;
        }

        #statistic {
            overflow: auto !important;
        }

        #columnchart_values_day, #columnchart_values_month, #columnchart_values_year {
            width: 100%;
            margin-bottom: 20px;
            overflow-x: auto;
            height: 410px !important;
            overflow-y: hidden;
        }

        #columnchart_values_day::-webkit-scrollbar, #columnchart_values_month::-webkit-scrollbar, #columnchart_values_year::-webkit-scrollbar {
            width: 5px;
            background-color: #F5F5F5;
            height: 8px;
        }

        #columnchart_values_day::-webkit-scrollbar-track, #columnchart_values_month::-webkit-scrollbar-track, #columnchart_values_year::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.9);
            border-radius: 5px;
            background-color: #CCCCCC;
        }

        #columnchart_values_day::-webkit-scrollbar-thumb, #columnchart_values_month::-webkit-scrollbar-thumb, #columnchart_values_year::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: #2a292a;
            background-image: -webkit-linear-gradient(90deg,
            transparent,
            rgba(0, 0, 0, 0.4) 20%,
            transparent,
            transparent)
        }

    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ['corechart']});
    </script>
<?php if ($dayx): ?>
    <script type="text/javascript">

        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Ngày", "Thống kê theo tuần trong tháng", {role: "style"}],
                <?php echo $dayx; ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2]);

            var options = {
                title: "Thống kê theo tuần trong tháng (Đ)",
                width: 820,
                height: 400,
                allowHtml: true,
                bar: {groupWidth: "95%"},
                legend: {position: "none"}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_day"));
            chart.draw(view, options);
        }
    </script>
<?php endif; ?>

    <script type="text/javascript">
        //month
        google.charts.setOnLoadCallback(drawChartMonth);
        function drawChartMonth() {
            var data = google.visualization.arrayToDataTable([
                ["Ngày", "Thống kê theo tháng", {role: "style"}],
                <?php echo $monthx; ?>
            ]);
            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2]);

            var options = {
                title: "Thống kê theo tháng (Đ)",
                width: 820,
                height: 400,
                bar: {groupWidth: "95%"},
                legend: {position: "none"},
                hAxis: {
                    slantedText: true,
                    slantedTextAngle: 45
                },
                allowHtml: true
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_month"));
            chart.draw(view, options);
        }
    </script>

    <style>
        .cr-styled {
            display: inline-block;
            margin: 0px 2px;
            line-height: 20px;
            font-weight: normal;
            cursor: pointer;
        }

        .cr-styled i {
            display: inline-block;
            height: 18px;
            width: 18px;
            cursor: pointer;
            vertical-align: middle;
            border: 2px solid #CCC;
            border-radius: 3px;
            text-align: center;
            padding-top: 1px;
            font-family: 'FontAwesome';
            margin-top: -4px;
            margin-right: 3px;
            font-size: 12px;
        }

        .cr-styled input {
            visibility: hidden;
            display: none;
        }

        .cr-styled input[type=checkbox]:checked + i:before {
            content: "\f00c";
        }

        .cr-styled input[type=radio] + i {
            border-radius: 18px;
            font-size: 11px;
            line-height: 13px;
        }

        .cr-styled input[type=radio]:checked + i:before {
            content: "\f111";
        }

        .cr-styled input:checked + i {
            border-color: #6e8cd7;
            color: #6e8cd7;
        }

        #frmStatitics {
            display: none;
        }

        .red_money {
            text-align: right;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
                    <?php echo 'Thống kê thu nhập';
                    if ($this->session->userdata('sessionGroup') == AffiliateStoreUser && $this->uri->segment(2)=='statisticIncome') {
                        echo ' toàn hệ thống';
                    }
                    echo ' (Năm: ' . date('Y') . ')'; ?>
                </h4>

                <div id="panel_order_af">
                    <div style="overflow: auto; width:100%">
                        <?php if ($this->session->userdata('sessionGroup') == 3) {
                            $dp = 'display: block';
                        } else {
                            $dp = 'display: none';
                        } ?>
                        <!--                          <div id="columnchart_values_day" style="width: 1200px; height: 450px; -->
                        <?php //echo $dp;?><!--"></div>-->
                        <!--                         <div id="columnchart_values_month" style="width: 1200px; height: 450px;clear:both;"></div>-->
                        <?php echo $service_charts; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
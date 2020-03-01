<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Tháng", "Đơn hàng", { role: "style" } ],
          <?php echo $monthx16.$monthx17; ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                         { calc: "stringify",
                           sourceColumn: 1,
                           type: "string",
                           role: "annotation" },
                         2]);

        var options = {
          title: "Thống kê tổng đơn hàng Sản phẩm năm 2016 - 2017",
          width: 1200,
          height: 400,
          bar: {groupWidth: "95%"},
          legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_month"));
        chart.draw(view, options);
    }
    
    //month Coupon
    google.charts.setOnLoadCallback(drawChartMonth);
    function drawChartMonth() {
          var data = google.visualization.arrayToDataTable([
            ["Tháng", "Đơn hàng", { role: "style" } ],
            <?php echo $monthx16Coupon.$monthx17Coupon; ?>
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

          var options = {
            title: "Thống kê tổng đơn hàng Coupon năm 2016 - 2017",
            width: 1200,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_month_coupon"));
          chart.draw(view, options);
    }
    
    //year
    google.charts.setOnLoadCallback(drawChartYear);
    function drawChartYear() {
          var data = google.visualization.arrayToDataTable([
            ["Ngày", "Doanh thu", { role: "style" } ],
            <?php echo $yearx; ?>
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

          var options = {
            title: "Thống kê tổng doanh thu đơn hàng theo ngày (Đ)",
            width: 1200,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_year"));
          chart.draw(view, options);
    }
</script>

<div style="color:black;text-align: right;font-weight: bold;font-size: 15px;margin-right: 225px; display:none;">
    <form name="frmService" action="" method="POST">
        Tìm kiếm theo ngày: 
        <input autocomplete="off" class="form-control input-sm" type="text" id="daterange" name="daterange" value="<?php echo ($this->input->post('daterange'))?$this->input->post('daterange'):''; ?>" readonly="">
        <input type="submit" value="Tìm kiếm" name="search"/>
        <input autocomplete="off" type="hidden" name="date_range" value="">
    </form>
</div>

<?php if($monthx16): ?><div id="columnchart_values_month" style="width: 1200px; height: 450px;"></div><?php endif; ?>
<?php if($monthx16Coupon): ?><div id="columnchart_values_month_coupon" style="width: 1200px; height: 450px;"></div><?php endif; ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/daterangepicker.css" />
<style>
.show-calendar.opensleft{display:none;border: 1px solid #ccc;}
.daterangepicker .input-mini{width:82% !important}
</style>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/daterangepicker.js"></script>
<script type="text/javascript">
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Hủy',
                applyLabel: 'Xác nhận',
                format:'DD/MM/YYYY'
            },
            cancelClass:'btn-danger',
            alwaysShowCalendars:true,
            autoApply:false

        });
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            var row = $(this).parents('tr');
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            row.find('input[name="date_range"]').val(picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
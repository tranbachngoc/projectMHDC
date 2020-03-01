<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Ngày", "Doanh thu", { role: "style" } ],
          <?php echo $dayx; ?>
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
          width:820,
          height: 400,
          bar: {groupWidth: "95%"},
          legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_day"));
        chart.draw(view, options);
    }
    
    //month
    google.charts.setOnLoadCallback(drawChartMonth);
    function drawChartMonth() {
          var data = google.visualization.arrayToDataTable([
            ["Ngày", "Doanh thu", { role: "style" } ],
            <?php echo $monthx; ?>
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);

          var options = {
            title: "Thống kê tổng doanh thu đơn hàng theo tháng (Đ)",
            width: 820,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_month"));
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
            title: "Thống kê tổng doanh thu đơn hàng theo năm (Đ)",
            width: 820,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_year"));
          chart.draw(view, options);
    }
</script>

<div style="color:black;text-align: right;font-weight: bold;font-size: 15px;margin-right: 225px;">
    <form class="form-inline" name="frmService" action="" method="POST">
        <div class="form-group">
            <label for="exampleInputName2">Tìm kiếm theo ngày:</label>
            <input autocomplete="off" class="form-control" type="text" id="daterange" name="daterange" value="<?php echo ($this->input->post('daterange'))?$this->input->post('daterange'):''; ?>" readonly="">
            <button type="submit" name="search" class="btn btn-azibai">Tìm kiếm</button>
        </div>
        <input autocomplete="off" type="hidden" name="date_range" value="">
    </form>
</div>

<?php if($dayx): ?><div id="columnchart_values_day" style="width: 1200px; height: 450px;"></div><?php endif; ?>
<?php if($monthx): ?><div id="columnchart_values_month" style="width: 1200px; height: 450px;"></div><?php endif; ?>
<?php if($yearx): ?><div id="columnchart_values_year" style="width: 1200px; height: 450px;"></div><?php endif; ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/daterangepicker.css" />
<style>
.show-calendar.opensleft{display:none;border: 1px solid #ccc;}
</style>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/daterangepicker.js"></script>
<script type="text/javascript">
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Hủy',
                applyLabel: 'Xác nhận'
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
        
        $('input[name="daterange"]').val('');
    });
</script>
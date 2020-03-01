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
      title: "Thống kê tổng doanh thu dịch vụ theo ngày (Đ)",
      width: 1200,
      height: 400,
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_day"));
    chart.draw(view, options);
    
    //month
    google.charts.setOnLoadCallback(drawChartMonth);
    function drawChartMonth() {
        var data = google.visualization.arrayToDataTable([
          ["Tháng", "Doanh thu", { role: "style" } ],
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
          title: "Thống kê tổng doanh thu dịch vụ theo tháng (Đ)",
          width: 1200,
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
          ["Tháng", "Doanh thu", { role: "style" } ],
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
          title: "Thống kê tổng doanh thu dịch vụ theo năm (Đ)",
          width: 1200,
          height: 400,
          bar: {groupWidth: "95%"},
          legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_year"));
        chart.draw(view, options);
    }
}
</script>

<div style="color:black;text-align: right;font-weight: bold;font-size: 15px;margin-right: 225px;">
    <form name="frmService" action="" method="POST">
        Tìm kiếm theo ngày: 
        <input autocomplete="off" class="form-control input-sm" type="text" id="daterange" name="daterange" value="<?php echo ($this->input->post('daterange'))?$this->input->post('daterange'):''?>" readonly="">
        <input type="submit" value="Tìm kiếm" name="search"/>
        <input autocomplete="off" type="hidden" name="date_range" value="">
    </form>
</div>


<?php if($dayx): ?><div id="columnchart_values_day" style="width: 1200px; height: 450px;"></div><?php endif; ?>
<?php if($monthx): ?><div id="columnchart_values_month" style="width: 1200px; height: 450px;"></div><?php endif; ?>
<?php if($yearx): ?><div id="columnchart_values_year" style="width: 1200px; height: 450px;"></div><?php endif; ?>

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

        $('input[name="daterange"]').val('');
    });
</script>
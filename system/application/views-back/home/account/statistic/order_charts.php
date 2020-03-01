<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Ngày", "<?php echo $arrayToDataTable; ?>", { role: "style" } ],
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
          title: "<?php echo $title; ?> ngày (Đ)",
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
            ["Ngày", "<?php echo $arrayToDataTable; ?>", { role: "style" } ],
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
            title: "<?php echo $title; ?> tháng (Đ)",
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
            ["Ngày", "<?php echo $arrayToDataTable; ?>", { role: "style" } ],
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
            title: "<?php echo $title; ?> năm (Đ)",
            width: 820,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_year"));
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
</style>

    <form class="form-inline" name="frmStatitics" id="frmStatitics" action="" method="POST">
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" id="radio_order" name="options_tad" value="1" <?php echo ($tad == "frm_orders")?'checked':''; ?> >
                        Số lượng đơn hàng
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" id="revenues" name="options_tad" value="2" <?php echo ($tad == "frm_revenues")?'checked':''; ?> >
                        Doanh thu đơn hàng
                    </label>
                </div>
            </div>
            <br>
            <br>
            <div class="form-group">
                Tìm kiếm theo ngày:
                <input autocomplete="off" class="form-control" type="text" id="daterange" name="daterange" value="<?php echo ($this->input->post('daterange'))?$this->input->post('daterange'):''; ?>" readonly="">
                <button type="submit" name="search" class="btn btn-azibai">Tìm kiếm</button>
            </div>
            <input autocomplete="off" type="hidden" name="date_range" value="<?php echo ($this->input->post('date_range'))?$this->input->post('date_range'):''; ?>">
    </form>
<br>
<div class="clearfix"></div>
<?php if($dayx): ?><div id="columnchart_values_day" style="width: 100%; height: 450px;"></div><?php endif; ?>
<?php if($monthx): ?><div id="columnchart_values_month" style="width: 100%; height: 450px;"></div><?php endif; ?>
<?php if($yearx): ?><div id="columnchart_values_year" style="width: 100%; height: 450px;"></div><?php endif; ?>

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
                applyLabel: 'Xác nhận',
                format:'DD/MM/YYYY'
            },
            cancelClass:'btn-danger',
            alwaysShowCalendars:true,
            autoApply:false
        });

        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $('input[name="date_range"]').val(picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        
        
        $('input[name=options_tad]').change(function () {
            $("#frmStatitics").submit();
        });
        
    });
</script>
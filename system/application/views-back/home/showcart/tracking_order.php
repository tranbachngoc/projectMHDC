<?php $this->load->view('home/common/checkout/header'); ?>
<?php
$this->user_model->get('','');
?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/orders_success.css" />
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 hidden-md hidden-sm hidden-xs">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
            <div class="col-lg-10">
                <h3> Thông tin đơn hàng:  </h3>
                <div class="datagrid">
                <?php
                if($tracking){
                    ?>
                        <table>
                            <thead>
                            <tr><th>Thời gian</th><th>Trạng Thái</th><th>Ghi Chú</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach($tracking as $item) {
                                echo '<tr><td>'.$item['thoi_gian'].'</td><td>'.$item['ten_trang_thai'].'</td><td>'.$item['ghi_chu'].'</td></tr>';
                            } ?>
                            </tbody>
                        </table>
                    <?php
                }else{
                    echo "<p style='padding:10px;'>Không tìm thấy thông tin đơn hàng</p>";
                }
                ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        .datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #8C8C8C; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8C8C8C), color-stop(1, #7D7D7D) );background:-moz-linear-gradient( center top, #8C8C8C 5%, #7D7D7D 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8C8C8C', endColorstr='#7D7D7D');background-color:#8C8C8C; color:#ffffff; font-size: 12px; font-weight: bold; border-left: 1px solid #A3A3A3; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #7D7D7D; border-left: 1px solid #DBDBDB;font-size: 12px;font-weight: normal; }.datagrid table tbody tr:nth-child(even) td { background: #EBEBEB; color: #7D7D7D; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #8C8C8C;background: #EBEBEB;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #F5F5F5;border: 1px solid #8C8C8C;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8C8C8C), color-stop(1, #7D7D7D));background:-moz-linear-gradient( center top, #8C8C8C 5%, #7D7D7D 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8C8C8C', endColorstr='#7D7D7D');background-color:#8C8C8C; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #7D7D7D; color: #F5F5F5; background: none; background-color:#8C8C8C;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
        h3{
            padding: 100px 0 50px 0;
            margin: 0 auto;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
        }
        .datagrid{width: 70%;margin: 0 auto 200px;}
        #footer{position: absolute;bottom: 0; width: 100%;}
    </style>

    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
<style>

</style>
<?php $this->load->view('home/common/footer'); ?>
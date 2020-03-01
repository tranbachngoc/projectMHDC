<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
		    Dịch vụ
		</h4>
	    
            <ul>
                <?php foreach ($sort as $sItem): ?>
                    <li style="display: inline-block; margin-right: 10px;"><a
                            href="<?php echo $sItem['link']; ?>"><?php echo $sItem['text']; ?></a></li>
                <?php endforeach; ?>
            </ul>
	    
            <form name="sBox" action="<?php echo $link; ?>" method="post" class="searchBox">
                <input type="text" name="q" value="<?php echo $filter['q']; ?>"
                       placeholder="Nhập từ khóa( tên, user name, email)">
                Gói: <select name="pid" autocomplete="off">
                    <option value="">Tất cả</option>
                    <?php foreach ($packages as $pack): ?>
                        <option
                            value="<?php echo $pack['id']; ?>" <?php echo ($filter['pid'] == $pack['id']) ? 'selected="selected"' : ''; ?>><?php echo $pack['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                Thời gian: <select name="period" autocomplete="off">
                    <option value="">Tất cả</option>
                    <?php foreach ($period as $pItem): ?>
                        <option
                            value="<?php echo $pItem['id']; ?>" <?php echo ($filter['period'] == $pItem['id']) ? 'selected="selected"' : ''; ?>><?php echo $pItem['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                Thời gian từ: <input type="text" name="df" value="<?php echo $filter['df']; ?>" placeholder="yyyy-mm-dd"
                                     autocomplete="off"/>
                đến <input type="text" name="dt" value="<?php echo $filter['dt']; ?>" placeholder="yyyy-mm-dd"
                           autocomplete="off"/>
                Theo: <select name="sort" autocomplete="off">
                    <?php foreach ($sortDate as $sortItem): ?>
                        <option
                            value="<?php echo $sortItem['id']; ?>" <?php echo ($filter['sort'] == $sortItem['id']) ? 'selected="selected"' : ''; ?>><?php echo $sortItem['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                Loại dịch vụ: <select name="os" autocomplete="off">
                    <?php foreach ($serviceStatus as $sortItem): ?>
                        <option
                            value="<?php echo $sortItem['id']; ?>" <?php echo ($filter['os'] == $sortItem['id']) ? 'selected="selected"' : ''; ?>><?php echo $sortItem['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Tìm kiếm">
                <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
            </form>
            <table class="table table-bordered sTable" width="100%" border="0" cellpadding="0" cellspacing="0">
                <thead>
                <td>Người đăng ký</td>
                <td>Ngày tạo</td>
                <td>Người giới thiệu</td>
                <td>Gói</td>
                <td>Thời gian(tháng)</td>
                <td>Số tiền</td>
                <td>Ngày bắt đầu</td>
                <td>Ngày kết thúc</td>
                <?php switch ($filter['os']) {
                    case '01':
                    case '02':
                        echo '<td>Thao tác</td>';
                        break;

                } ?>
                </thead>
                <?php foreach ($data as $item): ?>
                    <tr id="row_<?php echo $item['id']; ?>">
                        <td><?php echo $item['use_fullname']; ?></td>
                        <td><?php echo $item['created_date']; ?></td>
                        <td><?php echo $item['sponserName']; ?></td>
                        <td><?php echo $item['package']; ?></td>
                        <td><?php echo $item['period']; ?></td>
                        <td><?php echo number_format($item['amount'], 0, '.', ','); ?></td>
                        <td><?php echo $item['begined_date']; ?></td>
                        <td><?php echo $item['ended_date']; ?></td>
                        <?php switch ($filter['os']) {
                            case '01':
                                echo '<td>';
                                echo '<span class="completePayment">Xác nhận thanh toán</span>&nbsp;|&nbsp;';
                                echo '<span class="cancelService">Hủy</span>';
                                echo '</td>';
                                break;
                            case '02':
                                echo '<td>';
                                echo '<span class="startService">Kích hoạt dịch vụ</span>';
                                echo '</td>';
                                break;
                        } ?>

                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="pagination">
            <?php echo $pager; ?>
        </div>
        <!--BEGIN: RIGHT-->
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

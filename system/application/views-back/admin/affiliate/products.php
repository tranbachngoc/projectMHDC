<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <?php $this->load->view('home/common/left'); ?>
    <!--BEGIN: RIGHT-->
    <div class="col-lg-9">
<!--<ul>-->
<!--    <li><a href="--><?php //echo $productLink;?><!--">Danh sách sản phẩm</a></li>-->
<!--    <li><a href="--><?php //echo $myproductsLink;?><!--">Sản phẩm của tôi</a></li>-->
<!--</ul>-->
<ul>
   <span class="text-uppercase">Sort by:</span>
    <?php foreach($sort as $sItem):?>
        <li style="display: inline-block; margin-right: 10px;"><a  class="btn btn-primary" href="<?php echo $sItem['link'];?>"><?php echo $sItem['text'];?></a></li>
    <?php endforeach;?>

</ul>
<form action="<?php echo $link;?>" method="post" class="searchBox">

    <select name="cat" autocomplete="off">
        <option value="0">Tất cả</option>
        <?php foreach($category as $cat):?>
            <option value="<?php echo $cat['cat_id'];?>" <?php if ($filter['cat'] == $cat['cat_id']){ echo 'selected="selected"';}?>><?php echo $cat['cat_name'];?></option>

        <?php endforeach;?>
    </select>
     <input placeholder="Giá từ:" type="text" name="pf" value="<?php echo $filter['pf'];?>" />
     <input placeholder="Đến:" type="text" name="pt" value="<?php echo $filter['pt'];?>" />
    <input type="text" name="q" value="<?php echo $filter['q'];?>" placeholder="Nhập từ khóa">
    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    <input type="hidden" name="dir" value="<?php echo $filter['dir'];?>" />
    <input type="hidden" name="sort" value="<?php echo $filter['sort'];?>" />
</form>
        <table class="table table-bordered tb_af afBox">
            <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>AF amt</th>
                <th>AF rate</th>
                <th>Category</th>
                <th>AF link</th>
                <th>Lựa chọn</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product):?>
                <tr id="af_row_<?php echo $product['pro_id'];?>">
                    <td> <?php echo $product['pro_name'];?></td>
                    <td><?php echo number_format($product['pro_cost']).' VNĐ';?></td>
                    <td><?php echo $product['af_amt'];?></td>
                    <td><?php echo $product['af_rate'];?></td>
                    <td><?php echo $product['cName'];?></td>
                    <td><a href="<?php echo $product['link'];?>">Link</a></td>
                    <td>
                        <?php if($product['isselect'] == TRUE):?>
                            <span class="btn item btn-danger">Hủy bán</span>
                        <?php else:?>
                            <span class="btn item btn-primary">Chọn bán</span>
                        <?php endif;?>

                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>
        <?php echo $pager;?>
</div>
</div>
</div>
<?php $this->load->view('home/common/footer'); ?>
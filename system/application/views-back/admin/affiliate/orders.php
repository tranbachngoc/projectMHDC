<?php $this->load->view('home/common/header'); ?>
<div class="container">
  <div id="main">
    <?php $this->load->view('home/common/left'); ?>
    <!--BEGIN: RIGHT-->
    <div class="col-lg-9">
<ul>
    <?php foreach($sort as $sItem):?>
        <li style="display: inline-block; margin-right: 10px;"><a href="<?php echo $sItem['link'];?>"><?php echo $sItem['text'];?></a></li>
    <?php endforeach;?>
</ul>
<form action="<?php echo $link;?>" method="post" class="searchBox">

    <select name="status" autocomplete="off">
        <option value="">Tất cả</option>
        <?php foreach($status as $sta):?>
            <option value="<?php echo $sta['status_id'];?>" <?php echo ( $filter['status'] == $sta['status_id']) ? 'selected="selected"' : '';?>><?php echo $sta['text'];?></option>
        <?php endforeach;?>
    </select>
    Giá từ: <input type="text" name="df" value="<?php echo $filter['df'];?>" placeholder="yyyy-mm-dd" autocomplete="off" />
    đến <input type="text" name="dt" value="<?php echo $filter['dt'];?>"  placeholder="yyyy-mm-dd" autocomplete="off" />
    <input type="submit" value="Tìm kiếm">
    <input type="hidden" name="dir" value="<?php echo $filter['dir'];?>" />
    <input type="hidden" name="sort" value="<?php echo $filter['sort'];?>" />
</form>
<table border="1">
    <thead>
    <td>Order Id</td>
    <td>Product</td>
    <td>Price</td>
    <td>qty</td>
    <td>AF Amt</td>
    <td>AF rate</td>
    <td>Update date</td>
    <td>Status</td>
    </thead>
    <tbody>

<?php foreach($orders as $order):?>
   <tr>
       <td><?php echo $order['id'];?></td>
       <td><?php echo $order['pName'];?></td>
       <td><?php echo $order['pro_price'];?></td>
       <td><?php echo $order['qty'];?></td>
       <td><?php echo $order['af_amt'];?></td>
       <td><?php echo $order['af_rate'];?></td>
       <td><?php echo $order['createdDate'];?></td>
       <td><?php echo $order['pState'];?></td>
   </tr>
<?php endforeach;?>
    </tbody>
</table>
<div class="pagination">
    <?php echo $pager;?>
</div>
</div>
</div>
</div>
<?php $this->load->view('home/common/footer'); ?>
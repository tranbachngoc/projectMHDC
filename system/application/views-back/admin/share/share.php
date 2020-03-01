<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

<tr>
  <td ><a class="item_menu_left" href="<?php echo base_url(); ?>administ/share"> <img src="<?php echo base_url(); ?>templates/home/images/icon/treesystem-icon.png" border="0" /> </a> <span class="item_menu_middle2">Thống kê chia sẻ</span></td>
</tr>
<tr>
  <td><div class="sContentBox">
      <form action="<?php echo $link; ?>" method="post" class="searchBox">
        <input class="input_search" type="text" name="q" value="<?php echo $filter['q']; ?>"
                           placeholder="Khách hàng( tên, user name, email)">
        <input class="input_search" type="text" name="p" value="<?php echo $filter['p']; ?>"
                           placeholder="Sản phẩm( tên, id)">
        <input
                        class="searchBt" type="submit" value=""/>
        <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
        <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
      </form>
      <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
        <thead>
        <td class="title_list">STT</td>
        <td class="title_list">Họ tên<a href="<?php echo $sort['name']['asc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" /> </a> <a href="<?php echo $sort['name']['desc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" /> </a></td>
          <td class="title_list">Username<a href="<?php echo $sort['username']['asc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" /> </a> <a href="<?php echo $sort['username']['desc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" /> </a></td>
          <td class="title_list">Email<a href="<?php echo $sort['email']['asc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" /> </a> <a href="<?php echo $sort['email']['desc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" /> </a></td>
          <td class="title_list">Link chia sẻ<a href="<?php echo $sort['link']['asc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" /> </a> <a href="<?php echo $sort['link']['desc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" /> </a></td>
          <td class="title_list">Số lượt xem<a href="<?php echo $sort['click']['asc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" /> </a> <a href="<?php echo $sort['click']['desc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" /> </a></td>
          <td class="title_list">Chi tiết<a href="<?php echo $sort['detail']['asc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" /> </a> <a href="<?php echo $sort['detail']['desc'];?>"> <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" /> </a></td>
            </thead>
        <tbody>
          <?php $start += 1; foreach ($list as $item): ?>
          <tr>
          	<td class="detail_list" style="text-align:center;">
              <b><?php echo $start++; ?></b>
            </td>
            <td class="detail_list"><a href="<?php echo base_url(); ?>administ/user/edit/<?php echo $item['use_id']; ?>"><?php echo $item['use_fullname']; ?></a></td>
            <td class="detail_list"><a href="<?php echo base_url(); ?>administ/user/edit/<?php echo $item['use_id']; ?>"><?php echo $item['use_username']; ?></a></td>
            <td class="detail_list"><?php echo $item['use_email']; ?></td>
            <td class="detail_list"><a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['content_title']; ?></a></td>
            <td class="detail_list"><?php echo $item['click']; ?></td>
            <td class="detail_list">
              <p><i>Trình duyệt: <?php echo $item['agent_view']; ?></i></p>
              <p><i>Thiết bị: <?php echo $item['device']; ?></i></p>
              <p><i>Địa chỉ IP: <?php echo $item['ip_use']; ?></i></p>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <tr> <td class="show_page"> <?php echo $pager; ?> </td> </tr>
    </div></td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>

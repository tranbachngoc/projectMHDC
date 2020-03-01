<div class="administrator-menu">
  <div class="drawer-hamburger">
    <span></span>
    <span></span>
    <span></span>
  </div>  
  <nav class="sm-gnav">
    <ul>
      <li class="<?php echo (!empty($menu_active) && $menu_active == 'business-news') ? 'active' : '' ?>">
        <a href="<?php echo base_url() .'azi-admin/notifications/business-news' ?>">
          <img class="icon-img" src="/templates/home/styles/images/svg/news_feed_gray.svg" alt="azibai">Bài viết doanh nghiệp
        </a>
      </li>

      <li class="<?php echo (!empty($menu_active) && $menu_active == 'personal-news') ? 'active' : '' ?>">
        <a href="<?php echo base_url() .'azi-admin/notifications/personal-news' ?>">
          <img class="icon-img" src="/templates/home/styles/images/svg/news_feed_gray.svg" alt="azibai">Bài viết cá nhân
        </a>
      </li>

      <li class="<?php echo (!empty($menu_active) && $menu_active == 'links') ? 'active' : '' ?>">
        <a href="<?php echo base_url() .'azi-admin/notifications/links' ?>">
          <img class="icon-img" src="/templates/home/styles/images/svg/link02.svg" alt="azibai">Liên kết
        </a>
      </li>

      <li class="<?php echo (!empty($menu_active) && $menu_active == 'list-user') ? 'active' : '' ?>">
        <a href="<?php echo base_url() .'azi-admin/notifications/list-user' ?>">
          <img class="icon-img" src="/templates/home/styles/images/svg/user.svg" alt="azibai" style="opacity: 0.5;
">Thành viên
        </a>
      </li>

        <li class="<?php echo (!empty($menu_active) && $menu_active == 'entertainment-link') ? 'active' : '' ?>">
            <a href="<?php echo base_url() . 'azi-admin/entertainment-link' ?>">
                <img class="icon-img" src="/templates/home/styles/images/svg/link02.svg" alt="azibai">Đề xuất
            </a>
        </li>

      <li class="<?php echo (!empty($menu_active) && $menu_active == 'index') ? 'active' : '' ?>">
        <a href="<?php echo base_url() .'azi-admin/notifications' ?>">
          <img class="icon-img" src="/templates/home/styles/images/svg/azibai_gray.svg" alt="azibai">Thông báo từ azibai
        </a>
      </li>

      <li class="<?php echo (!empty($menu_active) && $menu_active == 'money') ? 'active' : '' ?>">
        <a href="<?php echo base_url() .'azi-admin/listtransfer' ?>">
          <img class="icon-img" src="/templates/home/styles/images/svg/azibai_gray.svg" alt="azibai">Danh sách chuyển tiền
        </a>
      </li>

      <li>
        <a href="#">
          <img class="icon-img" src="/templates/home/styles/images/svg/cloud.svg" alt="azibai">Cập nhật version
        </a>
      </li>
    </ul>
  </nav>
</div>
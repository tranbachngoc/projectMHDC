<?php
$back_link = azibai_url("/page-business/{$user_id}");
if(@$_REQUEST['back'] == 1) {
  $back_link = azibai_url("/page-business/list-voucher/{$user_id}");
}
// dd($voucher_data['id']);die;
?>

<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Xem lại mã giảm giá</a>
</div>
<div class="coupon-content">
  <div class="row preview-coupon">
    <div class="col-xl-4 col-md-6">
      <div class="preview-coupon-img">
        <div class="img">
          <img src="<?=$voucher_data['sImage']?>" alt="">
        </div>
        <div class="group-action-likeshare">
          <div class="show-number-action version02">
            <ul>
              <li data-toggle="modal" data-target="#luotthich">
                <img src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt="">48</li>
              <li>15 bình luận</span>
              </li>
              <li>5 chia sẻ</span>
              </li>
            </ul>
          </div>
          <div class="action">
            <div class="action-left">
              <ul class="action-left-listaction">
                <li class="like">
                  <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like">
                </li>
                <li class="comment">
                  <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                </li>
                <li class="share-click">
                  <span>
                    <img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share">
                  </span>
                </li>
                <li>
                  <img src="/templates/home/styles/images/svg/bookmark.svg" alt="">
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-8 col-md-6">
      <div class="preview-coupon-detail">
        <div class="infor">
          <div class="box">
            <h4>Mã giảm giá
              <span class="text-red"><?=$voucher_data['iVoucherType'] == 1 ? $voucher_data['iValue'] . '%' : ($voucher_data['iVoucherType'] == 2 ? number_format($voucher_data['iValue'], 0, ',', '.') . ' VNĐ' : 0)?></span>
            </h4>
            <?php if($voucher_data['iProductType'] == 2) { ?>
            <p>Áp dụng cho <?=$voucher_data['iCountProduct']?> sản phẩm
              <a href="javascript:void(0)" class="btn-see-product js-show-product">Xem sản phẩm</a>
            </p>
            <?php } else { ?>
            <p>Áp dụng cho tất cả sản phẩm của shop:
              <span class="text-red">Cửa hàng mua sắm trực tuyến</span>
            </p>
            <p>Giá trị đơn hàng tối thiểu: <?=$voucher_data['iPriceRank'] ? number_format($voucher_data['iPriceRank'], 0, ',', '.') : 0 ?> VNĐ</p>
            <?php } ?>
            <div class="time">
              <p>
                <strong>Thời gian áp dụng:</strong>
              </p>
              <p><?=date('H:i d-m-Y', $voucher_data['iTimeStart'])?> đến <?=date('H:i d-m-Y', $voucher_data['iTimeEnd'])?></p>
            </div>
          </div>
          <table>
            <tr>
              <th>Số lượng</th>
              <td><?=$voucher_data['iQuantily'] ? number_format($voucher_data['iQuantily'], 0, ',', '.') : 0 ?></td>
            </tr>
            <tr>
              <th>Bán hộ</th>
              <td><?=$voucher_data['sApply']?></td>
            </tr>
            <tr>
              <th>Giá niêm yết</th>
              <td>
                <span class="cost-price"><?=$voucher_data['iPrice'] ? number_format($voucher_data['iPrice'], 0, ',', '.') : 0 ?> VNĐ</span>
              </td>
            </tr>
            <tr>
              <th>Ưu đãi</th>
              <td>
                <span class="text-red"><?=$voucher_data['iPriceDiscount'] ? number_format($voucher_data['iPrice'] - $voucher_data['iPriceDiscount'], 0, ',', '.') . ' VNĐ' : number_format($voucher_data['iPrice'], 0, ',', '.') . ' VNĐ' ?></span>
              </td>
            </tr>
            <tr>
              <th>Hoa hồng cho nhà phân phối</th>
              <td><?=$voucher_data['iAffiliateType'] == 1 ? $voucher_data['iPrice_level_1'] . '%' : ($voucher_data['iAffiliateType'] == 2 ? number_format($voucher_data['iPrice_level_1'], 0, ',', '.') . ' VNĐ' : '')?></td>
            </tr>
            <tr>
              <th>Hoa hồng cho tổng đại lý</th>
              <td><?=$voucher_data['iAffiliateType'] == 1 ? $voucher_data['iPrice_level_2'] . '%' : ($voucher_data['iAffiliateType'] == 2 ? number_format($voucher_data['iPrice_level_2'], 0, ',', '.') . ' VNĐ' : '')?></td>
            </tr>
            <tr>
              <th>Hoa hồng cho đại lý</th>
              <td><?=$voucher_data['iAffiliateType'] == 1 ? $voucher_data['iPrice_level_3'] . '%' : ($voucher_data['iAffiliateType'] == 2 ? number_format($voucher_data['iPrice_level_3'], 0, ',', '.') . ' VNĐ' : '')?></td>
            </tr>
          </table>
        </div>
        <div class="text-center">
          <div class="btn-finish">Kết thúc trước thời hạn</div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if($voucher_data['iProductType'] == 2) { ?>
<script>
  $('.js-show-product').click(function () {
    <?php
      $_REQUEST['prolist'] = 1;
      $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
    ?>
    url = '<?=$url?>';
    window.location.href = url;
  });
</script>
<?php } ?>
<script>
  localStorage.clear();
</script>
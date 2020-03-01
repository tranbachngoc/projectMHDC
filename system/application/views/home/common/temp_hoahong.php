<?php
$session = $this->session->userdata('sessionUser');
$show_CTV = $item->hoahong['showIcon'];
$typeIcon = $item->hoahong['typeIcon'];
$icon = '';
$pro_affiliate_value = -1;

if(isset($item->hoahong))
{
  if(isset($item->hoahong['hoahongLogin']))
  {
    $pro_affiliate_value = $item->hoahong['hoahongLogin'];
  }
  if(isset($item->hoahong['hoahongShare']))
  {
    $pro_affiliate_value = $item->hoahong['hoahongShare'];
  }
}

switch ($typeIcon) {
  case 1:
  case 3:
    $txtIcon = 'Đăng ký trở thành cộng tác viên của doanh nghiệp <b>'.$item->Shopname.'</b>';
    $icon = 'Đăng ký';
    $btn = $item->hoahong['registerAff'];
    break;
  case 2:
    $txtIcon = 'Đăng ký tham gia';
    $icon = 'Tham gia';
    break;
}

if($af_id != ''){
  $af_id = '?af_id='.$af_id;
}

$iconCtv = 'CTV_add.svg';
if(isset($session))
{
    $iconCtv = 'CTV.svg';
}
?>

<?php if($show_CTV == true && $session != $item->pro_user) { ?>
  <?php
  if($pro_affiliate_value == 0 || $pro_affiliate_value == -1)
  {
  ?>
    <span class="textAff-<?php echo $item->pro_id; ?> hidden"><?php echo $txtIcon ?></span>
  <?php
  }
  ?>
    <div class="btn-selectsale-<?=$item->pro_id?> hidden">
        <a class="btn btn-default mr10" href="<?php echo $btn ?>" target="_blank" alt="<?php echo $txtIcon ?>" style="background: #0606b1a8; border-radius: 5px; padding: 8px; color: #fff;">
            <?php echo $icon ?>
        </a>
    </div>
    <div class="ctv js-ctv js_get-pop-commission"
      data-product="<?=$item->pro_id?>"
      data-commission="<?=$pro_affiliate_value?>"
      data-domain="<?=azibai_url()?>"
      data-select="<?=$is_select_af_pro ? 'true' : 'false'?>"
      data-url="<?php echo azibai_url().'/'.$item->pro_category.'/'.$item->pro_id.'/'.RemoveSign($item->pro_name).$af_id ?>"
      data-quycach="<?php if ($item->have_num_tqc > 0) { echo 1; }?>"
      data-value="<?php echo json_encode($item->hoahong)?>"
      >
      <a href="javascript:void(0)">
        <img class="img-ctv1" src="/templates/home/styles/images/svg/<?php echo $iconCtv; ?>" alt="">
      </a>
    </div>
<?php } ?>
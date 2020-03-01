<div class="col-md-6">
  <div class="item">
    <p>
      <strong>Ngân hàng:</strong> <?=$item['bank_name']?>
      <br>
      <strong>Tài khoản:</strong> <?=$item['account_number']?>
      <br>
      <strong>Tên tài khoản:</strong> <?=$item['account_name']?>
      <br>
      <strong>Chi nhánh:</strong> <?=$item['aff']?>
    </p>
    <div class="icon-edit">
      <img src="/templates/home/styles/images/svg/pen_black.svg" alt="" data-id="<?=$item['id']?>" data-type="bank" class="js-edit-bank">
      <img src="/templates/home/styles/images/svg/delete.svg" alt="" data-id="<?=$item['id']?>" class="js-delete-bank">
    </div>
  </div>
</div>
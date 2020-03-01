<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<?php
$id_af=$_REQUEST['share'];
 ?>
<script>
$( document ).ready(function() {
   $( "a" ).each(function() {
    if($( this ).attr('href')!='#' && $( this ).attr('href')!=''){
        var link=$( this ).attr('href');
        $( this ).attr('href', link+'?af_id=<?php echo $id_af ?>');
    }

});
});

</script>
<script>
    /*document.write('2');
    $('a').each(function (index, value)
    {
        $('a').attr('title','Học Web Chuẩn');
        var link = $(this).attr('href');
        $('a').attr('title','abc');
        document.write(link);
        if (link.indexOf('http://') === 0) {
         document.write('3');
        console.log(link);
      }
      alert('2');
    });
    $( "a" ).each(function() {
    $( this ).attr('href','?af_id=4cc08c6cc6cef3c839c08236a6d8f41e');
  });*/
</script>
<?php

if($_REQUEST['email'] != "") {
    echo $_REQUEST['email'];
    if ($success == 1) {
        ?>
        <div
            style="color: #3c763d; background-color: #dff0d8; border: 1px solid #d6e9c6; padding: 15px; text-align: center; border-radius: 4px;">
            Đăng ký nhận email thành công!
        </div>
    <?php } else { ?>
        <div
            style="text-align: center;color: #a94442;background-color: #f2dede; border: 1px solid #ebccd1; padding: 15px;">
            <?php if ($message == 'The subscriber already exists in this list.')
                echo "Email này đã tồn tại. Cảm ơn bạn!";
            else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            } ?>
        </div>
    <?php }
}
?>
<?php
$changedLink = str_replace('="/','="'.base_url(), $landing->html);
$enc = mb_detect_encoding($changedLink, "UTF-8,ISO-8859-1");
$text =  iconv($enc, "UTF-8", $changedLink);
echo str_replace('mÂ²','m²', $text);

?>

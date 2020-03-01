<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: LEFT-->
<?php
if($_SERVER['HTTP_REFERER']!=base_url()."login")
{
	$_SESSION['previous_page']=$_SERVER['HTTP_REFERER'];
}
?>
    <div class="tile_modules tile_modules_blue row col-lg-12">
            <?php echo $this->lang->line('title_logout'); ?>
    </div>
<div class="text-center">
    <font color="#FF0000"><b> Chúng tôi sẽ đưa bạn về trang trước trong 1 giây </b></font>
<!--    <p class="text-center"><a href="--><?php //echo base_url().'login'; ?><!--">Click vào đây để tiếp tục</a></p>-->
</div>
<!--    <table width="100%" border="0" cellpadding="0" cellspacing="0">-->
<!--        <tr>-->
<!--            <td valign="top" >-->
<!--                <table width="500" class="form_main" border="0" align="center" cellpadding="0" cellspacing="0">-->
<!--                    <tr>-->
<!--                        <td height="20" class="form_top"></td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td class="success_post">-->
<!--                            <p class="text-center"><a href="--><?php //echo $_SESSION['previous_page']; ?><!--">Click vào đây để tiếp tục</a></p>-->
<!--                            <ul class="huongdanlogin">-->
<!--                            --><?php //$contentFooter=Counter_model::getArticle(thongbao_out); echo html_entity_decode($contentFooter->not_detail);?>
<!--                            	<li >-->
<!--                                   <font color="#FF0000"><b> Nếu không chúng tôi sẽ đưa bạn về trang trước trong 1 giây </b></font>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        -->
<!--						</td>-->
<!--					</tr>-->
<!--                    <tr>-->
<!--                        <td height="25" class="form_bottom"></td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--            </td>-->
<!--        </tr>-->
<!--    </table>-->
<!--END LEFT-->
<?php //$this->load->view('home/common/info'); ?>
<?php $this->load->view('home/common/footer'); ?>
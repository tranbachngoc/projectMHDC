
<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->

<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
    <div class="tile_modules tile_modules_blue"><?php echo $this->lang->line('title_contact_detail'); ?></div>
        <table class="table table-bordered">
            <tr>
                <td  height="50" class="header_contact_account">
                    <!-- tieu de tin nhan -->
                    <h3><?php echo $contact->con_title; ?></h3>
                    <!-- thoi gian gui -->
                    <span>(<?php echo $this->lang->line('date_contact_contact_detail'); ?>&nbsp;<?php echo date('d-m-Y', $contact->con_date_contact); ?>)</span>
                </td>
            </tr>
            <tr>
                <td class="content_contact_account"><?php echo  $this->bbcode->light($contact->con_detail); ?></td>
            </tr>
            <tr>
                <td>
                    <strong>Trả lời:</strong>
                    <form name="frmContactAccount" method="post" action="<?php echo base_url(); ?>account/contact/reply/<?php echo $contact->con_id?>">
                        <?php $this->load->view('home/common/editor'); ?>
                        <div class="form-group">
                            <input type="submit" value="<?php echo $this->lang->line('button_send_contact_send'); ?>" class="button_form btn btn-azibai" />
                        </div>
                    </form>
                </td>
            </tr>
        </table>
</div>
    </div>
 </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
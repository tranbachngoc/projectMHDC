<div class="module module-new">
<?php
switch ($siteGlobal->sho_style) {
	case 'default':
		$this->load->view('shop/common/blognews/default');
		break;
	case 'style1':
		$this->load->view('shop/common/blognews/style1');
		break;
	case 'style2':
		$this->load->view('shop/common/blognews/style2');
		break;
	case 'style3':
		$this->load->view('shop/common/blognews/style3');
		break;
	case 'style4':
		$this->load->view('shop/common/blognews/style4');
		break;
	case 'style5':
		$this->load->view('shop/common/blognews/style5');
		break;
}
?>
</div>
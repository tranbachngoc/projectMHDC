<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Information extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		#CHECK SETTING
		if((int)settingStopSite == 1)
		{
            $this->lang->load('home/common');
			show_error($this->lang->line('stop_site_main'));
			die();
		}
		#END CHECK SETTING
		
	}
	
	function index()
	{
        if($this->input->post('type') && $this->input->post('token') && $this->input->post('token') == md5(date('dmY')))
        {
            switch((int)$this->input->post('type'))
            {
                case 1:
                    #BEGIN: Get content - Gia vang
                    $source = 'http://www.laodong.com.vn/Services/Infopage.aspx?svc=goldrates';
                    $content = @file_get_contents($source);
                    $begin = stripos($content, '<table cellspacing="0" cellpadding="4" rules="all" bordercolor="#CC9966" border="1" id="_ctl0_rContent_dgGoldRates" bgcolor="White">');
                    $end = stripos($content, '</table>');
                    $firstExpand = '';
                    $lastExpand = '</table>';
                    $content = @substr($content, $begin, $end - $begin);
                    echo $firstExpand.str_ireplace('id="_ctl0_rContent_dgGoldRates"', 'style="width:100%;"', $content).$lastExpand;
                    #END Get content - Gia vang
                    break;
                case 2:
                    #BEGIN: Get content - Ngoai te
                    $source = 'http://www.laodong.com.vn/Services/Infopage.aspx?svc=exchangerates';
                    $content = @file_get_contents($source);
                    $begin = stripos($content, '<table cellspacing="0" cellpadding="4" rules="all" bordercolor="#CC9966" border="1" id="_ctl0_rContent_dgExchangeRates" bgcolor="White">');
                    $end = stripos($content, '</table>');
                    $firstExpand = '';
                    $lastExpand = '</table>';
                    $content = @substr($content, $begin, $end - $begin);
                    echo $firstExpand.str_ireplace('id="_ctl0_rContent_dgExchangeRates"', 'style="width:100%;"', $content).$lastExpand;
                    #END Get content - Ngoai te
                    break;
                case 3:
                    #BEGIN: Get content - Chung khoan
                    $source = 'http://www.laodong.com.vn/Services/Infopage.aspx?svc=securities';
                    $content = @file_get_contents($source);
                    $begin = stripos($content, '<TABLE id="Table2" align="center">');
                    $end = strripos($content, '<SCRIPT>');
                    $firstExpand = '';
                    $lastExpand = '';
                    $content = @substr($content, $begin, $end - $begin);
                    echo $firstExpand.str_ireplace('id="Table2"', 'style="width:100%;"', $content).$lastExpand;
                    #END Get content - Chung khoan
                    break;
                case 4:
                    #BEGIN: Get content - Thoi tiet
                    $source = 'http://www.nchmf.gov.vn/website/vi-VN/81/Default.aspx';
                    $content = @file_get_contents($source);
                    $begin = stripos($content, '<table width="100%" border="1" cellspacing="0" cellpadding="0" style="BORDER-COLLAPSE: collapse"');
                    $end = strripos($content, '<td class="right_ver_box"></td>');
                    $firstExpand = '';
                    $lastExpand = '';
                    $content = @substr($content, $begin, $end - $begin - 10);
                    $content = str_ireplace('bordercolor="#00A9E0"', 'bordercolor="#CC9966" border="1"', $content);
                    $content = str_ireplace('align="center"><strong>', 'align="left"><strong>', $content);
                    $content = str_ireplace('<tr class="thoitiet_hientai">', '<tr bgcolor="#990000" height="24" style="color:#FFF;">', $content);
                    $content = str_ireplace('width="100%" border="0"', 'width="100%" bordercolor="#CC9966" border="1"', $content);
                    $content = str_ireplace('class="thoitiet_hientai rightline"', 'style="color:#330099;"', $content);
                    $content = str_ireplace('class="thoitiet_hientai"', 'style="color:#330099;"', $content);
                    echo $firstExpand.$content.$lastExpand;
                    #END Get content - Thoi tiet
                    break;
                case 5:
                    #BEGIN: Get content - Lich truyen hinh
                    $source = 'http://www.laodong.com.vn/Services/Infopage.aspx?svc=tvschedules';
                    $content = @file_get_contents($source);
                    $begin = stripos($content, '<table cellspacing="0" cellpadding="4" rules="all" bordercolor="#CC9966" border="1" id="_ctl0_rContent_dgTvPrograms" bgcolor="White">');
                    $end = strripos($content, '<SCRIPT>');
                    $firstExpand = '';
                    $lastExpand = '';
                    $content = @substr($content, $begin, $end - $begin);
                    echo $firstExpand.str_ireplace('id="_ctl0_rContent_dgTvPrograms"', 'style="width:100%;"', $content).$lastExpand;
                    #END Get content - Lich truyen hinh
                    break;
                default:
                    #BEGIN: Get content - Xo so kien thiet
                    $source = 'http://www.laodong.com.vn/Services/Infopage.aspx?svc=lotteryresults';
                    $content = @file_get_contents($source);
                    $begin = stripos($content, '<table cellspacing="0" cellpadding="4" rules="all" bordercolor="#CC9966" border="1" id="_ctl0_rContent_dgLR" bgcolor="White">');
                    $end = strripos($content, '<SCRIPT>');
                    $firstExpand = '';
                    $lastExpand = '';
                    $content = @substr($content, $begin, $end - $begin);
                    echo $firstExpand.str_ireplace('id="_ctl0_rContent_dgLR"', 'style="width:100%;"', $content).$lastExpand;
                    #END Get content - Xo so kien thiet
            }
        }
        else
        {
            show_404();
        }
	}
}
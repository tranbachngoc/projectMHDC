<?php $this->load->view('home/common/header_iframe'); ?>
   <table width="100%"  height="29" cellspacing="0" cellpadding="0" border="0" align="center" >
                    <tbody><tr>
                     <td width="5%" class="title_boxads_1">
                          STT                   
                        </td>
                           <td width="30%" class="title_boxads_1">
                           Tin                     
                        </td>
                        <td width="15%" class="title_boxads_1">
                           Loại                     
                        </td>
                    
                        <td width="15%" class="title_boxads_1 title_boxads_2">
                           Thời Gian Chạy
                        </td>
                       
                     
                    </tr>
                    <?
                       
					   $stt=1;
					    foreach($tinup as $row){ 
						$loaiTin = "Sản Phẩm ";
						$url = "";
						if($row->type=="2"){
							$loaiTin = "Rao Vặt";
							$url = "";
						}
					?>
                    
                    <tr id="DivRowReliableAds" style="background:#F1F9FF">
                        <td class="line_boxads_1">
                                <? echo $stt++;?>                
                        </td>
                        <td class="line_boxads_1">
                              <a href="<? echo $url; ?>"><? echo $row->title;?>                           </a>
                        </td>
                         <td class="line_boxads_1" style="text-align:center">
                                       <? echo $loaiTin;?>                
                        </td>
                      
                        <td class="line_boxads_1" style="text-align:center">
                                   <? echo $row->date_time;?>                 
                        </td>
                       
                       
                    </tr>
                    
                    <?
					   }
					?>
                </tbody></table>
      
      <?php $this->load->view('home/common/footer_iframe'); ?>
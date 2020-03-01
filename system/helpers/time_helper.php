<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('show_time'))
{
	function show_time($time)
	{
		$timestamp = strtotime($time);	
		$current=time();
		
		if($current>$timestamp){
			$checkTime = date('Y-m-d',$timestamp);
			$checkCurrent = date('Y-m-d',$current);
									
			if($checkTime == $checkCurrent) {  // Cùng ngày
			
			
				if(round(($current-$timestamp)/3600)<=12){
					
					return date('H',$timestamp)." giờ ".date('i',$timestamp)." phút trước";	
					
				}
				if(round(($current-$timestamp)/3600)>=12){
					return "Hôm nay, lúc ".date('H:i',$timestamp);	
					
				}
			}else{ // Khác ngày
				if(round(($current-$timestamp)/3600)<=24){
															  					
					return "Hôm qua, lúc ".date('H:i',$timestamp);	
				}
				if(round(($current-$timestamp)/3600)>=24){
										
					return  date('d/m/Y - H:i',$timestamp);	
					
				}
				
			}
			
		}else{
			
			return 0;	
		}
		
		
	}
}

<?php
/**
 * PHP Class to get a website Alexa Ranking
 * @author http://www.paulund.co.uk
 *
 */
class Get_Alexa_Ranking{
	/**
	 * Get the rank from alexa for the given domain
	 *
	 * @param $domain
	 * The domain to search on
	 */
	public function get_rank($domain){
		$url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$domain;
		//Initialize the Curl
		$ch = curl_init();  
		//Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2); 
		//Set the URL
		curl_setopt($ch, CURLOPT_URL, $url);  
		//Execute the fetch
		$data = curl_exec($ch);  
		//Close the connection
		curl_close($ch);  
		$xml = new SimpleXMLElement($data);  
                //Get popularity node
		$popularity = $xml->xpath("//POPULARITY");
                //Get the Rank attribute
		$rank = (string)$popularity[0]['TEXT']; 
		return $rank;
	}
	public function GetDomain($url)
	{
		$nowww = preg_replace('/www\./','',$url);
		$domain = parse_url($nowww);
		if(!empty($domain["host"]))
		{
		 	return $domain["host"];
		} else
		{
			return $domain["path"];
		}
	}
}
?>
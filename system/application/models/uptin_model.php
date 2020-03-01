<?
class Uptin_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_user");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	function getOrderId($order_id){
        $this->db->cache_off();
		$this->db->select("order_id");
		$this->db->where("order_id = \"".$order_id."\"");
		#Query
		$query = $this->db->get("tbtt_account_thongkegiaodich");
		$result = $query->row();
		$query->free_result();
		return $result;	
	}
	function getgiaodichtype($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_account_giaodichtype");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	function getgiaodich($select = "*", $where = "", $sort, $by, $start = -1, $limit = 0)
	{
        $sql = "select ".$select ." FROM tbtt_account_thongkegiaodich g
INNER JOIN tbtt_account_giaodichtype t ON g.type = t.id
INNER JOIN tbtt_user u ON u.use_id = g.user_id where 0=0 ".$where." order by $sort $by";	
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$sql .= " limit $start, $limit";
		}	
		
		$query = $this->db->query($sql);		
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	
	function insertWallet($username,$amount,$comment,$order_id=0){
		
		$user = $this->get($select = "use_id", $where = "use_username like '".$username."'");
		//echo "<pre>".$amount." va ";print_r($user);echo "</pre>";die();
		
		if($user->use_id>0 && $amount > 0){
			if($order_id)
				$query	=	"INSERT INTO tbtt_account_thongkegiaodich VALUES (NULL,\"".$order_id."\",".$user->use_id.",'+',".($amount*10000).",3,'".date('Y-m-d H:i:s',time())."',1, '".$comment."')";
			else
			$query	=	"INSERT INTO tbtt_account_thongkegiaodich VALUES (NULL,0,".$user->use_id.",'+',".($amount*10000).",3,'".date('Y-m-d H:i:s',time())."',1, '".$comment."')";
			$this->db->query($query);
			return 1;			
		}
		return 0;
		
	}
	function withdrawal($user_id,$amount,$comment,$type){

		
		if($user_id>0 && $amount > 0){
			$query	=	"INSERT INTO tbtt_account_thongkegiaodich VALUES (NULL,'',".$user_id.",'-',".$amount.",".$type.",'".date('Y-m-d H:i:s',time())."','1', '".$comment."')";
			$this->db->query($query);
			return 1;			
		}
		return 0;
		
	}
	function add($data)
	{
		return $this->db->insert("tbtt_account_lich_uptin", $data);
	}
	function getBalanceByUserId($user_id)
	{
	
		$sql = "SELECT SUM(amount) as plus FROM tbtt_account_thongkegiaodich WHERE prefix='+' AND user_id=".$user_id;

	
		$query = $this->db->query($sql);	
		$plus = $query->result();
		
		
		$sql = "SELECT SUM(amount) as minus FROM tbtt_account_thongkegiaodich WHERE prefix='-' AND user_id=".$user_id;
		$query = $this->db->query($sql);	
		$minus = $query->result();

		return $plus[0]->plus - $minus[0]->minus; 			
			
	}
	
	function checkid($type,$id){
		$sql = "select ads_id from tbtt_ads where ads_id = ".$id;
		if($type =1){
			$sql = "select pro_id from tbtt_product where pro_id = ".$id;
		}
		
		$query = $this->db->query($sql);	
		$result = $query->result();
		return $result;
	}
	
	function GetGiaTienUpTin(){
		$sql = "select price from tbtt_define_rate where id = 1 ";			
		$query = $this->db->query($sql);	
		$result = $query->result();
		return $result[0]->price;
	}
	
	function SotienUptintrenlan($sotien){	
	
		$query	=	"UPDATE tbtt_define_rate set price  = ".(int)$sotien." where id = 1";

		$this->db->query($query);
		return 1;
	}


	
	function getLichUpTin($user_id)
	{
        $this->db->cache_off();
		$sql = "SELECT a . * , b.ads_title title, b.ads_category AS cat_id
FROM tbtt_account_lich_uptin a
INNER JOIN tbtt_ads b ON a.tin_id = b.ads_id
WHERE a.type =2 and use_id = $user_id
UNION
SELECT a . * , b.pro_name title, b.pro_category AS cat_id
FROM tbtt_account_lich_uptin a
INNER JOIN tbtt_product b ON a.tin_id = b.pro_id
WHERE a.type =1 and use_id = $user_id
";
	$query = $this->db->query($sql);	
		$result = $query->result();
		$query->free_result();
		return $result;
	}
		function getChiTietUpTin($lich_id)
	{
        $this->db->cache_off();
		$sql = "SELECT a . * , b.ads_title title, b.ads_category AS cat_id
FROM tbtt_account_uptin a
INNER JOIN tbtt_ads b ON a.tin_id = b.ads_id
WHERE a.type =2 and a.lich_id = $lich_id
UNION
SELECT a . * , b.pro_name title, b.pro_category AS cat_id
FROM tbtt_account_uptin a
INNER JOIN tbtt_product b ON a.tin_id = b.pro_id
WHERE a.type =1 and a.lich_id = $lich_id
";
	$query = $this->db->query($sql);	
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	function uptin($tin_id,$type){
		$query = "";
		if($type == 1){
			$query	=	"UPDATE tbtt_product set up_date = now() where 	pro_id = $tin_id";
		}else{
			$query	=	"UPDATE tbtt_ads set up_date = now() where 	ads_id = $tin_id";
		}
			
		$this->db->query($query);
		return 1;
	}
	
	/*function updateNaptien($value,$id){
		$query = "";
		if($value >0 && $id>0 ){
			$query	=	"UPDATE tbtt_account_thongkegiaodich set amount = ".$value." where id = ".$id;
			$this->db->query($query);
			echo  "1";
		}					
		
		//return 0;
	}*/
	
	function getLichUp($thu,$gio)
	{
        $this->db->cache_off();
		$sql	=	"SELECT * FROM tbtt_account_lich_uptin where so_lan_up >0 and `thu` LIKE '%$thu%'
AND gio LIKE '%$gio%'";
	
		$query = $this->db->query($sql);	
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	function minusLichUp($lich_id)
	{
        $this->db->cache_off();
		$sql	=	"UPDATE tbtt_account_lich_uptin set so_lan_up  = (so_lan_up-1)  where 	id = $lich_id";

		$query = $this->db->query($sql);	
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	
}

?>
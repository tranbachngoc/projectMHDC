<?php
#****************************************#
# * @Author: nguyenvanphuc                   #
# * @Email: nguyenvanphuc0626@gmail.com          #
# * @Website: http://www.phucdevelop.net  #
#****************************************#
class Restapi extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('shop_model');
                
        $this->load->library('RestApiClient');
        $this->RestApiClient = new RestApiClient();
    }
    
    private function buildPrice($pro_id,$pro_qty){
        $pro            = $this->product_model->get('*,'.DISCOUNT_QUERY, array('pro_id'=>$pro_id));
        $discount       = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), false);
        $em_discount    = 0;
        $this->load->model('product_promotion_model');
        $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id'=>$pro_id, 'qty'=> $pro_qty, 'total'=>($discount['salePrice'] * $pro_qty)));
        if(!empty($promotion)){
            if($promotion['dc_rate'] > 0){
                $em_discount = $discount['salePrice'] *$pro_qty * $promotion['dc_rate'] / 100;
            }else{
                $em_discount = $promotion['dc_amt'];
            }
        }
        $price = $discount['salePrice'] * $pro_qty - $em_discount;
        unset($discount);
        return $price;
    }

    public function updateOrderVTP(){
        $this->load->model('viettelpost_model');
        $return = $this->viettelpost_model->VTPUpdate();
        echo json_encode($return); exit();
    }

    public function updateOrderGHTK(){
        $this->load->model('ghtietkiem_model');
        $return = $this->ghtietkiem_model->GHTKUpdate();        
        echo json_encode($return); exit();
    }

    public function apiGHN(){
        $serviceClient  =   $this->RestApiClient->connectGHN();
        $sessionToken   =   $serviceClient->SignIn();
        $serviceClient->SignOut();
        $arrProduct     =   array();
        $total          =   0;
        $total_vc       =   0;
        $cart           =   $this->session->userdata('cart');
        
        foreach($cart as $k => $_vals){
            foreach($_vals as $key => $vals){
                $shop       = $this->shop_model->find_by(array('sho_id'=>$vals['sho_id']),'sho_district');
                $productInfo= $this->product_model->fetch('pro_id,pro_name,pro_cost,pro_weight,pro_length,pro_width,pro_height','pro_id = "'.$vals['pro_id'].'"');
                $price      = $this->buildPrice($vals['pro_id'],$vals['qty']);

                if ($sessionToken){
                        foreach(json_decode(ServiceID) as $ks => $vls){
                            $items[] = array(
                                "FromDistrictCode"  =>  $shop[0]->sho_district,
                                "ServiceID"         =>  $ks,
                                "ToDistrictCode"    =>  $this->input->post('district'),
                                "Weight"            =>  ($productInfo[0]->pro_weight)?$productInfo[0]->pro_weight:'0',
                                "Length"            =>  ($productInfo[0]->pro_length)?$productInfo[0]->pro_length:'0',
                                "Width"             =>  ($productInfo[0]->pro_width)?$productInfo[0]->pro_width:'0',
                                "Height"            =>  ($productInfo[0]->pro_height)?$productInfo[0]->pro_height:'0',
                            );

                            $calculateServiceFeeRequest     = array("SessionToken" => $sessionToken, "Items" => $items);
                            $responseCalculateServiceFee    = $serviceClient->CalculateServiceFee($calculateServiceFeeRequest);
                            
                            if($responseCalculateServiceFee['Items'][0]['ServiceFee'] != '-1'){
                                $ghn_ServiceID = $ks;
                                break;
                            }
                            unset($items);
                            unset($responseCalculateServiceFee);
                        }
                        $arr = array(
                            'pro_id'                    =>  $productInfo[0]->pro_id,
                            'product_name'              =>  $productInfo[0]->pro_name,
                            'code'                      =>  '1',
                            'ServiceFee'                =>  $responseCalculateServiceFee['Items'][0]['ServiceFee'],
                            'ServiceName'               =>  $responseCalculateServiceFee['Items'][0]['ServiceName'],
                            'ErrorMessage'              =>  $responseCalculateServiceFee['ErrorMessage']
                        );
                        $total                          = $total + $price + $responseCalculateServiceFee['Items'][0]['ServiceFee'];
                        $total_vc                       = $total_vc + $responseCalculateServiceFee['Items'][0]['ServiceFee'];
                } else {
                    $arr = array(
                        'code'              =>  '-1',
                        'ErrorMessage'      =>  'Client and Password are incorrect'
                    );
                }

                //Update shipfee to cart
                $cart = $this->session->userdata('cart');
                foreach ($cart as &$cItems) {
                    if (!empty($cItems)) {
                        foreach ($cItems as $k => $cp) {
                            if($cp['pro_id'] == $vals['pro_id']){
                                $cItems[$k]['shipping_fee'] = $responseCalculateServiceFee['Items'][0]['ServiceFee'];
                                $cItems[$k]['qty']          = $vals['qty'];
                                $cItems[$k]['ghn_ServiceID']= $ghn_ServiceID;
                            }
                        }
                    }
                }
                $this->session->set_userdata('cart', $cart); 
                $arrProduct[] = $arr;
            }
            unset($responseCalculateServiceFee);
        }
        $arrProduct = array(
            'total'         =>  $total,
            'total_vc'      =>  $total_vc,
            'arrProduct'    =>  $arrProduct
        );
        
        echo json_encode($arrProduct);exit;
    }   
}
<?php
namespace App;
class Cart{
    public $products = null;
    public $voucher = null;
    public $infoUser = null;
    public $deliveryMethod = null;

    public function __construct($cart)
    {
        if($cart){
            $this->products = $cart->products;
            $this->voucher = $cart->voucher;
            $this->infoUser = $cart->infoUser;
            $this->deliveryMethod = $cart->deliveryMethod;
        }
    }

    public function addCart($product,$id){
        $newProduct = ['quantity'=> 0, 'productInfo'=>$product];
        if($this->products){
            if(array_key_exists($id,$this->products)){
                $newProduct = $this->products[$id];
            }
        }
        $newProduct['quantity']++;
        $this->products[$id] = $newProduct;
    }

    public function deleteItemCart($id){
        unset($this->products[$id]);
    }

    public function plusItemCart($id){
        $this->products[$id]['quantity']++;
    }

    public function minusItemCart($id){
        $this->products[$id]['quantity']--;
    }

    public function addVoucher($code){
        $this->voucher = $code;
    }

    public function infoUser($hoTen,$gioiTinh,$sdt,$diaChi){
        $newInfoUser = ['hoTen'=>$hoTen, 'gioiTinh'=>$gioiTinh,'sdt' => $sdt,'diaChi'=>$diaChi];
        $this->infoUser = $newInfoUser;
    }

    public function deliveryMethod($cachThucNhan,$ghiChu,$cuaHangId){
        $newDeliveryMethod = ['cachThucNhan'=>$cachThucNhan,'ghiChu'=>$ghiChu,'cuaHangId'=>$cuaHangId];
        $this->deliveryMethod = $newDeliveryMethod;
    }
}
?>

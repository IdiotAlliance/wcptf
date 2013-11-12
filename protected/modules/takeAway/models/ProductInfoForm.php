<?php
    /**
     * @author  luwenbin
     */
    
class ProductInfoForm extends CFormModel
{
    public $pname;
    public $price;
    public $credit;
    public $description;
    public $stime;
    public $etime;
    public $instore;
    public $richtext;

    public function rules()
    {
        return array(
            array('pname', 'required', 'message'=>'请选择商家类型'),
            array('price', 'required', 'message'=>'请选择商家类型'), 
            array('credit', 'required', 'message'=>'请选择商家类型'),
            array('description', 'required', 'message'=>'请选择商家类型'),
            array('stime', 'required', 'message'=>'请选择商家类型'),
            array('etime', 'required', 'message'=>'请选择商家类型'),            
            array('instore', 'required', 'message'=>'请选择商家类型'),   
        );
    }

    public function attributeLabels()
    {
        return array(
            'pname'=>'商家类型',
            'price'=>'价格',
            'credit'=>'积分',
            'description'=>'商品描述',
            'stime'=>'起始时间',
            'etime'=>'结束时间',
            'instore'=>'库存',
        );
    }

}

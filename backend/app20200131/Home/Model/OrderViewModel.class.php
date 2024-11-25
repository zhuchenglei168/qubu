<?php
namespace Home\Model;
use Think\Model\ViewModel;
class OrderViewModel extends ViewModel {
	public $viewFields = array(
		'Order' => array('id', 'user_id', 'product_id', 'trade_no', 'money', 'create_time', 'pay_time', 'status', '_type'=>'LEFT', '_as'=>'Orders'),
		'Product' => array('title', 'num', 'type', 'profit', '_on'=>'Product.id=Orders.product_id'),
	);
}
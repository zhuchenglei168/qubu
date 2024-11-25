<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class OrderViewModel extends ViewModel {
	public $viewFields = array(
		'Order' => array('id', 'user_id', 'product_id', 'trade_no', 'money', 'create_time', 'pay_time', 'status', '_type'=>'LEFT', '_as'=>'Orders'),
		'Product' => array('title', '_on'=>'Product.id=Orders.product_id', '_type'=>'LEFT'),
		'User' => array('phone', '_on'=>'User.id=Orders.user_id'),
	);
}
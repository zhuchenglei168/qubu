<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class DistribViewModel extends ViewModel {
	public $viewFields = array(
		'Distrib' => array('id', 'user_id', 'order_id', 'level', 'money', 'create_time', '_type'=>'LEFT'),
		'Order' => array('user_id'=>'order_user_id', 'trade_no', '_on'=>'Orders.id=Distrib.order_id', '_type'=>'LEFT', '_as'=>'Orders'),
		'User' => array('phone', '_on'=>'User.id=Distrib.user_id'),
	);
}
<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class ProfitViewModel extends ViewModel {
	public $viewFields = array(
		'Profit' => array('id', 'user_id', 'order_id', 'num', 'money', 'create_time', 'freeze_time', 'success_time', 'status', '_type'=>'LEFT'),
		'Order' => array('user_id'=>'order_user_id', 'trade_no', '_on'=>'Orders.id=Profit.order_id', '_type'=>'LEFT', '_as'=>'Orders'),
		'User' => array('phone', '_on'=>'User.id=Profit.user_id'),
	);
}
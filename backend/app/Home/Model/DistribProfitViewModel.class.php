<?php
namespace Home\Model;
use Think\Model\ViewModel;
class DistribProfitViewModel extends ViewModel {
	public $viewFields = array(
		'DistribProfit' => array('id', 'user_id', 'profit_id', 'level', 'money', 'create_time', '_type'=>'LEFT'),
		'Profit' => array('user_id'=>'profit_user_id', 'money'=>'profit_money', '_on'=>'Profit.id=DistribProfit.profit_id', '_type'=>'LEFT'),
		'User' => array('phone', '_on'=>'User.id=Profit.user_id'),
	);
}
<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class CashViewModel extends ViewModel {
	public $viewFields = array(
		'Cash' => array('id', 'user_id', 'trade_no', 'money', 'money_real', 'cash_fee', 'create_time', 'status', '_type'=>'LEFT'),
		'User' => array('phone', '_on'=>'User.id=Cash.user_id'),
	);
}
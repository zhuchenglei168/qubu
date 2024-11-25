<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class AccountLogViewModel extends ViewModel {
	public $viewFields = array(
		'AccountLog' => array('id', 'user_id', '`change`', 'total', 'type', 'create_time', '_type'=>'LEFT'),
		'User' => array('phone', '_on'=>'User.id=AccountLog.user_id'),
	);
}
<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class StaffViewModel extends ViewModel {
	public $viewFields = array(
		'Staff' => array('id', 'role_id', 'username', 'password', 'avatar', 'nickname', 'create_time', 'status', '_type'=>'LEFT'),
		'StaffRole' => array('title'=>'role_title', 'rules', 'status'=>'role_status', '_on'=>'StaffRole.id=Staff.role_id'),
	);
}
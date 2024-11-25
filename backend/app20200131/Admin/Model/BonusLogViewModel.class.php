<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class BonusLogViewModel extends ViewModel {
	public $viewFields = array(
		'BonusLog' => array('id', 'user_id', 'bonus_id', 'level_id', 'money', 'create_time', '_type'=>'LEFT'),
		'BonusLevel' => array('title', '_on'=>'BonusLevel.id=BonusLog.level_id', '_type'=>'LEFT'),
		'User' => array('phone', '_on'=>'User.id=BonusLog.user_id'),
	);
}
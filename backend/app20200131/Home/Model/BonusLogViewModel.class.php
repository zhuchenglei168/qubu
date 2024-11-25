<?php
namespace Home\Model;
use Think\Model\ViewModel;
class BonusLogViewModel extends ViewModel {
	public $viewFields = array(
		'BonusLog' => array('id', 'user_id', 'bonus_id', 'level_id', 'money', 'create_time', '_type'=>'LEFT'),
		'Bonus' => array('money'=>'total', 'create_time'=>'bonus_time', '_on'=>'Bonus.id=BonusLog.bonus_id', '_type'=>'LEFT'),
		'BonusLevel' => array('title', 'rate', '_on'=>'BonusLevel.id=BonusLog.level_id'),
	);
}
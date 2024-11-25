<?php
namespace Home\Controller;
use Think\Controller;
class JiaoyiController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
	}
       //获取交易大厅设置
  public function gettxData(){
  if (IS_POST) {
  	$today=strtotime(date('Y-m-d',time()));
    $market = M('market');
    	$datakai = $market->where("confirm_date>$today and status=1")->order('id ASC')->find();
       $kaipan=$datakai['price'];//开盘价格
		$dangqian = $market->where("confirm_date>$today and status=1")->order('id DESC')->find();
       $data['lastPrice']=$dangqian['price'];//开盘价格
       $data['upRate']=((($dangqian['price']-$kaipan)/$kaipan)*100).'%';
       if($dangqian['price']-$kaipan<0){
       	$data['upFlag']=2;
       }else{
       	$data['upFlag']=1;
       }
       $data['volume'] = $market->where("confirm_date>$today and status=1")->sum('num');
       	$zuigao = $market->where("confirm_date>$today and status=1")->order('price DESC')->find();
       	$data['high']=$zuigao['price'];
       	$zuidi = $market->where("confirm_date>$today and status=1")->order('price ASC')->find();
       		$data['low']=$zuidi['price'];
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
 
       // 获取交易列表
	public function getPriceList() {
		$bonus = M('bonus');
		$list = $bonus->where($map)->order('id DESC')->limit('50')->select();
		$arr=array();
		 foreach($list as $k => $v){
      $arr[$k][0]=date('Y-m-d',$v['create_time']);
      $market = M('market');
		$jinristart=$v['create_time'];
		$jinriend=$v['create_time']+86400;
			$datakai = $market->where("confirm_date>$jinristart and status=1")->order('id ASC')->find();
       $arr[$k][1]=$datakai['price'];//开盘价格
       $datashou = $market->where("confirm_date<$jinriend and status=1")->order('id DESC')->find();
       $arr[$k][2]=$datashou['price'];//收盘价格
      
       $datagao = $market->where("confirm_date>$jinristart and confirm_date<$jinriend and status=1")->order('price DESC')->find();
       $arr[$k][3]=$datagao['price'];//最高价格
       $datadi = $market->where("confirm_date>$jinristart and confirm_date<$jinriend and status=1")->order('price ASC')->find();
       $arr[$k][4]=$datadi['price'];//最低价格
       $arr[$k][5] = $market->where("confirm_date>$jinristart and confirm_date<$jinriend and status=1")->sum('num');
       
      }
	
      
		$this->ajaxReturn(array('status'=>1, 'data'=>array_reverse($arr)));
	}
    // 获取交易列表
	public function getMarket() {
			$market = M('market');
			 $post = $_REQUEST;
      
      
			$map = array('status'=>0,'type'=>$post['type']);
			if($post['type']==0){
				$data = $market->where($map)->order('id desc')->limit('20')->select();
			}else{
				$data = $market->where($map)->order('id desc')->limit('20')->select();
			}
			
       foreach($data as $k => $v){
        $data[$k]['amount']=$v['num'];
        $data[$k]['width']=rand(1,100);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
	
	// 获取历史交易列表
	public function getlishi() {
			$market = M('market');
			 $post = $_REQUEST;
      
      
			$map = array('status'=>1);
			
				$data = $market->where($map)->order('id desc')->limit('30')->select();
		
			
       foreach($data as $k => $v){
       	if($v['type']==0){
       		$data[$k]['takerFlag']=1;
       	}else{
       		$data[$k]['takerFlag']=2;
       	}
        $data[$k]['amount']=$v['num'];
        $data[$k]['date']=date('m-d H:i:s',$v['confirm_date']);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
}

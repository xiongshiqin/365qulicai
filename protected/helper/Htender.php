<?php

/**
*	发标相关的通用函数
*
*/

class Htender{

    /**
	* 标的预期万元收益
	* @param float profityear 标的年化利率
	* @param float award      标的奖励
	* @param int timelimit    标的周期
	* @param int itemtype     标的种类
	* @author porter
	**/

	public static function expectprofit( $profityear, $award, $itemtype, $timelimit ){
		//按照标的种类计算方式不一样
		switch ( $itemtype ) {
			//秒标
			case 1: 
				$timelimit = 1; //秒标时间按 1 个月计算
				$profit    = 10000*( $timelimit*$profityear/100/12 + $award/100 );
				break;
			//天标
			case 2:
				$profit = 10000*( $timelimit*$profityear/100/12/30 + $award/100 );
				break;
			//月标
			default:
				$profit = 10000*( $timelimit*$profityear/100/12 + $award/100 ); 

		}
		//var_dump($profit);exit;
		return round($profit, 2);
	}




}
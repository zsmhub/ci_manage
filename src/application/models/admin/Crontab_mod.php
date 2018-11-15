<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
** @name Crontab_mod
** @author long
** @desc crontab运行处理
**/
class Crontab_mod extends MY_Model {

	/**
	*运行
	*author: long
	*/
	public function run($params=array()){
		set_time_limit(0);
		if( isset($params[0]) && method_exists($this,$params[0]) ){
			call_user_func_array(array(&$this,$params[0]), array($params));
		}else{
//            $this->email();
		}
	}
}

/* End of file crontab_mod.php */
/* Location: application/models/admin/crontab_mod.php */

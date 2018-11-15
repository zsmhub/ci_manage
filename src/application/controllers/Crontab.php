<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
** @name Crontab 
** @author long
** @desc 终端执行控制器
**/
class Crontab extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		if( !is_cli() )exit();  //限制在终端调试
	}

	/**
	*运行接口
	*author:long
	*/
	public function run(){
		$args = func_get_args();
		if( isset($args[0]) && preg_match("/^([a-z_])*$/i", $args[0]) && method_exists('Crontab', $args[0]) && $args[0]!='run' ){
			$func = $args[0];
			unset($args[0]);
			call_user_func_array(array(&$this,$func), $args);
		}else{
			$this->load->model('admin/Crontab_mod');
			call_user_func_array(array(&$this->Crontab_mod,'run'), array($args));
		}
	}
}

/* End of file crontab.php */
/* Location: application/controllers/crontab.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
** @name Common_mod
** @author zsm
** @desc 通用的模型
**/
class Common_mod extends MY_Model {

    /**
     * @todo 通用标识函数,设置获取参数
     * @param $name
     * @param null $value
     * @param bool $getcache
     * @return array|mixed|null
     */
    public function getlog($name,$value=NULL,$getcache=TRUE){
        $name = md5($name);
        $key = 'getlog_'.$name;
        if( NULL !== $value ){
            if( $value === false ){//删除
                $this->initdb()->query("DELETE FROM `log` WHERE `name` = '{$name}'");
                $this->cache->delete($key);
            }else{
                $datetime = date('Y-m-d H:i:s', time());
                $upvalue = base64_encode(gzcompress(serialize($value)));
                $sql = "INSERT INTO `log`(`name`,`value`,`time`)VALUES('{$name}','{$upvalue}','{$datetime}') ON DUPLICATE KEY UPDATE `value` = VALUES(`value`),`time` = VALUES(`time`)";
                $this->initdb()->query($sql);
                $this->cache->set($key,$value,86400*31);
            }
        }else{
            if( $getcache == TRUE )	{
                if( ($value = $this->cache->get($key)) === false ){
                    if( ($value = $this->db_scalar('log','value',"name = '{$name}'"))!==false ){
                        $value = unserialize(gzuncompress(base64_decode($value)));
                        $this->cache->set($key,$value,86400*31);
                    }
                }
            }else{
                $value = unserialize(gzuncompress(base64_decode($this->db_scalar('log','value',"name = '{$name}'"))));
            }
        }
        return $value;
    }
}

/* End of file Common_mod.php */
/* Location: application/models/Common_mod.php */

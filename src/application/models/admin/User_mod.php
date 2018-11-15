<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
** @name User_mod
** @author
** @desc 用户控制模块
**/
class User_mod extends MY_Model {

    private $user_table = 'sys_user';
    private $role_table = 'sys_role';
    private $email_table = 'sys_email_login';

    /**
     *获取单个用户信息
     *author:
     */
    public function get_user($UserId){
        $sql = "SELECT u.* FROM {$this->user_table} u WHERE u.Id = '{$UserId}' AND Deleted = '0'";
        return $this->db_getOneBySql($sql);
    }

    /**
     *获取用户列表
     *
     * @params array $params 参数数组
     * @return array
     */
    public function get_userlist($params=array()){
        $where = "Deleted = 0";
        $role_list = $this->role_list(array('arr_flag' => true));

        //判断是否要获取以Id为下标的数组
        if(isset($params['arr_flag']) && $params['arr_flag']) {
            if( !$result = $this->cache->get('sys_user_list')) {
                $result = $this->db_getResultSet("SELECT * FROM {$this->user_table} WHERE $where", 'Id');
                foreach($result as $key => &$row) {
                    $row['RoleName'] = $role_list[$row['RoleId']]['Name'];
                }
                $this->cache->set('sys_user_list', $result, 86400*31);
            }
        } else {
            if(isset($params['where'])) $where .= $params['where'];
            $params_arr = array(
                'flag' => true,
                'model_name' => $this->user_table,
                'where' => $where,
                'order' => 'Id asc',
                'pagination' => true
            );
            $result = $this->get_datagrid_data($params_arr);
            foreach($result['rows'] as &$row) {
                $row['StatusTrans'] = ($row['Status'] == 1) ? '正常' : '禁用';
                $row['RoleName'] = $role_list[$row['RoleId']]['Name'];
            }
        }

        return $result;
    }

    /**
     *添加用户账号
     *author:
     */
    public function add_user($data){
        if( !$this->is_valid_username($data['UserName']) ) return 'UserNameIsInvalid';//账号无效
        if( $this->db_scalar($this->user_table,'Id',"UserName = '{$data['UserName']}' AND Deleted = '0'") ) return 'UserNameIsExists';//企业号ID已经存在
        if( $data['Status'] != 0 ) $data['Status'] = 1;
        if( !$this->db_scalar($this->role_table,'Id',"Id = '{$data['RoleId']}'") ) return 'RoleNotExists';//不存在的角色ID
        $this->initdb()->insert($this->user_table,$data);
        $this->cache->delete('sys_user_list');
        return true;
    }

    /**
     *用户编辑
     *author:
     */
    public function edit_user($data){
        if( !$this->db_scalar($this->user_table,'Id','Id =\''.$data['Id'].'\' AND Deleted = \'0\'')) return 'UserNotExists';
        if( $data['Status'] != 0 ) $data['Status'] = 1;
        $data['LogFaild'] = 0;
        if( !$this->db_scalar($this->role_table,'Id','Id=\''.$data['RoleId'].'\'') ) return 'RoleNotExists';//不存在的角色ID
        $this->initdb()->update($this->user_table,$data,'Id = \''.$data['Id'].'\'');
        $this->cache->delete('sys_user_list');
        return true;
    }

    /**
     *删除用户
     *author: long
     */
    public function delete_user($id){
        if( !$this->db_scalar($this->user_table,'Id',"Id = '{$id}' AND Deleted = '0'") ) return 'UserNotExists';
        $this->initdb()->update($this->user_table,array('Deleted'=>1),"Id = '{$id}'");
        $this->cache->delete('sys_user_list');
        return true;
    }

    /**
     *角色列表
     *author:
     */
    public function role_list($params=array()){
        $where = "Deleted = 0";

        //判断是否要获取以Id为下标的数组
        if(isset($params['arr_flag']) && $params['arr_flag']) {
            if( !$result = $this->cache->get('sys_role_list')) {
                $result = $this->db_getResultSet("SELECT * FROM {$this->role_table} WHERE $where", 'Id');
                $this->cache->set('sys_role_list', $result, 86400*31);
            }
        } else {
            if(isset($params['where'])) $where .= $params['where'];
            $params_arr = array(
                'flag' => true,
                'model_name' => $this->role_table,
                'where' => $where,
                'order' => 'Id asc',
                'pagination' => true
            );
            $result = $this->get_datagrid_data($params_arr);
            foreach($result['rows'] as &$row) {
                $row['StatusTrans'] = ($row['Status'] == 1) ? '正常' : '禁用';
            }
        }

        return $result;
    }

    /**
     * 获取单个角色信息
     *
     */
    public function get_role($Id,$field='*'){
        if( !$row = $this->db_getOne($this->role_table,$field,"Id='{$Id}' AND Deleted = '0'") ) return 'RoleNotExists';
        if( isset($row['Permissions']) ) $row['Permissions'] = unserialize($row['Permissions']);
        return $row;
    }

    /**
     *添加用户角色组
     *author:
     */
    public function add_role($data){
        if( $this->db_scalar($this->role_table,'Id','Name=\''.$data['Name'].'\' and Deleted=0') ) return 'RoleNameIsExists';//角色名已经存在
        if( !is_array($data['Permissions'])) return 'PermiIsNull';//没有选择授权
        $this->load->model('admin/Ctrl_mod');
        $contrlConfig = $this->Ctrl_mod->getConfig();
        foreach ($data['Permissions'] as $k=>$rs){
            $rs = explode(':', $rs);
            if( count($rs) != 2 ) {
                unset($data['Permissions'][$k]);continue;
            }
            if( !isset($contrlConfig[ucfirst($rs[0])]) ) {
                unset($data['Permissions'][$k]);continue;
            }
            if( !isset($contrlConfig[ucfirst($rs[0])]['Methods'][$rs[1]]) ) {
                unset($data['Permissions'][$k]);continue;
            }
            if( isset($data['Permissions'][$rs[0]][$rs[1]]) ) {
                unset($data['Permissions'][$k]);continue;
            }
            unset($data['Permissions'][$k]);
            $data['Permissions'][$rs[0]][$rs[1]] = array(
                'c'=>$rs[0],'a'=>$rs[1],'d'=>$contrlConfig[ucfirst($rs[0])]['Dir']
            );
        }

        if( empty($data['Permissions']) ) return 'PermiIsNull';//没有选择授权
        $data['Permissions'] = serialize($data['Permissions']);
        if( $data['Status'] != 0 ) $data['Status'] = 1;
        $this->initdb()->insert($this->role_table,$data);
        $this->cache->delete('sys_role_list');
        return true;
    }

    /**
     *用户组编辑
     *author:
     */
    public function edit_role($data){
        $roleId = $data['Id'];
        if( !$this->db_scalar($this->role_table,'Id','Id =\''.$roleId.'\' AND Deleted = \'0\'')) return 'RoleNotExists';
        if( $this->db_scalar($this->role_table,'Id','Id !=\''.$roleId.'\' AND Name=\''.$data['Name'].'\' AND Deleted = \'0\'') ) {
            return 'RoleNameIsExists';//角色名已经存在
        }
        if( !is_array($data['Permissions'])) return 'PermiIsNull';//没有选择授权
        $this->load->model('admin/Ctrl_mod');
        $contrlConfig = $this->Ctrl_mod->getConfig();
        foreach ($data['Permissions'] as $k=>$rs){
            $rs = explode(':', $rs);
            if( count($rs) != 2 ) {
                unset($data['Permissions'][$k]);continue;
            }
            if( !isset($contrlConfig[ucfirst($rs[0])]) ) {
                unset($data['Permissions'][$k]);continue;
            }
            if( !isset($contrlConfig[ucfirst($rs[0])]['Methods'][$rs[1]]) ) {
                unset($data['Permissions'][$k]);continue;
            }
            if( isset($data['Permissions'][$rs[0]][$rs[1]]) ) {
                unset($data['Permissions'][$k]);continue;
            }
            unset($data['Permissions'][$k]);
            $data['Permissions'][$rs[0]][$rs[1]] = array(
                'c'=>$rs[0],'a'=>$rs[1],'d'=>$contrlConfig[ucfirst($rs[0])]['Dir']
            );
        }


        if( empty($data['Permissions']) ) return 'PermiIsNull';//没有选择授权
        $data['Permissions'] = serialize($data['Permissions']);

        if( $data['Status'] != 0 ) $data['Status'] = 1;
        $where = 'Id = \''.$roleId.'\'';
        unset($data['Id']);
        $this->initdb()->update($this->role_table,$data,$where);
        $this->cache->delete('sys_role_list');
        return true;
    }


    /**
     *删除角色
     *author: long
     */
    public function delete_role($id){
        if( !$this->db_scalar($this->role_table,'Id',"Id = '{$id}' AND Deleted = '0'") ) return 'RoleNotExists';
        //删除角色前，先删除成员
        $judge = $this->initdb()->select('Id')->where("RoleId = {$id}")->get($this->user_table)->result_array();
        if( !empty($judge)) {
            return 'RoleDelFail';
        }
        $this->initdb()->update($this->role_table,array('Deleted'=>1),"Id = '{$id}'");
        $this->cache->delete('sys_role_list');
        return true;
    }

    /**
     *检查用户微信扫码登陆
     *author:
     */
    public function check_login_bycode($code){
        //正式
        $config = array(
            'appid'=>'jlYfjBeRkClcJ',
            'secret'=>'b4ffbfb59374f8828f88b9788ec0e52d',
            'url'=>'http://wx.home.forgame.com/index.php?d=api&c=qroauth&a=getuser'
        );
        $this->load->library('httpdown');
        $this->httpdown->AddForm('appid',$config['appid']);
        $this->httpdown->AddForm('secret',$config['secret']);
        $this->httpdown->AddForm('code',$code);
        $this->httpdown->OpenUrl($config['url']);
        if( $this->httpdown->IsGetOK() ){
            $data = $this->httpdown->GetRaw();
            if( $data=='' || !($arr = json_decode($data,true)) ){
                return 'doFailed';
            }
            if( $arr['status'] != 1 ) $this->msg($arr['msg']);
            if( !isset($arr['data']['userid']) ) return 'UserNotExists';

            if( !$user = $this->db_getOne($this->user_table,'*',"UserName='{$arr['data']['userid']}' AND Deleted = '0'") ) return 'UserNotExists';
            return $this->check_login_common($user);
        }
    }

    /**
     * @todo 检查用户使用邮箱登陆
     */
    public function check_login_byemail($email, $pw) {
        if( !$validEmail = $this->is_valid_email($email)) {
            return 'EmailNotExist';
        }
        $now = gettime();
        $whereEmail = "ToEmail = '{$email}' and Password = '" . md5(strtolower($pw)) . "' and Status = 0 and ValidDate >= {$now}";
        $selectEmail = $this->initdb()->select('Id')->where($whereEmail)->limit(1)->get($this->email_table)->row_array();
        if(empty($selectEmail)) {
            return 'PwNotValid';
        }
        $this->initdb()->where("ToEmail = '{$email}' and Status = 0")->update($this->email_table, array('Status'=>1));  //动态密码设置为已使用

        if( !$user = $this->db_getOne($this->user_table,'*',"Email='{$email}' AND Deleted = '0'") ) return 'UserNotExists';
        return $this->check_login_common($user);
    }

    private function check_login_common($user) {
        if( $user['Status'] != 1 ) return 'UserNameIsDisabled';
        if( intval($user['RoleId']) < 1 ) return 'RoleIsError';
        $role = $this->get_role($user['RoleId'],'Name,Status');
        if( !is_array($role) ) return 'RoleIsError';
        if( $role['Status'] != 1 ) return 'RoleIsError';

        $update_cookie = array(
            'UserId' => $user['Id'],
            'UserName' => $user['UserName'],
            'NickName' => $user['NickName'],
            'RoleName' => $role['Name'],
            'RoleId' => $user['RoleId'],
            'LastLogTime' => $user['LastLogTime'],
            'LastLogIP' => $user['LastLogIP']
        );

        $this->load->library('encrypt');
        $cookiedata = $this->encrypt->encode(gzcompress(serialize($update_cookie)));
        session_start();
        $_SESSION['user_data'] = $cookiedata;
        $update_sql = array('LastLogTime'=>gettime(),'LastLogIP'=>$this->input->ip_address(),'LogFaild'=>0);
        $this->initdb()->update($this->user_table,$update_sql,'Id = '.$update_cookie['UserId']);
        unset($user,$role,$update_sql,$update_cookie,$deplist);
        return true;
    }

	/**
	*角色记录总条数
	*author:
	*/
	public function get_role_totalnum($where=''){
		$sqlwhere = "Deleted = '0'";
		if( !empty($where) ) $sqlwhere .= ' AND '.$where;
		return $this->db_scalarBySql("SELECT COUNT(*) FROM {$this->role_table} WHERE $sqlwhere");
	}

    /**
     *用户记录总条数
     *author:
     */
    public function get_user_totalnum($where=''){
        $sqlwhere = "Deleted = '0'";
        if( !empty($where) ) $sqlwhere .= ' AND '.$where;
        return $this->db_scalarBySql("SELECT COUNT(*) FROM {$this->user_table} WHERE $sqlwhere");
    }

    /**
     *用户名有效性检测
     *author:
     */
    public function is_valid_username($username){
        //长度3-16位，由字母、数字、下横线组成并且由字母开头
        if( strlen($username) < 3 || strlen($username) > 16 ) return false;
        if( preg_match('/[^a-z0-9_]/i', $username) || !preg_match('/[a-z]/i', substr($username,0, 1)) ) return false;
        return true;
    }

    /**
     * @todo 检查登陆邮箱是否存在
     * @author zsm
     */
    public function is_valid_email($email) {
        $row = $this->initdb()->select('Id,NickName')->where('Email', $email)->limit(1)->get($this->user_table)->row_array();

        if(empty($row)) {
            return false;
        }
        return $row['NickName'];
    }

    /**
     * @todo 保存动态密码到数据库
     * @author zsm
     */
    public function add_dynamic_pw($data) {
        //参数配置
        $now = gettime();
        $pwValidTime = 1;  //动态密码1小时内有效
        $pw = random_str(6);  //6位数的动态密码
        $system_name = get_system_name();

        //邮箱判断
        $isValidEmail = $this->is_valid_email($data['ToEmail']);
        if($isValidEmail === false) {
            return json_encode(array(
                'success' => false,
                'msg' => '该系统不存在该邮箱的用户'
            ));
        }

        //验证码获取时间判断，60秒内不能重复获取
        $timeJudge = $this->initdb()->select('Id')->where("ToEmail = '{$data['ToEmail']}' and Status = 0 and CreateDate > ({$now}-60)")->limit(1)->get($this->email_table)->row_array();
        if( !empty($timeJudge)) {
            return json_encode(array(
                'success' => false,
                'msg' => '当前用户60秒内已经获取过一次密码，请稍等'
            ));
        }

        $data['ValidDate'] = $now + $pwValidTime*60*60;
        $data['CreateDate'] = $now;
        $data['Status'] = 0;
        $data['Password'] = md5(strtolower($pw));
        $this->initdb()->insert($this->email_table, $data);

        //保存发邮箱记录到sys_email_log表，使用定时任务发邮件
        $content = file_get_contents(FCPATH . 'application/views/template/dtmm.html');
        $content = str_replace('${realName}', $isValidEmail, $content);
        $content = str_replace('${dynamicPw}', $pw, $content);
        $content = str_replace('${validHour}', $pwValidTime, $content);
        $content = str_replace('${systemName}', $system_name, $content);
        $send_data = array(
            'message' => $content,
            'to' => $data['ToEmail'],
            'subject' => $system_name . '-动态密码',
            'sendName' => $system_name
        );
        $result = $this->send_email($send_data);

        if($result === false) {
            return json_encode(array(
                'success' => false,
                'msg' => '动态密码获取失败'
            ));
        }
        return json_encode(array(
            'success' => true,
            'msg' => '动态密码获取成功'
        ));
    }
}

/* End of file User_mod.php */
/* Location: application/models/admin/User_mod.php */

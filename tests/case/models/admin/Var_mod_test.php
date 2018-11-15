<?php
class Var_mod_test extends TestCase {

    private $ci_obj;

    public function setUp() {
        $this->resetInstance();
        $this->CI->load->model('admin/Var_mod');
        $this->ci_obj = $this->CI->Var_mod;
    }

    //insert
    public function test_var_add() {
        $data = array(
            'var_name' => 'var_name' . time(),
            'var_mode' => mt_rand(0, 2),
            'var_value' => ''
        );

        //测试数据为空的情况
        $test_empty = $this->ci_obj->var_add($data);
        $this->assertSame('empty_msg', $test_empty);

        //增加记录
        $data['var_value'] = 'var_value';
        $insert_id = $this->ci_obj->var_add($data);
        $result_insert = $insert_id;
        if(is_numeric($insert_id)) $result_insert = true;
        $this->assertTrue($result_insert);

        //测试记录重复增加情况
        $test_repeat = $this->ci_obj->var_add($data);
        $this->assertSame('repeat', $test_repeat);

        return $insert_id;
    }

    //select
    public function test_get_var_list() {
        //获取数据
        $result = $this->ci_obj->get_var_list();
        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);

        //获取一条记录
        $params = array(
            'arr_flag' => true,
            'arr_id' => $result['rows'][0]['var_key']
        );
        $result_key = $this->ci_obj->get_var_list($params);
        $this->assertInternalType('array', $result_key);
        $this->assertSame($result_key['var_key'], $result['rows'][0]['var_key']);
    }

    /**
     * update
     *
     * @param int $insert_id 新增记录的id
     * @depends test_var_add
     */
    public function test_var_edit($insert_id) {
        $params = array(
            'var_value' => '数据修改'
        );

        //测试id为空的情况
        $test_id = $this->ci_obj->var_edit($params);
        $this->assertSame('param_msg', $test_id);

        //修改数据
        $params['id'] = $insert_id;
        $result = $this->ci_obj->var_edit($params);
        $this->assertTrue($result);
    }

    /**
     * delete
     *
     * @param int $insert_id 新增记录的id
     * @depends test_var_add
     */
    public function test_var_delete($insert_id) {
        //测试id为空的情况
        $test_id = $this->ci_obj->var_delete('');
        $this->assertSame('param_msg', $test_id);

        //删除
        $result = $this->ci_obj->var_delete($insert_id);
        $this->assertTrue($result);
    }
}

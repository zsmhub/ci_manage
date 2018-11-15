<?php
 $config = array (
  'Ctrl' =>
  array (
    'Name' => '控制器管理',
    'IdKey' => 'Ctrl',
    'REV_AUTH' => '1',
    'Status' => '1',
    'Dir' => 'admin',
    'Methods' =>
    array (
      'addcontroller' =>
      array (
        'Name' => '添加控制器',
        'IdKey' => 'addcontroller',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'addaction' =>
      array (
        'Name' => '添加功能',
        'IdKey' => 'addaction',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'ctrllist' =>
      array (
        'Name' => '控制器列表',
        'IdKey' => 'ctrllist',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'funclist' =>
      array (
        'Name' => '功能列表',
        'IdKey' => 'funclist',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'add_dir' =>
      array (
        'Name' => '新建目录',
        'IdKey' => 'add_dir',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'editctrl' =>
      array (
        'Name' => '编辑控制器',
        'IdKey' => 'editctrl',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'editfunc' =>
      array (
        'Name' => '功能修改',
        'IdKey' => 'editfunc',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
    ),
  ),
  'Mod' =>
  array (
    'Name' => '模型管理',
    'IdKey' => 'Mod',
    'REV_AUTH' => '1',
    'Status' => '1',
    'Dir' => 'admin',
    'Methods' =>
    array (
      'modlist' =>
      array (
        'Name' => '模型列表',
        'IdKey' => 'modlist',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'addmodel' =>
      array (
        'Name' => '添加模型',
        'IdKey' => 'addmodel',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'addfunc' =>
      array (
        'Name' => '添加功能',
        'IdKey' => 'addfunc',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'methods' =>
      array (
        'Name' => '功能列表',
        'IdKey' => 'methods',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'add_dir' =>
      array (
        'Name' => '添加目录',
        'IdKey' => 'add_dir',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
    ),
  ),
  'Menu' =>
  array (
    'Name' => '菜单管理',
    'IdKey' => 'Menu',
    'REV_AUTH' => 1,
    'Status' => '1',
    'Dir' => 'admin',
    'Methods' =>
    array (
      'add_menu' =>
      array (
        'Name' => '添加菜单',
        'IdKey' => 'add_menu',
        'REV_AUTH' => 1,
        'Status' => '1',
      ),
      'edit_menu' =>
      array (
        'Name' => '菜单修改',
        'IdKey' => 'edit_menu',
        'REV_AUTH' => 1,
        'Status' => '1',
      ),
      'add_cat' =>
      array (
        'Name' => '添加分类',
        'IdKey' => 'add_cat',
        'REV_AUTH' => 1,
        'Status' => '1',
      ),
      'edit_cat' =>
      array (
        'Name' => '修改分类',
        'IdKey' => 'edit_cat',
        'REV_AUTH' => 1,
        'Status' => '1',
      ),
      'menulist' =>
      array (
        'Name' => '菜单列表',
        'IdKey' => 'menulist',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'delete' =>
      array (
        'Name' => '菜单删除',
        'IdKey' => 'delete',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
    ),
  ),
  'User' =>
  array (
    'Name' => '用户管理',
    'IdKey' => 'User',
    'REV_AUTH' => '1',
    'Status' => '1',
    'Dir' => 'admin',
    'Methods' =>
    array (
      'userlist' =>
      array (
        'Name' => '用户管理',
        'IdKey' => 'userlist',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'adduser' =>
      array (
        'Name' => '添加帐号',
        'IdKey' => 'adduser',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'edit_user' =>
      array (
        'Name' => '帐号编辑',
        'IdKey' => 'edit_user',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'delete' =>
      array (
        'Name' => '帐号删除',
        'IdKey' => 'delete',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'login' =>
      array (
        'Name' => '用户登陆',
        'IdKey' => 'login',
        'REV_AUTH' => '0',
        'Status' => '1',
      ),
      'logout' =>
      array (
        'Name' => '退出登录',
        'IdKey' => 'logout',
        'REV_AUTH' => '0',
        'Status' => '1',
      ),
    ),
  ),
  'Role' =>
  array (
    'Name' => '角色管理',
    'IdKey' => 'Role',
    'REV_AUTH' => '1',
    'Status' => '1',
    'Dir' => 'admin',
    'Methods' =>
    array (
      'rolelist' =>
      array (
        'Name' => '角色列表',
        'IdKey' => 'rolelist',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'addrole' =>
      array (
        'Name' => '新增角色',
        'IdKey' => 'addrole',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'editrole' =>
      array (
        'Name' => '角色修改',
        'IdKey' => 'editrole',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
      'delete' =>
      array (
        'Name' => '删除角色',
        'IdKey' => 'delete',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
    ),
  ),
  'Home' =>
  array (
    'Name' => '管理后台',
    'IdKey' => 'Home',
    'REV_AUTH' => '1',
    'Status' => '1',
    'Dir' => 'admin',
    'Methods' =>
    array (
      'index' =>
      array (
        'Name' => '后台首页',
        'IdKey' => 'index',
        'REV_AUTH' => '2',
        'Status' => '1',
      ),
    ),
  ),
  'Api' =>
      array (
          'Name' => '接口管理',
          'IdKey' => 'Api',
          'REV_AUTH' => '1',
          'Status' => '1',
          'Dir' => 'admin',
          'Methods' =>
              array (
                  'ueditor' =>
                      array (
                          'Name' => 'ueditor服务器回调接口',
                          'IdKey' => 'ueditor',
                          'REV_AUTH' => '2',
                          'Status' => '1',
                      ),
              ),
      ),
);

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE>
<html>
<head>
    <?php include_once ADMINVIEWPATH . 'head.php'; ?>
    <link rel='stylesheet' type='text/css' href="style/default/css/login.css">
</head>
<body>
<div class="bg">
    <div class="main">
        <div class="cp-head">
            <div class="headnav">
                <a href="javascript:void(0);" onclick="SetHome(this, location.href)">设为首页</a> |
                <a href="javascript:void(0);" onclick="AddFavorite(document.title , location.href)">加入收藏</a>
            </div>
        </div>

        <div class="container">
            <div class="w960">
                <div id="loginBlock" class="login tab-1">
                    <div class="loginFunc">
                        <div id="qrlogin" class="loginFuncApp">二维码登录</div>
                        <div id="maillog" class="loginFuncNormal">动态密码登录</div>
                    </div>
                    <!--二维码登陆-->
                    <div id="qrlogin_div" class="loginbox">
                        <div id="qrcode"></div>
                        <div id="qrstatus"></div>
                    </div>
                    <!--//二维码登陆-->
                    <!--临时密码登录-->
                    <div id="maillog_div" class="loginbox hide">
                        <form id="pw-form" method="post">
                            <label>
                                <input type="text" name="email" id="email" class="sm-textbox" placeholder="请输入公司邮箱帐号" />
                            </label>
                            <label>
                                <input type="password" name="passwd" id="passwd" class="sm-textbox" placeholder="请输入动态密码" />
                                <input type="button" value="获取动态密码" id="getpw" class="sm-button"/>
                            </label>
                            <label><input type="button" value="登&nbsp;&nbsp;录" class="sm-button" id="login" style="width: 245px;"/></label>
                        </form>
                    </div>
                    <!--//临时密码登录-->
                </div>
            </div>
        </div>

        <div class="footer">
            Copyright© Forgame.com. All right reserved. 技术支持 : 信息管理部
        </div>
    </div>
</div>

<?php include_once ADMINVIEWPATH . 'foot.php'; ?>
<script type="text/javascript" src="http://wx.home.forgame.com/index.php?d=api&c=qroauth&a=js"></script>
<script language="javascript">
    qroauth.init({appId:'jlYfjBeRkClcJ ',imgID:'qrcode',tipsID:'qrstatus',size:5});  //正式

    var wait = second = 60;  //倒计时60s
    var delay_time;
    $(function(){
        $('.loginFunc div').hover(
            function(){
                if( $(this).attr('id') == 'qrlogin' ){
                    $('#qrlogin_div').show();
                    $('#maillog_div').hide();
                    $('#loginBlock').attr('class','login tab-1');
                }else{
                    $('#maillog_div').show();
                    $('#qrlogin_div').hide();
                    $('#loginBlock').attr('class','login tab-2');
                }
            },
            function(){
            }
        );
        var flag_pw = 1;
        $('#getpw').click(function() {
            var email = $('#email').val();
            if(email == '') {
                alert('请输入公司邮箱账号');
                return;
            }
            if(flag_pw) {
                flag_pw = 0;
                time('getpw');
                $.post('<?php echo geturl("user", "get_dynamic_pw", "admin"); ?>', {email: email}, function(r) {
                    flag_pw = 1;
                    if( !r.success) {
                        alert(r.msg);
                        wait = 0;
                        clearTimeout(delay_time);
                        time('getpw');
                    }
                }, 'json');
            }
        });
        var flag_submit = 1;
        $('#login').click(function() {
            var email = $('#email').val();
            var passwd = $('#passwd').val();

            if(email == '') {
                alert('请输入公司邮箱账号');
                return;
            }
            else if(passwd == '') {
                alert('请输入动态密码');
                return;
            }

            if(flag_submit) {
                flag_submit = 0;
                $('#pw-form').submit();
            }
        });
    });
    function time(o) {  //倒计时60s
        if (wait == 0) {
            $('#' + o).css({"background-color": '#00AA00'});
            $('#' + o).prop('disabled', false);
            $('#' + o).val("获取动态密码");
            wait = second;
        } else {
            $('#' + o).css({"background-color": '#888888'});
            $('#' + o).prop('disabled', true);
            $('#' + o).val("重新获取(" + wait + ")");
            wait--;
            delay_time = setTimeout(function() {
                time(o);
            }, 1000);
        }
    }
    //收藏本站
    function AddFavorite(title, url) {
        try {
            window.external.addFavorite(url, title);
        }
        catch (e) {
            try {
                window.sidebar.addPanel(title, url, "");
            }
            catch (e) {
                alert('抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加');
            }
        }
    }
    //设为首页
    function SetHome(obj,url){
        try{
            obj.style.behavior='url(#default#homepage)';
            obj.setHomePage(url);
        }catch(e){
            if(window.netscape){
                try{
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                }catch(e){
                    alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");
                }
            }else{
                alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");
            }
        }
    }
</script>
</body>
</html>
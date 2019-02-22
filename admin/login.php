<?php
  /*完成的是登录功能
    1.用户输入邮箱和密码，点击登陆
    2.手机用户的数据，发送到服务器
    3.把用户数据和数据库数据对比
    4.把登陆结果通知前台


    前端：
      登录按钮注册点击事件
      收集用户的数据，ajax发送给服务器
        
        判断返回的数据是否登录成功
        成功就跳转到后台，否则提示错误

    后端
      得到用户的邮箱和密码
      根据查找数据库中有没有对应数据
      最终通知前台是否登陆成功

  */
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display: none;">
      <strong>错误！</strong><span id="msg"> 用户名或密码错误！</span>
    </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span id="btn-login" class="btn btn-primary btn-block" href="index.php">登 录</span>
    </form>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script type="text/javascript" >
    //   入口函数
      $(function(){
        // 给登录按钮注册点击事件
        $("#btn-login").on("click",function(){
          // 1.0收集用户的邮箱和密码
          var email = $("#email").val();
          var password = $("#password").val();
          // 2.0 验证邮箱的格式是否正确
            // 正则表达式先在前端对代码进行简单校验
            var reg = /^\w+[@]\w+[.]\w+$/;
            /*test() 方法用于检测一个字符串是否匹配某个模式.如果字符串中有匹配的值返回 true ，否则返回 false。*/
            if(!reg.test(email)){
              // 提示用户  用于判断验证邮箱格式是否正确
              $("#msg").text("您输入的邮箱有误，请重新输入");
              $(".alert").show();
              return;
            }
            // 如果邮箱格式正确，把数据发送回服务端
            $.ajax({
              type:"post",
              data:{
                "email" : email,
                "password": password
              },
              url:"api/_userlogin.php",
              success:function(res){
                // 4.判断返回的结果是否登陆成功
                if(res.code ==1){
                  // 跳转到后台页面
                  location.href='index.php';
                }else{
                   $("#msg").text(" 用户名或密码错误！");
                   $(".alert").show();
                }
              }
            })
        })
      });

  </script>
</body>
</html>

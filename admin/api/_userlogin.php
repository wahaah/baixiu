<?php 
	include_once "../../config.php";
	require_once "../../functions.php";
	// 完成用户的登陆
	  /*后端
      得到用户的邮箱和密码
      根据查找数据库中有没有对应数据
      最终通知前台是否登陆成功*/

      // 1.获取邮箱和密码
      $email= $_POST["email"];
      $password = $_POST["password"];
      // 2.根据查找数据库中有没有对应数据
      // 2.1链接数据库
      	$connect = connect();
      // 2.2准备sql语句
      	$sql = "select * from users where email = '{$email}' and password = '{$password}' and status= 'activated'";
      // 2.3执行语句
      	$queryResult = query($connect,$sql);
      	// print_r($queryResult);
      	// 

      	/*Array
(
    [0] => Array
        (
            [id] => 1
            [slug] => admin
            [email] => admin@zce.me
            [password] => wanglei
            [nickname] => 管理员
            [avatar] => /static/uploads/avatar.jpg
            [bio] => 
            [status] => activated
        )

)	

*/

	// 3.判断查询的结果是不是有数据（二维数组中有数据才是成功）
      	$response = ["code"=>0,"msg"=>"操作失败"];
      	if($queryResult){
      		// 3.1如果登录成功了，应该把登陆状态记录一下
      		// 使用session
      		session_start();
      		// 登陆过存的值就是1
      		$_SESSION['islogin'] =1;
                  // 3.2 把用户的id也存储起来，以便将来可以用开获取跟用户相关的数据
                  $_SESSION['user_id'] = $queryResult[0]['id'];

      		$response["code"] = 1;
      		$response["msg"] = "操作成功";
      	}
      	// 4.以json格式返回数据
      	header("content-type:application/json;charset=utf-8");
      	echo json_encode($response);
 ?>
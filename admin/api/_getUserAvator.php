<?php 
	require_once "../../config.php";
	require_once "../../functions.php";
	// 获取用户头像和昵称
	// 因为要获取头像和昵称需要用户id  而我们在登陆时就将用户id存在$_SESSION中，只需从中获取
		session_start();
		$userId =  $_SESSION['user_id'];
		// echo $userId;
		// 根据用户id,到数据库中查询用户的头像和昵称
	//1.连接数据库
		$connect = connect();
	//2.准备sql语句
		$sql = "select * from users where id = {$userId}";
	// 3.执行sql语句
		$queryResult = query($connect,$sql);
	// 4.判断是否查到数据，返回前端
		$response = ["code" => 0,"msg"=>"操作失败"];

		if($queryResult){
			$response["code"] = 1;
			$response["msg"] = "操作成功";
			$response["avatar"]= $queryResult[0]["avatar"];
			$response["nickname"]= $queryResult[0]["nickname"];
		}
		// 5以json格式返回数据
		header("content-type:application/json");
		echo json_encode($response);
 ?>
<?php

	header("Content-Type:application/json;charset=utf-8");
	require_once "../config.php";
	require_once "../functions.php";

	// 获取必要的参数
	$categoryId = $_POST["categoryId"];
	$currentPage = $_POST["currentPage"];
	$currentSize = $_POST["currentSize"];
	// 计算从哪里开始获取
	$offset=($currentPage - 1) * $currentSize;
	// 链接数据库
	$connect = connect();
	// 编辑sql语句
	$sql = "SELECT p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,u.nickname,c.name,
          (SELECT count(id) FROM comments WHERE comments.post_id = p.id) as commentCount
          FROM posts p

          LEFT JOIN users u ON u.id = p.user_id
          LEFT JOIN categories c ON c.id = p.category_id
          WHERE p.category_id = {$categoryId}
          LIMIT {$offset},{$currentSize}";
          // 拿到最终的结果集
          $dataArr = query($connect,$sql);

          // 查询完结果计算总共可以获取多少次
          // 计算总次数，返回给用户
          // 1.0 准备sql语句  执行语句
          $sqlCount = "SELECT count(id) as postCount FROM posts WHERE category_id = {$categoryId}";
          $countArray = query($connect,$sqlCount);
          // 因为查询结果是二维数组,需要从数组中获取出总共能获取的次数
          // print_r($countArray);
          $pageCount = $countArray[0]['postCount'];



          // print_r($dataArr);
          // 返回给前端的数据
          $response = ["code" => 0,"msg" => "操作失败"];
          // 有结果集则成功
          if($dataArr){
          		$response["code"] = 1;
          		$response["msg"] = "操作成功";
          		$response["data"] = $dataArr;
          		$response["pageCount"] = $pageCount;
          }
          
		  echo json_encode($response);
?>
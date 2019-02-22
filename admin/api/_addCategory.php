<?php 
	require_once "../../config.php";
	require_once "../../functions.php";

	// 重名情况下不可添加
	// $name = $_POST["name"];
	$name = $_POST['name'];
	// print_r($_POST);
	/*Array ( [name] => def [slug] => 3ff [classname] => f )*/
	// 
	$connect = connect();
	//  判断是否重名
	$countSql = "SELECT count(*) as count FROM categories WHERE name = '{$name}' ";
	$queryResult = query($connect,$countSql);
	// var_dump($queryResult);
	/*array(1) { [0]=> array(1) { ["count"]=> string(1) "0" } }*/
	$count = $queryResult[0]["count"];
	// echo $count;
	$response = ["code"=>0,"msg"=>"操作失败"];
	if($count>0){
		$response["msg"] = "分类名称已存在，不可重复添加";
	}else{
		/*// 如果不存在，就继续新增的逻辑
		// 准备新增的sql语句
		$keys = array_keys($_POST);
		// var_dump($keys);
		$values = array_values($_POST);
		// INSERT into categories (`NAME`, slug, classname) VALUES ('', '', '')
		// $sqlAdd = INSERT into categories (多个健以,隔开) VALUES (多个值以','隔开);
		// 键和值要从前台获取
		$sqlAdd = "INSERT into categories (".implode(",",$keys).") VALUES('".implode("','",$values)."')";
		// echo $sqlAdd;
		// INSERT into categories (name,slug,classname) VALUES('swd','dewf','fe')
		$addResult = mysqli_query($connect,$sqlAdd);*/

		// 调用封装好的函数来完成插入操作
		$addResult = insert($connect,"categories",$_POST);

		// 判断添加的结果是否成功，成功则告诉前端可以动态生成表格了
		if($addResult){
			$response["code"] = 1;
			$response["msg"] = "操作成功";

			// 操作成功后，数据可以渲染到页面，但是需要刷新页面，用户体验不好
			// 如何可以自动刷新
		}
	}
	header("Content-Type:application/json;chartset=utf-8");
	// 加上此行后res 是对象
  	echo json_encode($response);
 ?>
<?php 

	// 根据id跟跟新分类数据
	require_once "../../config.php";
	require_once "../../functions.php";
	// 1.先获取id和一些要修改的数据
	$id = $_POST["id"];
	// print_r($_POST);
	/*Array
(
    [name] => 奇趣事
    [slug] => funny
    [classname] => fa-glass
    [id] => 2
)*/

	// 链接数据库
	$connect = connect();
	// sql语句
	$sql = "update categories set ";
	// 遍历$_POST数组之前，要把id从数组中去掉 unset() 函数用于销毁给定的变量。
	unset($_POST["id"]);
	// 遍历$_POST数组，把每个键和值拼接到sql语句中
	foreach ($_POST as $key => $value) {
		$sql .="{$key}='{$value}',";
	}
	// 循环导致sql语句的末尾多一个逗号，先把逗号去掉
	/*substr(string,start,length)函数返回字符串的一部分。
	length  正数 - 从 start 参数所在的位置返回  负数 - 从字符串末端返回*/
	$sql = substr($sql,0,-1);
	/*update categories set 閿�=鍊糿ame=>'濂囪叮浜�',slug=>'funny',classname=>'fa-glass',id=>'2' where id =''*/
	$sql .=" where id='{$id}'";
	// echo $sql;
	// return;
	/*update categories set name='e2fsd',slug='f4',classname='f3' where id ='6'*/
	

	/*update categories set 閿�=鍊糿ame=>'ef',slug=>'wef',classname=>'fwf',id=>'12', where id =''*/
	
	// 执行sql语句
	// 注意：此处只能使用 mysqli_query 因为增删改返回的是受影响的函数
	// 查询 返回的是结果集 不能使用封装后的
	$result = mysqli_query($connect,$sql);
	// 将结果集返回给前端
	$response = ["code"=>0,"msg"=>"操作失败"];
	if($result){
		$response['code'] =1;
		$response["msg"] = "操作成功";

	}
	// 以json格式返回前端
	header("content-type:application/json");
	echo json_encode($response);

 ?>
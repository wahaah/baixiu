<?php 
	require_once "../../config.php";
	require_once "../../functions.php";

	// 1.0获取文章的数据

	// 从前端获取两个数据
	// 当前是第几页    一共要获取多少条
	$currentPage = $_POST["currentPage"];
	$pageSize = $_POST["pageSize"];
	// 还要获取筛选的条件
	$status = $_POST["status"];
	// 获取分类id
	$categoryId = $_POST["categoryId"];
	// print_r($_POST);
	// $all = $_POST["all"];
	// 当是all时不进行查询筛选。因此where条件是不同的，习惯处理方式是where 1=1 
	// 只有当有条件时把条件拼接到where后面
	$where= "WHERE 1=1";
	// 判断有无筛选条件
	/*if($status != "all"){
		$where .= "and p.status ='{$status}'";
	}*/
	if($status != "all") {
		$where .= " AND p.`status` = '{$status}' ";
	}
	// 判断分类的id是否也属于筛选的条件
	// if($categoryId != "all"){
	// 	$where .= "and p.category_id = '{$categoryId}'";
	// }
	if($categoryId != "all") {
		$where .= " AND p.category_id = '{$categoryId}' ";
	}

	// 计算sql语句从哪里开始获取数据
	// 从哪里开始获取 = （要获取的页码数 -1）*每页获取数据的条数
	$offset = ($currentPage-1) * $pageSize;
	// 2.0链接数据库
	$connect = connect();
	/*$sql = "SELECT p.id,p.title,p.created,p.`status`,u.nickname,c.`name` 	 FROM posts p
            LEFT JOIN users u ON u.id = p.user_id
            LEFT JOIN categories c ON c.id = p.category_id";*/

    // 若要分类获取，即实现分页管理
    // $sql = "SELECT p.id,p.title,p.created,p.`status`,u.nickname,c.`name` 	 FROM posts p
    // 		LEFT JOIN users u ON u.id = p.user_id
    // 		LEFT JOIN categories c ON c.id = p.category_id
    // 		where p.status = '{$status}'
    // 		LIMIT {$offset},{$pageSize}";

    		   // 若要分类获取，即实现分页管理
  
    $sql = "SELECT p.id,p.title,p.`status`,p.created,u.nickname,c.`name` FROM posts p
			LEFT JOIN users u ON u.id = p.user_id
			LEFT JOIN categories c ON c.id = p.category_id " .$where. 
			" LIMIT {$offset},{$pageSize}";
			// echo $sql;
    // 查询返回的是结果集  可以使用封装好的query
	$queryResult = query($connect,$sql);
	
	
	// 查询到了数据后，在计算出最大页码数
	$countSql = "select count(*) as count from posts";

	// 执行总数查询语句
	$countArr = query($connect,$countSql);
	$postCount = $countArr[0]['count'];

	// 计算页码的最大值
	  // 最大的页码数 = Math.ceil(文章的数据的总量/每一页获取的数据的条数)
	$pageCount = ceil($postCount / $pageSize);



	$sxcountSql = "select count(*) as count from posts p
	LEFT JOIN categories c ON c.id = p.category_id " .$where;

	 // echo $sxcountSql;
	 // $sxcountSql = "select count(*) as count from posts WHERE `status` = 'drafted' AND category_id = 4 ;
	$countArr1 = query($connect,$sxcountSql);
	$postCount = $countArr1[0]['count'];
	$pageCount = ceil($postCount / $pageSize);

	// 3.0返回数据
	$response = ["code"=>0,"msg"=>"操作失败"];
	if($queryResult){
		$response["code"] = 1;
		$response["msg"] = "操作成功";
		$response["data"] = $queryResult;
		// 将总页数返回回去
		$response["pageCount"] = $pageCount;
		// $response["pageCount1"] = $pageCount1;



	}
	// 以json格式返回
	header("content-type:application/json; charset=utf-8");
	echo json_encode($response);

 ?>
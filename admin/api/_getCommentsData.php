
<?php 
	require_once '../../config.php';
	require_once '../../functions.php';

	/*获取从前端得到的当前是第几页  每页多少条  连接数据库获取数据*/

	// 获取从前端得到的当前是第几页  每页多少条
	$currentPage = $_POST['currentPage'];
	$pageSize = $_POST['pageSize'];

	// 计算从哪里开始获取数据
	$offset = ($currentPage-1)*$pageSize;
	// 链接数据库
	$connect = connect();
	// sql语句
	// 由于有删除等操作，需要用到id
	$sql = "SELECT c.id,c.author,c.content,c.created,c.`status`,p.title FROM comments c 
			LEFT JOIN posts p on p.id = c.post_id 
			LIMIT {$offset},{$pageSize}";
	// 执行查询
	$queryresult = query($connect,$sql);



	// 获取最大页码数
	// 最大页码数 = ceil(评论数据总数/ 每页获取条数);

	// 2.1 重新查询总的条数
	$countSql = "SELECT count(*) as count FROM comments";
	$countArr = query($connect, $countSql);
	// 取出数据总数
	$count = $countArr[0]["count"];
	// 计算出最大页码数
	$pageCount = ceil($count / $pageSize);
	// echo $pageCount;


	$response = ["code"=>0,"msg"=>"加载失败"];
	if($queryresult){
		$response["code"] = 1;
		$response["msg"] = "加载成功";
		// 把数据带回来
		$response["data"] = $queryresult;
		$response["pageCount"] = $pageCount;

	}
	// 以json格式返回
	header("content-type:application/json;charset=utf-8");
	echo json_encode($response);
 ?>
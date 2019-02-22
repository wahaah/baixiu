<?php
	/*验证是否已经登陆的函数的封装*/
	function checklogin(){
		 // 如果使用session 一定要先开启
  	session_start();
// 网址为admin时会自动跳转到登录页  自己的并不会跳转
  // 要先做登陆验证

// 先完成登陆的验证  除了登陆页面，都需要做登陆的验证(可以提取到公共中)
  // 没有islogin 这个key  有islogin 但是值跟我们在登录的时候存储的不一样
// 我们定义的登陆过存的islogin=1   不等于1时则未登陆过
  	if(!isset($_SESSION['islogin'])|| $_SESSION['islogin']!=1){
    // 若没有登陆过，就强制登陆
  	 	 header("location:login.php");
  		}
}




	// 链接数据库
	function connect(){
		 return  mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
	}
	// 查询sql语句
	function query($connect,$sql){
		$data = mysqli_query($connect,$sql);
		return fetch($data);
		// while($row = mysqli_fetch_assoc($result)){
		// 	$arr[] = $row;
		// }
		// return $arr;
	}

	// 处理结果集
	function fetch($result){
		$arr = array();
		while( $row = mysqli_fetch_assoc($result)){
			$arr[] = $row;
		}
		return $arr;
	}


	function insert($connect,$table,$arr){
		// $arr代替$_POST    $table表名    $connect
		$keys = array_keys($arr);
		$values = array_values($arr);
		$sqlAdd = "INSERT into {$table} (".implode(",",$keys).") VALUES('".implode("','",$values)."')";
		return mysqli_query($connect,$sqlAdd);
	}
?>
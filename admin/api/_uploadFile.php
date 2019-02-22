<?php 
	
	// 不注释会影响后续代码执行  输出一个数组，无法以json格式执行
	// print_r($_FILES);
			/*Array
				(
				    [file] => Array
				        (
				            [name] => img-35f27e11cfb2312ce467bc07480e6d48.jpg
				            [type] => image/jpeg
				            [tmp_name] => D:\temporary\php8210.tmp
				            [error] => 0
				            [size] => 2893834
				        )
				
				)
		*/

	
	// 获取上传回来的文件
	$file = $_FILES["file"];
				// 
	// $file = $_FILES["file"];
	$ext = strrchr($file["name"], ".");
	// echo $ext;
	// 生成一个不重复的文件名
	// $filename = time().rand(1000,9999).strrchr($_FILES['file']["name"], ".");
	// 注意用点来连接
	$filename = time().rand(1000,9999).$ext;
	// echo $filename;

	$bool = move_uploaded_file($file["tmp_name"],"../../static/uploads/". $filename);

	// 若图片上传成功，返回图片的路径，让前端页面可以预览
	$response = ["code"=>0,"msg"=>"操作失败"];
	if($bool){
		$response["code"]=1;
		$response["msg"]="操作成功";
		// 把上传图片地址返回给前端  从根目录开始
		$response["src"]="/static/uploads/".$filename;

	}

	header("content-type:application/json;charset=utf-8");
	echo json_encode($response);

 ?>
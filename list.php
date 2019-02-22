<?php 
  include_once "config.php";
  include_once "functions.php";

  $categoryId = $_GET['categoryId'];

  // echo $categoryId;
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
  $sql = "SELECT  p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.name,u.nickname,
(SELECT count(id) FROM comments WHERE comments.post_id = p.id )as commentsCount
FROM posts p
LEFT JOIN categories c ON c.id = p.category_id
LEFT JOIN users u on u.id = p.user_id
-- 加花括号是因为双引号会解析变量  单引号不会解析变量   双引号中加变量用{}
WHERE p.category_id = {$categoryId}
LIMIT 10";
  $postResult = mysqli_query($connect,$sql);
  //转换为二维数组
  $dataArr=[];
  //while遍历
  while($row = mysqli_fetch_assoc($postResult)){
    $dataArr[] = $row;
  }
  //print_r($dataArr);


  // echo "_________________________________________调用封装后代码";

  	/*$connect = connect();
   $sql = "SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.name,u.nickname,
	(SELECT count(id) FROM comments WHERE comments.post_id = p.id )as commentsCount
	FROM posts p
	LEFT JOIN categories c ON c.id = p.category_id
	LEFT JOIN users u on u.id = p.user_id
	-- 加花括号是因为双引号会解析变量  单引号不会解析变量   双引号中加变量用{}
	WHERE p.category_id = {$categoryId}
	LIMIT 10";
	$dataArr = query($connect,$sql);
	print_r($dataArr);*/
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <style type="text/css">
  		.loadmore {
  			text-align: center;
  			padding: 50px 0;
		}
		.loadmore .btn {
 			 border:1px solid #ccc;
 			 border-radius: 7px;
 			 padding: 10px 20px;
 			 cursor:pointer;
		}
  </style>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <?php include_once "public/_header.php" ?>
   <?php include_once "public/_aside.php" ?>
    <div class="content">
      <div class="panel new">

        <h3><?php echo $dataArr[0]["name"] ?></h3>

          <!-- 遍历数组 生成结构 -->
        <?php 
        foreach($dataArr as $value):
         ?>
        <div class="entry">
          <div class="head">
            <a href="detail.php?postId=<?php echo $value['id']?>"><?php echo $value["title"]?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $value["nickname"]?> 发表于 <?php echo $value["created"]?></p>
            <p class="brief"><?php echo $value["content"]?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $value["views"]?>)</span>
              <span class="comment">评论(<?php echo $value["commentsCount"]?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $value["likes"]?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $value["name"]?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="<?php echo $value['feature'] ?>" alt="">
            </a>
          </div>
       </div>
     <?php endforeach ?>

       
        <div class="loadmore" >
    		<span class="btn">加载更多...</span>
    	  </div>
      </div>
      	 
    </div>
   
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="static/assets/vendors/jquery/jquery.min.js"></script>
  <script >
  		$(function(){
  			// 定义一个变量，记录第几次获取
  			// 设置全局变量,
  			var currentPage = 1;
  			$(".loadmore .btn").on("click",function(){
  				// search 属性是一个可读可写的字符串，可设置或返回当前 URL 的查询部分（问号 ? 之后的部分）。
  				var categoryId = location.search.split("=")[1];
          // console.log(categoryId);
  				currentPage++;
  				// 发送异步请求，访问后台接口
  				$.ajax({
  					type:"post",
  					url:"api/_getMorePost.php",
  					data:{
  						"categoryId": categoryId, 
                  		"currentPage": currentPage, 
                  		"currentSize": 10
  					},
  					success:function(res){
  						console.log(res);

  						// 回调函数成功的内容
  						if(res.code==1){
  							// res 中打印出来为数组
  							// 遍历数组，动态生成结构
  							var data = res.data;
  							// var str= "";
  							$.each(data,function(index,value){
  								// str += ' <div class="entry">\
  								// 字符串中 要进行换行  用转义字符
  									var str ='<div class="entry">\
          									<div class="head">\
            									<a href="detail.php?postId='+value['id']+'">'+value["title"]+'</a>\
          									</div>\
         								 <div class="main">\
           								 <p class="info">'+value["nickname"]+' 发表于 '+ value["created"] +'</p>\
           								 <p class="brief">'+ value["content"]+'</p>\
           								 <p class="extra">\
             							 <span class="reading">阅读('+value["views"]+')</span>\
            							 <span class="comment">评论('+ value["commentsCount"]+')</span>\
              							 <a href="javascript:;" class="like">\
                						<i class="fa fa-thumbs-up"></i>\
               							 <span>赞('+ value["likes"]+')</span>\
             							 </a>\
              							<a href="javascript:;" class="tags">\
               							分类：<span>'+value["name"]+'</span>\
              							</a>\
            							</p>\
            							<a href="javascript:;" class="thumb">\
             							 <img src="'+ value['feature'] +'" alt="">\
          								  </a>\
          								</div>\
      									 </div>';

      								var entry = $(str);
      								entry.insertBefore('.loadmore');
  							});
                
  							// 生成结构完毕后，要判断一下这次获取文章的数据是不是最后的数据了
  							var maxPage = Math.ceil(res.pageCount/10);
  							console.log(maxPage);
  								if(currentPage == maxPage){
  									// 隐藏加载更多的按钮
  									$(".location  .btn").hide();
  								}
  							
  						}



  					}
  				})
  			})
  		})
  </script>
</body>
</html>
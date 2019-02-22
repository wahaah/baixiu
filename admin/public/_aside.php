<div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li class="<?php echo $current_page == "index"?"active":""; ?>">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
        <?php
         // echo $current_page;
          $pageArr=["posts","post-add","categories"];
          // 判断某个元素是否在数组中
          // in_array(某个元素,数组)
          $bool = in_array($current_page,$pageArr);
          // var_dump($bool);//postsbool(true)
          /*如果当前页面的$current_page变量的值在这个 $pageArr数组中，那么ul就应该展开*/
          /*若要ul展开：
          1.a 标签的class需要去掉，给标签添加一个属性aria-expanded="true"
          2.给ul多加一个class in,也有一个属性aria-expanded="true"
          */
          ?>
        <!-- <a href="#menu-posts" class="collapsed" data-toggle="collapse"> -->
          <!--  -->
        <a href="#menu-posts" class="<?php echo $bool ?"":"collapsed" ?>" data-toggle="collapse" <?php echo $bool ?'aria-expanded="true"':""; ?> >

          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>

        <ul id="menu-posts" class="collapse <?php echo $bool ?"in":"";?>" <?php echo $bool ?'aria-expanded="true"':""; ?>>

          <li class="<?php echo $current_page == "posts"?"active":"";?>" ><a href="posts.php">所有文章</a></li>
          <li class="<?php echo $current_page == "post-add"?"active":"";?>" ><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $current_page == "categories"?"active":"";?>" ><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class="<?php echo $current_page == "comments"?"active":"";?>" >
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class="<?php echo $current_page == "users"?"active":"";?>" >
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
      	<?php 
      		$setArr =["nav-menus","slides","settings"];
      		$setbool = in_array($current_page, $setArr);
      	?>

      		<!--  若要ul展开：
      		          1.a 标签的class需要去掉，给标签添加一个属性aria-expanded="true"
      		          2.给ul多加一个class in,也有一个属性aria-expanded="true" -->
          
        <a href="#menu-settings" class="<?php echo $setbool ? "":"collapsed"  ?>" data-toggle="collapse"  <?php echo $setbool ?'aria-expanded="true"':""; ?>>
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $setbool ? "in":""; ?>"  <?php echo $setbool ?'aria-expanded="true"':""; ?>>
          <li class="<?php echo $current_page == "nav-menus"?"active":""; ?>" > <a href="nav-menus.php">导航菜单</a></li>
          <li class="<?php echo $current_page == "slides"?"active":"";?>" ><a href="slides.php">图片轮播</a></li>
          <li class="<?php echo $current_page == "settings"?"active":"";?>" ><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script type="text/javascript">
 	//使用ajax请求，动态获取用户的头像和昵称
 	$(function(){
 		$.ajax({
 		type:"post",
 		url:"api/_getUserAvator.php",
 		success:function(res){
 			// 从服务端得到的结果在产生头像和昵称
 			if(res.code == 1){
 				// 请求成功后，把头像和昵称修改
 				var profile = $(".profile");
 				/*attr() 方法设置或返回被选元素的属性和值。
				当该方法用于返回属性值，则返回第一个匹配元素的值。当该方法用于设置属性值，则为匹配元素设置一个或多个属性/值对。*/
 				profile.children('img').attr("src",res.avatar);
 				profile.children('h3').text(res.nickname);
 				}
 			}
 		});
 	});

  </script>
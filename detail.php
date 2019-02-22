<?php 
  include_once "config.php";
  include_once "functions.php";

  // 根据文章id获取到文章数据，动态生成结构
  // 1.获取文章id
  // 2.根据文章id到数据库中查找对应文章
  // 3.动态生成结构

  // 1.获取文章id
  $postId = $_GET["postId"];
  // 根据文章id查询数据库
  $connect = connect();
  // sql语句
  $sql = "SELECT p.title,p.created,p.views,p.likes,p.content,c.name,u.nickname FROM posts p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN users u ON u.id = p.user_id
            WHERE p.id = $postId";
  // 执行查询
  $dataArr = query($connect,$sql);
  // print_r($dataArr);
  /*Array ( [0] => Array ( [title] => 适万长 [created] => 2017-06-22 12:09:32 [views] => 189 [likes] => 170 [content] => 来儿南为开阶展头少技理声。是战火例多发价以况引机身西速识两连。置养后红和那带矿部门其交。认万建毛美了命平走断命高要反。学出走除据号可空力应基南状准除习。连感动证极只查应选周对天在空布按。日二江向农使门下八期住较边水交放较。构龙把种数术对会年政值价但例却题。要文根信七清划共界广深要指来导。包头然大东过联安与重度加农全带成后。可系说交自或上委构要意金性构习党。数时名史然话气张可少应石列结特示。 [name] => 会生活 [nickname] => 汪磊 ) )*/

  // 3把文章从二维数组中取出来，方便后面生成结构的时候使用
  $dataArr = $dataArr[0];

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
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
      <div class="article">
        <div class="breadcrumb">
          <dl>
            <dt>当前位置：</dt>
            <dd><a href="javascript:;"><?php echo $dataArr['name']; ?></a></dd>
            <dd><?php echo $dataArr['title']; ?></dd>
          </dl>
        </div>
        <h2 class="title">
          <a href="javascript:;"><?php echo $dataArr['title']; ?></a>
        </h2>
        <div class="meta">
          <span><?php echo $dataArr['nickname']; ?> 发布于 <?php echo $dataArr['created']; ?></span>
          <span>分类: <a href="javascript:;"><?php echo $dataArr['name']; ?></a></span>
          <span>阅读: (<?php echo $dataArr['views']; ?>)</span>
          <span>点赞: (<?php echo $dataArr['likes']; ?>)</span>
        </div>
        <div class="content-detail"><?php echo $dataArr['content']; ?></div>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_2.jpg" alt="">
              <span>星球大战:原力觉醒视频演示 电影票68</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_3.jpg" alt="">
              <span>你敢骑吗？全球第一辆全功能3D打印摩托车亮相</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_4.jpg" alt="">
              <span>又现酒窝夹笔盖新技能 城里人是不让人活了！</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/hots_5.jpg" alt="">
              <span>实在太邪恶！照亮妹纸绝对领域与私处</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav> -->
    <?php include_once "public/_navbar.php" ?>
    
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select id="category" name="" class="form-control input-sm">
            <option value="all">所有分类</option>
            <!-- <option value="">未分类</option> -->
          </select>
          <select id="status" name="" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已废除</option>
          </select>
          <input id="btn-filt" type="button" name="" class="btn btn-default btn-sm" value="筛选">
          <!-- 因为再form表单中，会发生跳转 -->
          <!-- <button id="btn-filt" class="btn btn-default btn-sm">筛选</button> -->
        </form>

        <ul class="pagination pagination-sm pull-right">

          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>

      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>

          <script type="text/template" id="tmpId">
            <%
              var status = {
                "drafted":"草稿",
                "published":"已发布",
                "trashed":"已作废"
            };
            %>
            <%
              for(var i=0;i<data.length;i++){ %>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><%=data[i].title%></td>
                <td><%=data[i].nickname%></td>
                <td><%=data[i].name%></td>
                <td class="text-center"><%=data[i].created%></td>
                <td class="text-center"><%=status[data[i].status]%></td>
                <td class="text-center">
                <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
           <% }
            %>
          </script>

          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
    <?php 
    //  在公共文件之前声明变量是可以被公共文件访问
   /* $current_page = "posts";//在_aside中去设置打印，可通过访问posts.php看到输出*/
      // 什么时候要展开？？
      $current_page = "posts";
     ?>
  <?php include_once "public/_aside.php" ?>

  <!-- <div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li class="active">
        <a href="#menu-posts" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse in">
          <li class="active"><a href="posts.php">所有文章</a></li>
          <li><a href="post-add.php">写文章</a></li>
          <li><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="nav-menus.php">导航菜单</a></li>
          <li><a href="slides.php">图片轮播</a></li>
          <li><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div> -->

  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script>NProgress.done()
  $("#delAll").hide();
</script>

  <script type="text/javascript">
     
    //请求后台，把文章数据请求出来。动态生成表格

   $(function(){
      // //每页可放多少条 
          var pageSize = 10;
      //     //页数是多少 最大的页码数
      // 最大的页码数 = Math.ceil(文章的数据的总量/每一页获取的数据的条数)
      // 在第一次获取数据的时候，就计算出最大的数 在动态生成分页按钮
          var pageCount = 4;
      //     // 声明一个变量，记录当前是第几页数据
          var currentPage = 1;
      //    
      // 一开始就需要分页
      // makePageButton();
      function makePageButton(){
        // if(currentPage>pageCount){
        //   currentPage = 1;
        // }
        console.log(currentPage+"------"+pageCount);
         // 根据当前页码计算开始页码与结束页码 
          var start = currentPage - 2;
      //     // 此处判断 是为了当前页是第一页时显示仍为第一页 
          start = start < 1 ? 1 : start;
          var end = start + 4;
      //     //假若总共有3页，然而我们定义要显示5页，此时只需显示3页就好 
          end = end > pageCount ? pageCount : end;

      //     //生成动态的分页结构 

          var html ='';
          // 当页面是第一页或最后一页时 则不显示上一页，下一页的字 
          if(currentPage !=1){
            html = '<li class="item" data-page = "'+(currentPage-1)+'"><a href="javascript:;">上一页</a></li>';
          }
          for(var i=start;i<=end;i++){
          // i是当前页时，则高亮显示，否则不高亮 
          if(i==currentPage){
            // 加自定义属性 data-page
            html+=' <li class="item active" data-page="'+i+'""><a href="javascript:;">'+i+'</a></li>';
          }else{
            html+=' <li class="item" data-page="'+i+'""><a href="javascript:;">'+i+'</a></li>';
          }
        }
          if(currentPage !=pageCount){
            html+= '<li class="item" data-page = "'+(currentPage+1)+'"><a href="javascript:;">下一页</a></li>';
          }
          $(".pagination").html(html);


      }
        
        /*如果我们使用引擎模板中的简洁语法时，注意引入的插件，并且可以将数据放入对象中，放在res中，全部都可用*/
        // 声明数据结构中需要转义的内容，用对象保存
        /*var status = {
            "drafted": "草稿",           
            "published": "已发布",
            "trashed": "已作废"
        };*/

    // 第一次请求，把数据请求回来，动态生成表格结构
    // 页面打开就加载所有的文章
     $.ajax({
      type:"post",
      url:"api/_getPostsData.php",
      data:{
        // 后台文件要求带回两个参数
        "currentPage": currentPage,
        "pageSize": pageSize,
        "status":$("#status").val(),
        "categoryId":$("#category").val()
      },
      // 如果请求成功
      success: function(res){
        // console.log(res);

        
         if(res.code == 1){
          // 还要计算出页码的最大值
          pageCount = res.pageCount;
          // 动态生成分页结构 (这里生成。刚开始就不用生成)
          makePageButton();

          var html = template("tmpId",res);
          $("tbody").html(html);
        }
      }
    });

     /*
      使用委托的方式给每个分页注册点击事件

     */
     // 注意：我们要将页数在动态生成时就添加在里面，加个自定义属性data-page

     $(".pagination").on("click",".item",function(){
        // 根据当前的页码获取数据
        // 此处注意：attr获取的到的是字符串，data得到的是数值，若使用 attr则需要我们将其转换为数值  可以采用ParseINT或者使用Number
        currentPage = parseInt($(this).attr('data-page'));
        // currentPage = $(this).data('page');
        // 根据当前页到服务端请求数据
        $.ajax({
         
          url:"api/_getPostsData.php",
          type:"post",
          data:{
            "currentPage":currentPage,
            "pageSize":pageSize ,
            "status":$("#status").val(),
            "categoryId":$("#category").val()
      },
          success:function(res){
            // console.log(res);
            // 然后我们可以将结果渲染到页面上
            // template("tmpId",res)第一个参数为模板id，第二个参数为对象
            if (res.code==1) {
               // 重新设置最大的页码数
              pageCount = res.pageCount;

              // 要重新生成分页结构
              makePageButton();
            /*  // 遍历数组生成新的元素前，先清空原有的再遍历
              $("tbody").empty();*/
              // 遍历数组重新生成表格结构  但此时点击下一页无效

              var html = template("tmpId",res);
              $("tbody").html(html);
            }
           
          }
        });

     });

     // 先加载所有分类数据
     $.ajax({
      url:"api/_getCategoryData.php",
      // 此时不需要带数据回来，可以不要data{}
      // data:{},
      type:"post",
      success:function(res){
        // console.log(res);
        /*{code: 1, msg: "操作成功", data: [{id: "23", slug: "uncategorized", name: "未分类", classname: "s"},…]}
        code: 1
        data: [{id: "23", slug: "uncategorized", name: "未分类", classname: "s"},…]
        msg: "操作成功"*/

        // 判断请求是否成功
        if(res.code ==1){
          // 遍历数组，生成多个下拉框选项
          var data = res.data;
          $.each(data,function(i,e){
            var html ='<option value="'+e.id+'">'+e.name+'</option>';
            $(html).appendTo("#category");
          })

        }

      }
     })

     // 文章的筛选功能
     // 选中某个分类或某个状态再筛选

      $("#btn-filt").on("click",function(){
        // 点击筛选按钮是，获取下拉框的值，要把下拉框的值待会服务器，再根据下拉框得值完成sql语句的条件部分
        // 把状态对应的值存到option标签的value属性里面，点击时直接获取整个value属性就可知道我们要的状态

        // 如果状态下拉框选中的是所有状态，就是不筛选 给所有状态对应的value值是all,在服务端特殊处理 当status的值是all的情况

        // 点击筛选时，先得到的状态是什么
        var status = $("#status").val();
        // 获取分类id
        var categoryId = $("#category").val();

        // 把条件待会服务端请求数据
        $.ajax({
          url:"api/_getPostsData.php",
          type:"post",
          data:{
            "currentPage":1,
            "pageSize":pageSize,
            "status":status,
            "categoryId":categoryId
          },
          success:function(res){
            
            // 此时一点击会跳转，会有刷新操作，所以要将按钮类型改变
            // console.log(res);
            if(res.code == 1){
              // 遍历数组，生成表格结构
              /*  // 遍历数组生成新的元素前，先清空原有的再遍历
              $("tbody").empty();*/
              // currentPage = 1;
              var html = template("tmpId",res);
              $("tbody").html(html);
              currentPage = 1;
              makePageButton();
            }
          }
        });

      });


   });
  </script>
</body>
</html>

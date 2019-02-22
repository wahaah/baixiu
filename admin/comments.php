<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once "public/_navbar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
         <!--  <li><a href="#">上一页</a></li>
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
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
           <!-- <script type="text/template" id="temp">
             {{each items as val index}}
            <tr class="danger">
           
                <td class="text-center"><input type="checkbox"></td>
                <td>{{val.author}}</td>
                <td style="width:360px;">{{val.content}}</td>
                <td>{{val.title}}</td>
                <td>{{val.created}}</td>
                <td>{{status[val.status]}}</td>
                <td class="text-center">
                  <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
              </td>
          </tr>
          {{/each}} 
          </script>  -->

          <script type="text/template" id="tmpId">
            <%
              var status = {
                "held":"待审核",
                "approved":"准许",
                "rejected":"拒绝",
                "trashed":"回收站"
            };
            %>
            <%
              for(var i=0;i<data.length;i++){ %>
                 <tr class="danger">
                    <td class="text-center"><input type="checkbox"></td>
                    <td><%=data[i].author%></td>
                    <td style="width:360px;"><%=data[i].content%></td>
                    <td><%=data[i].title%></td>
                    <td><%=data[i].created%></td>
                    <td><%=status[data[i].status]%></td>
                    <td class="text-center">
                    <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
                    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                    </td>
             </tr>
           <% }
            %>
          </script> 
         <!--  <tr class="danger">
           <td class="text-center"><input type="checkbox"></td>
           <td>大大</td>
           <td>楼主好人，顶一个</td>
           <td>《Hello world》</td>
           <td>2016/10/07</td>
           <td>未批准</td>
           <td class="text-center">
             <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
             <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
           </td>
         </tr>
         <tr>
           <td class="text-center"><input type="checkbox"></td>
           <td>大大</td>
           <td>楼主好人，顶一个</td>
           <td>《Hello world》</td>
           <td>2016/10/07</td>
           <td>已批准</td>
           <td class="text-center">
             <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
             <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
           </td>
         </tr>
         <tr>
           <td class="text-center"><input type="checkbox"></td>
           <td>大大</td>
           <td>楼主好人，顶一个</td>
           <td>《Hello world》</td>
           <td>2016/10/07</td>
           <td>已批准</td>
           <td class="text-center">
             <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
             <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
           </td>
         </tr> -->
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = "comments" ?>
  <?php include_once "public/_aside.php" ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <!-- 引入分页插件 -->
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <!-- <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script> -->

  <script>NProgress.done()</script>
  <script type="text/javascript">
    $(function(){
      // 声明变量  表示当前是第几页  及每页取多少条数据
      var currentPage = 1;
      var pageSize = 10;
      var pageCount;
      // 用简洁模板时打开
      // var state = {
      //   // 状态（待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed））
      //   "held":"待审核",
      //   "approved":"准许",
      //   "rejected":"拒绝",
      //   "trashed":"回收站"
      // }

      getCommentData();  //一开始就加载数据，分页显示
    function getCommentData(){       
      $.ajax({
        url:"api/_getCommentsData.php",
        type:"post",
        data:{
         "currentPage": currentPage,
         "pageSize":pageSize
        },
        success:function(res){
          // console.log(res);
          // 先判断是否成功
          if(res.code==1){
            pageCount = res.pageCount;
            // console.log(res);
            // 动态渲染表格
            // 遍历数组生成结构
              // 原生
                var html = template("tmpId",res);
                $("tbody").html(html);
              /*  // 简洁
                  var data = res.data;
                     var html = template("temp",{items:data, status:state});
                     $("tbody").html(html);*/
                      // 完成分页效果  使用插件
           // 1.先引入插件  twbs-pagination
           // 2.使用样式，可以是bootstrap提供的样式，也可以是自己的样式
           // 3.要有一个可以调用函数的标签，可以是ul也可以是div
           // 4调用  twbsPagination  完成分页效果
           // pagination
      
           // 注意  $pageCount数据回来后才有
            $(".pagination").twbsPagination({
             // totalPages最大的页码数
                 // totalPages: 35,
                 totalPages: pageCount,
                 //  visiblePages总共显示多少个分页按钮
                 visiblePages: 5,
                 // 点击每个分页按钮时执行的操作
                 //   event事件对象
                 // page当前的页码数
                 onPageClick: function(event, page) {
                  
                   // 获取当前分页的数据
                     currentPage = page;
                      // 每次点击分页按钮时也要获取数据
                     getCommentData();
                 }
                });
      
               }
             }
          
      });
    }

     

    });
  </script>
</body>
</html>

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
    
    <?php include_once "public/_navbar.php"; ?>

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
        <div id="btn_batch" class="btn-batch">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
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
          <!-- <script type="text/template" id="tempId">
              <% for(var i = 0; i < data.length; i++) { %>
                  <tr data-comments-id="<%= data[i].id %>">
                    <td class="text-center"><input type="checkbox"></td>
                    <td><%= data[i].author %></td>
                    <td style="width: 400px;"><%= data[i].content %></td>
                    <td><%= data[i].title %></td>
                    <td><%= data[i].created %></td>
                    <td><%= data[i].status %></td>
                    <td class="text-center">
                      <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
                      <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                    </td>
                  </tr>
              <% } %>
          </script> -->
          <script type="text/template" id="tempId">
              {{ each data val }}
                  <tr data-comments-id="{{ val.id }}">
                    <td class="text-center"><input type="checkbox"></td>
                    <td>{{ val.author }}</td>
                    <td style="width: 400px;">{{ val.content }}</td>
                    <td>{{ val.title }}</td>
                    <td>{{ val.created }}</td>
                    <td>{{ sta[val.status] }}</td>
                    <td class="text-center">
                      <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
                      <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                    </td>
                  </tr>
              {{ /each }}
          </script>
        </tbody>
      </table>
    </div>
  </div>

  <?php 
    $current_page = "comments";
  ?>
  <?php include_once "public/_aside.php"; ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- <script src="../static/assets/vendors/art-template/template-native.js"></script> -->
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script>
    NProgress.done();
    $("#btn_batch").hide();

    $(function() {
        // 声明默认数据变量
        var currentPage = 1;
        var pageSize = 10;
        var pageCount;

        // 声明对象
        var status = {
            "held": "未审核",
            "approved": "以准许",
            "rejected": "已拒绝",
            "trashed": "已删除"
        }

        // 页面一加载进来就发送请求
        getCommentsData();
        function getCommentsData() {
            $.ajax({
                type: "post",
                url: "api/_getCommentsData.php",
                data: {
                    "currentPage": currentPage,
                    "pageSize": pageSize
                },
                success: function(res) {
                    if(res.code == 1) {
                        pageCount = res.pageCount;
                        /* var html = template("tempId", res);
                          1，如果是原生的调用，就使用 template-native.js 
                          2，规定第二个参数一定要是对象
                              a, 如果返回的数据本身就是对象，那么直接放在第2个参数的位置
                              b, 如果返回的数据是一个数组，那么改写成对象 {"数组名": 数组}
                          3，如果是a, 那么对象中数组叫什么，模板就遍历什么
                             如果是b, 那么数组名叫什么，模板就遍历什么
                        */
                        res.sta = status; // 追加一个对象信息
                        // 1.0 动态渲染页面结构
                        var html = template("tempId", res);
                        /*
                          1，如果是简洁模板的调用，要区分有没有-web
                              template.js   /   template-web.js
                              template.js :遍历的时候在值得前面要加as关键字 each data as val
                              template-web.js: 遍历的时候不需要加   each data val
                          2，如果传进来的是对象，那么遍历的就是对象中的数组名
                          3，如果传进来的是数组，那么遍历的就是$data
                              注意： 严格使用 $data 关键字，和当前传进来的数组没有关系
                         */
                        $("tbody").html(html);


                        // 2.0调用分页的插件
                        $(".pagination").twbsPagination({
                            totalPages: pageCount,
                            visiblePages: 7,
                            onPageClick: function(event, page) {
                                currentPage = page;
                                getCommentsData();
                            }
                        })
                    }
                    
                }
            })
        }


       
    })
  </script>
</body>
</html>

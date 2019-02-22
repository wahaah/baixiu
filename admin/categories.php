<?php 
  require_once "../config.php";
  require_once "../functions.php";

  // 完成登陆验证
  checklogin();

 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div  class="alert alert-danger" style="display:none">
        <strong >错误！</strong><span id="msg"></span>

        <!-- //发生XXX错误 -->
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="data">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="类名">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
             <!--  <button id="btn-add" class="btn btn-primary" type="button">添加</button> -->
              <input id="btn-add" type="button" class="btn btn-primary" value="添加">
              <input style="display: none;" id="btn-edit" type="button" class="btn btn-primary" value="编辑完成">
              <input style="display: none;" id="btn-cancel" type="button" class="btn btn-primary" value="取消编辑">

            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                 <td>fa-fire</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td>fa-fire</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td>fa-fire</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php  $current_page = "categories"; ?>
  <?php include_once "public/_aside.php" ?>

  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script type="text/javascript">
    
    $(function(){
      // 
      $.ajax({
        type:"post",
        url:"api/_getCategoryData.php",
        success:function(res){
          if(res.code==1){
              // 在请求成功的情况下，动态渲染表格
              var str = "";
              var data =res.data;
              $.each(data,function(i,e){
                // 通过自定义属性获取分类id
                 str+='<tr data-categoryId="'+e.id+'">\
                <td class="text-center"><input type="checkbox"></td>\
                <td>'+e.name+'</td>\
                <td>'+e.slug+'</td>\
                 <td>'+e.classname+'</td>\
                <td class="text-center">\
                  <a href="javascript:;" data-categoryId ="'+e.id+'" class="btn btn-info btn-xs edit">编辑</a>\
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>\
                </td>\
              </tr>';
              });
              $(str).appendTo('tbody');
          }
        }
      });

      // 完成注册事件,点击按钮添加分类数据
      $("#btn-add").on("click",function(){
        // 获取表单元素
        var name = $("#name").val();
        var slug = $("#slug").val();
        var classname = $("#classname").val();
        // 完成表单的非空验证
        if(name == ""){
          $("#msg").text("分类的名称不能为空");
           $(".alert").show();
           return;
        }
        if(slug == ""){
          $("#msg").text("分类的别名不能为空");
           $(".alert").show();
           return;
        }
        if(classname == ""){
          $("#msg").text("分类的图标不能为空");
           $(".alert").show();
           return;
        }
        
        // 数据发送到服务端
        $.ajax({
          url:"api/_addCategory.php",
          data: $("#data").serialize(), // 给form元素加一个id
          type:"post",
          success: function(res) {
            // res  是个字符串不是对象
            // 根据返回的结果，动态生成一行数据
            // 判断返回的结果是否成功，若成功则动态生成表格
            if(res.code == 1){
              // 生成结构  重新渲染
              var str = '<tr>\
                <td class="text-center"><input type="checkbox"></td>\
                <td>'+name+'</td>\
                <td>'+slug+'</td>\
                 <td>'+classname+'</td>\
                <td class="text-center">\
                  <a href="javascript:;" class="btn btn-info btn-xs ">编辑</a>\
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>\
                </td>\
              </tr>';
              $(str).appendTo('tbody');
            }
          }
        });
      });


      /*定义一个全局变量，保存一下 点击编辑的是哪一行*/
      var  currentRow;
      // 编辑按钮添加事件
      $("tbody").on("click",".edit",function(){

        //在这里完成编辑的逻辑

        // 先把点击对应的行保存起来
          currentRow = $(this).parents("tr");

         // 先获取点击按钮对应的数据id
         var categoryId = $(this).attr("data-categoryId");
         // console.log(categoryId);
         // 把对应id存储到编辑完成按钮上
         $("#btn-edit").attr("data-categoryId",categoryId);
        // 先隐藏添加按钮，在显示其他两个
        $("#btn-add").hide();
        $("#btn-edit").show();
        $("#btn-cancel").show();
        // 把点击的按钮对应的数据填充到对应的输入框
        var name = $(this).parents("tr").children().eq(1).text();
        var slug = $(this).parents("tr").children().eq(2).text();
        var classname = $(this).parents("tr").children().eq(3).text();
        // console.log(name);
        // 把获取到的内容填充到对应输入框中
        $("#name").val(name);
        $("#slug").val(slug);
        $("#classname").val(classname);



      });

      // 编辑完成按钮的点击事件
      $("#btn-edit").on("click",function(){
        // id是唯一的  设置一个自定义属性
        // 把表单中数据更新到数据库中
        // 先获取点击按钮对应的数据id
        var categoryId = $(this).attr("data-categoryId");
        // console.log(categoryId);

         // 1.收集表单数据  验证表单数据是否填写完整
        var name = $("#name").val();
        var slug = $("#slug").val();
        var classname = $("#classname").val();
        // 完成表单的非空验证
        if(name == ""){
          $("#msg").text("分类的名称不能为空");
           $(".alert").show();
           return;
        }
        if(slug == ""){
          $("#msg").text("分类的别名不能为空");
           $(".alert").show();
           return;
        }
        if(classname == ""){
          $("#msg").text("分类的图标不能为空");
           $(".alert").show();
           return;
        }
        // 把id和修改后的数据，发送到服务器，根据id对数据更新
        $.ajax({
          url:"api/_updateCategory.php",
          type:"post",
          data:{
            name:name,
            slug:slug,
            classname:classname,
            id:categoryId
          },
          success:function(res){
            // 若修改成功
            if(res.code ==1){
              // 要把两个编辑的按钮隐藏，把添加的按钮显示
              $("#btn-add").show();
              $("#btn-edit").hide();
              $("#btn-cancel").hide();

              // 清空之前先保存之前修改后的内容
              var name = $("#name").val();
              var slug = $("#slug").val();
              var classname = $("#classname").val();

              // 清空输入框
              $("#name").val("");
              $("#slug").val("");
              $("#classname").val("");
              /* $("#name, #slug, #classname").val("");
*/

              // 把对应的数据更新到表格中  
              currentRow.children().eq(1).text(name);
              currentRow.children().eq(2).text(slug);
              currentRow.children().eq(3).text(classname);

             

            }

          }
        })
      });

      // 取消编辑
      $("#btn-cancel").on("click",function(){
        // 把对应的按钮显示和隐藏
         $("#btn-add").show();
         $("#btn-edit").hide();
         $("#btn-cancel").hide();

        // 清空输入框
         $("#name").val("");
         $("#slug").val("");
         $("#classname").val("");
      });

      /*点击删除按钮，删除数据*/
      // 用事件触发
      $("tbody").on("click",".del",function(){
        // 先把当前的行记录下来，当删除成功时，就把这一行删除掉
        var row = $(this).parents("tr");

        // 根据当前点击的按钮对应的行，得到其对应的id，在数据库中删除数据
        // 可将自定义id存在他们共有的身上
        // 当我们做批量删除时，要将id放到他们共有的身上
        // 
        // 先获取要删除数据的id
        // var categoryId = $(this).parents('tr').attr("data-categoryId");
        var categoryId = row.attr("data-categoryId");

        // console.log(categoryId);
        // 把要删除的id发送回服务端
        $.ajax({
          type:"post",
          url:"api/_delCategory.php",
          data:{"id":categoryId},
          success:function(res){
            // 如果删除成功，也要把对应的行给删除掉
            if(res.code== 1){
              // 要把对应的行移除掉
              row.remove();
            }

          }
        })
      });


      // 全选功能的实现
      $("thead input").on("click",function(){
        // 控制别的复选框和当前选中状态一样
        var status = $(this).prop("checked");
        // 全选和全不选
        $("tbody input").prop("checked",status);

        if(status){
          $("#delAll").show();
        }else{
          $("#delAll").hide();
        }
      });

      /*使用委托的方式为别的多选框注册点击点击事件*/
      $("tbody").on("click","input",function(){
        // 控制全选的多选框是否选中，只有当所选的复选框都选中，全选才选中
        // 获取全选多选框
        var all = $("thead input");
        var cks = $("tbody input");
        // 如果cks里面的所有多选框都选中，全选也选中
        if(cks.size() == $("tbody input:checked").size()){
          all.prop("checked",true);
        }else{
          all.prop("checked",false);
        }

        // all.prop("checked",cks.size()==$("tbody input:checked").size());
        // 选中的多选框超过两个，就显示批量删除
        if($("tbody input:checked").size()>=2){
           $("#delAll").show();
        }else{
          $("#delAll").hide();
        }

      });

      // 批量删除
      $("#delAll").on("click",function(){
        var ids = [];
        // 收集所有选中的id
        // 注意：不能加空格
        var cks  = $("tbody input:checked");
        cks.each(function(index,el){
          var id = $(el).parents("tr").attr("data-categoryId");
          // var id = $(el).parents("tr").data("categoryId");
          // 
          ids.push(id);
        })
        $.ajax({
          type:"post",
          url:"api/_delAllCategory.php",
          data: {
            "ids" : ids
          },
          success:function(res){
            // 如果删除成功，要删除对应的行
            if(res.code == 1){
              cks.parents("tr").remove();
            }
          }
        })
      })


});
  </script>
</body>
</html>

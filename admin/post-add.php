<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="data-form">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label  for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
             <input id="btn-save" class="btn btn-primary" type="button" value="保存">
           <!--  <button class="btn btn-primary" type="submit">保存</button> -->
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php  $current_page = "post-add"; ?>
  <?php include_once "public/_aside.php" ?>

  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <!-- 使用富文本编辑器要引入的插件 -->
  <script src="../static/assets/vendors/ckeditor/ckeditor.js"></script>
  <script type="text/javascript">
    // 设置入口函数 
    $(function(){
      // 注意此时不能用click来触发该事件
      $("#feature").on("change",function(){
        // 文件上传
        var file = this.files[0];
        // var file = e.target.files[0];//第二种获取方式，注意添加参数

        // jQuery无法直接上传文件，需要通过formData对象配合上传
        var data = new FormData();

        // 
        data.append("file",file);
        // 第一个file相当键，可以修改为其他如abc  此时后台也需要在获取时改为abc
        $.ajax({
          type:"post",
          url:"api/_uploadFile.php",
          data : data,
          // 此时data是用Formdata构造的上传对象
          // 配置相关参数，才能带回服务端
          contentType:false,
          // 只有设置了这个参数，才能把数据待会服务端
          processData:false,
          // 告诉jquery不要序列化参数
          success:function(res){
            if(res.code == 1){
              //把图片预览 上传成功修改图片路径
              $(".help-block").attr("src", res.src).show();
            }
          }


        });
      });

      // 富文本   有格式的文本
        // CKEDITOR----插件
        /*使用富文本插件的步骤
        1.先引入插件
        2.准备文本域，该文本域需要一个id
        3.调用插件提供的方法，初始化富文本编辑器 CKEDITOR.replace(对应文本域的id);*/
        /*把富文本编辑器初始化的方法*/
      CKEDITOR.replace("content");
      // 点击保存按钮
      $("#btn-save").on("click",function(){
        // 在收集数据前，得先把富文本编辑器中的内容更新到文本域当中
        /*如果要把编辑器中的内容更新到对应的文本域中，需调用插件提供的一个方法
        编辑器对象.updateElement()
        获取编辑器对象：CKEDITOR.instances.初始化的时候所使用的id */
        console.log(CKEDITOR.instances);
        /*输出一个对象，他的键是content  通过键的到对应的编辑器对象*/
        CKEDITOR.instances.content.updateElement();//把编辑器中的内容更新到文本域中

        /*加上后会打印出  title=&content=%3Col%3E%3Cli%3Etrhtrhyhty%3C%2Fli%3E%3Cli%3Etbtyn%3C%2Fli%3E%3C%2Fol%3E&slug=&category=1&created=&status=drafted
        此时content中会有内容   $0.value可打印其内容*/

        // 点击保存按钮收集表单数据，发送回服务器  data-form表单id
        var data = $("#data-form").serialize();
        // serialize();会根据name属性获得内容 如果textarea中的内容没有，此处的content
        // 得到的也没有    可在控制台中通过$0快速选中选择的代码   $0.value可打印其内容
        // console.log(data);
        /*title=def&content=&slug=de&category=2&created=2020-12-19T15%3A20&status=drafted*/
        // 此时只有content中没有内容，没有拼接到


        // 发送回服务端进行文章的新增操作
        $.ajax({
          url:"api/_addposts.php",
          type:"post",
          data:data,
          success:function(res){
            console.log(res);
          }
        })


      });



    });
  </script>
</body>
</html>

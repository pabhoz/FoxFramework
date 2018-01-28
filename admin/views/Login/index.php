<?php include MODULE."head.php"; ?><body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <!--img src="<?php print(URL); ?>public/assets/images/logo.png" alt=""-->
      RedFoxGYM | Administración
    <!--a href="#"><b>Certeza</b>ERP</a-->
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <form id="loginForm" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="usuario" placeholder="Usuario">
        <span class="fa fa-user-circle-o form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Contraseña">
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-block btn-flat" style="background-color:#DD3555 !important; color: white; font-weight:bolder; margin-bottom: 8px;">Entrar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

    <a href="#" class="text-red" style="color:#DD3555 !important;">Olvidé mi contraseña</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php print(URL); ?>public/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php print(URL); ?>public/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php print(URL); ?>public/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    $("#loginForm").submit(function(e){
      e.preventDefault();
      var data = {
        usuario: $(this).find("input[name='usuario']").val(),
        password: $(this).find("input[name='password']").val()
      };
      $.ajax({
        url: "<?php print(URL); ?>Login/login",
        method: "POST",
        data: data
      }).done(function(r){

        var r = JSON.parse(r);

        if(r.error){
          alert(r.msg);
        }else{
          //alert(r.msg);
          document.location = "<?php print(URL); ?>";
        }
      });
    });
  });

</script>
</body>
</html>

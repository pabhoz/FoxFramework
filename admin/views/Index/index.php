<?php //$this->loadModule("auth"); ?>
<?php $this->loadModule("head"); ?>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <?php $this->loadModule("header"); ?>
  <?php $this->loadModule("aside"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div id="asyncLoadArea" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <!-- Section Title -->
        Dashboard
        <!-- Section Subtitle -->
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include MODULE."footer.php"; ?>
<!-- ./wrapper -->
<?php include MODULE."scripts.php"; ?>
<script type="text/javascript" src="<?php print(URL); ?>public/js/asynchronousUX.js"></script>
<script type="text/javascript">
//Script para cargar la primera pagina
  $(function(){
      $.ajax({url:"<?php print(URL); ?>Example/dummyData",method: "GET"}).done(function(response){
        $("#asyncLoadArea").html(response);
      });
  });
</script>
</body>
</html>

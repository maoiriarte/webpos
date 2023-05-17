<?php
include_once'db/connect_db.php';
session_start();
if(isset($_POST['btn_login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $select = $pdo->prepare("select * from tbl_user where username='$username' AND password='$password' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if($row['username']==$username AND $row['password']==$password AND $row['role']=="Admin" AND $row['is_active']=="1"){
        $_SESSION['user_id']=$row['user_id'];
        $_SESSION['username']=$row['username'];
        $_SESSION['fullname']=$row['fullname'];
        $_SESSION['role']=$row['role'];

        $message = 'success';
        header('refresh:2;dashboard.php');

    }else if($row['username']==$username AND $row['password']==$password AND $row['role']=="Operator" AND $row['is_active']=="1"){
        $_SESSION['user_id']=$row['user_id'];
        $_SESSION['username']=$row['username'];
        $_SESSION['fullname']=$row['fullname'];
        $_SESSION['role']=$row['role'];
        $message = 'success';
        header('refresh:2;dashboard.php');
    }else {
        $errormsg = 'error';
    }
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IPOS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- normalize.css -->
  <link rel="stylesheet" href="dist/css/normalize.css">
  <link rel="shortcut icon" href="img/POS-WEB-LOGO 2.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <!--Sweetalert Plugin --->
  <script src="bower_components/sweetalert/sweetalert.js"></script>
  <script src="plugins/swiftalert2/swiftalert2.all.min.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

  <body class="hold-transition login-page" style="background-color:#333">
  <div class="">
     <!-- <H4>
     <input type="text" class="form-control" name="date" value="<?php echo date("d-m-Y");?>" readonly
                    data-date-format="dd-mm-yyyy">
    </H4>  -->
  </div>
   
  
   <div class="login-box "  style="display:block; margin-top:80px" >
      <div class="login-box-body animate__animated animate__headShake">
      <img src="img/LOGIN-POS.png" style="display:block; margin:auto;" alt="">
      
      <!-- /.login-logo -->
  
    <p class="login-box-msg">Inicio de sesión</p>

    <form action="" method="post" autocomplete="off">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="username" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
            <button type="submit" class="text-muted text-center btn-block btn btn-primary btn-rect" name="btn_login"><i class="fa fa-sign-in" aria-hidden="true"></i>     Ingresar</button><br>
        </div>
        
      </div>
      <div class="align-center">
      <img src="./img/LOGO MID.png" style="display:block; margin:auto; width:100px" alt="">
        <p href=""><h6  class="col-md-offset-5">Create by <br></h6>
        <h6 class="" align="center"><b>M I D - Servicios Tecnológicos ®</b></p></h6>
        <h6 class="" align="center"><b>20220330</b></p></h6>
        <!-- <div class>
        <h6 class="" align="center"><b>Ing. Mauricio Iriarte Díaz</b></p></h6>
        </div> -->
        
        
      </div>
    
 
      <?php
        if(!empty($message)){
          echo'<script type="text/javascript">
              jQuery(function validation(){
              swal.fire("Login Success", "Bienvenid@ '.$_SESSION['fullname']." - ".$_SESSION['role'].'", "success", {
              button: "Continue",
                });
              });
              </script>';
            }else{}
        if(empty($errormsg)){
        }else{
          echo'<script type="text/javascript">
              jQuery(function validation(){
              swal.fire("Ingreso fallido", "Usuario o contraseña incorrectos", "error", {
              button: "Continue",
                });
              });
          </script>';
        }
      ?>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>


</body>
</html>

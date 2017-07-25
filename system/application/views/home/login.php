<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>SILAHKAN LOGIN UNTUK AKSES KE SISTEM</title>
	<!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets/css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- end: CSS -->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>system/application/views/home/img/favicon.ico">
	<!-- end: Favicon -->
	
			<!--<style type="text/css">
			body { background: url(<?php echo base_url(); ?>system/application/views/home/img/bg.jpg) !important; }
		</style>*/-->

		
		
</head>
	<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-offset-3">
                <div class="login-panel panel panel-green">
                    <div class="panel-heading">
                       <!--  <div class="panel-body"> -->
                            <img src="<?php echo base_url(); ?>assets/image/logo pnp small.PNG">
                            <i class="panel-title">SISPRO 2017</i> 
                        <!-- </div> -->
                        <!-- <h4 class="panel-title">The New SISPRO :D</h4> -->
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo "".base_url()."index.php/web/login" ?>" method="post">
                            <fieldset>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" id= "username" placeholder="type username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group input-group">
                                	<span class="input-group-addon"><i class="fa fa-key"></i></span>
									<input class="form-control" name="password" id="password" type="password" placeholder="type password"/>
                                </div>
                                
                                <div class="button-login">  
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="panel-footer">
                        PT. PURA NUSAPERSADA
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="assets/js/jquery1.9.js"></script>
    <script src="assets/js/jquery1.9.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="assets/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="assets/js/sb-admin-2.js"></script>
</body>
</html>

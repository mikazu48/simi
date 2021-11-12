<!doctype html>
<html lang="en">

<head>
	<title>Login 01</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="../assets/login/css/style.css">

</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<!-- <div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Login #01</h2>
				</div> -->
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
						<div class="icon d-flex align-items-center justify-content-center">
							<span class="fa fa-user-o"></span>
						</div>
						<h3 class="text-center mb-4">Register</h3>
						<form action="<?php echo base_url('login/login')?>" class="login-form" method="post">
							<?php if($this->session->flashdata('msg')){ ?>
							<div class="alert alert-warning alert-dismissible" role="alert">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Warning!</strong><br> <?php echo $this->session->flashdata('msg');?>
							</div>
							<?php } ?>
							<div class="form-group">
								<input name="username" type="text" class="form-control rounded-left" placeholder="Username" required>
							</div>
							<div class="form-group d-flex">
								<input name="password" type="password" class="form-control rounded-left" placeholder="Password" required>
							</div>
							<div class="form-group">
								<input name="nama_lengkap" type="text" class="form-control rounded-left" placeholder="Nama Lengkap" required>
							</div>
							<div class="form-group">
								<input name="email" type="email" class="form-control rounded-left" placeholder="Email" required>
							</div>
							<div class="form-group">
								<button name="submit" type="submit" class="form-control btn btn-primary rounded submit px-3">Register</button>
							</div>
							<div class="form-group d-md-flex">
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>

</body>

</html>

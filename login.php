<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>Login</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">

</head>
    
<?php
 
 session_start();
 
 if( isset($_SESSION['user_id']) ){
	header("Location: index.php");
 }
 
 require 'db.php';
 
 $message = '';
 
  if(!empty($_POST['username']) && !empty($_POST['password'])):
	
	//Login user
	$records = $conn->prepare('SELECT id,username,password,superuser FROM login WHERE username = :username');
	$records->bindParam(':username', $_POST['username']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$message = '';
	if(count($results) > 0 && password_verify($_POST['password'], $results['password'])){
		$_SESSION['user_id'] = $results['id'];
        if($results['superuser'] > '0'){
            $_SESSION['super_id'] = $results['superuser'];
            header("Location: index.php");
        } else {
            header("Location: index.php");
        }
	} else {
		$message = 'Sorry, those credentials do not match';
	}
 endif;
?>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-group mb-0">
                    <div class="card p-3">
                        <div class="card-block">
                            <h1>Login</h1>
                            <?php if(!empty($message)): ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <form action="login.php" method="post">
                                <p class="text-muted">Sign in to your account</p>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="username" name="username" class="form-control" placeholder="Username">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" value="login" class="btn btn-primary px-4">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/tether/dist/js/tether.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>

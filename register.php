<!DOCTYPE html>
<html lang="en">
    
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>Register</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">

</head>

<?php
 
 session_start();
 
 if(isset($_SESSION['super_id']) ){
	
 } else {
     header("Location: index.php");
 }
 
 require 'db.php';
 
 $message = '';
 
//Userregistration
 if(!empty($_POST['username']) && !empty($_POST['password'])):
	
	//Check if username is already in use
	$records = $conn->prepare('SELECT id,username,password FROM login WHERE username = :username');
	$records->bindParam(':username', $_POST['username']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$message = '';
	if($results > 0) {
		$message = 'That username is already in use!';
	} else {
		
		//Checks if the passwords you entered match
		if($_POST['password'] == $_POST['confirm_password']) {
			
			//Makes sure your password isn't the same as your username
			if($_POST['password'] == $_POST['username']) {
				
				 $message = 'Your password cannot be the same as your username!';
	 
			} else {
				
				$pwd = $_POST['password'];
				
				if(strlen ($pwd) < 4 ) {
				
					 $message = 'Your password must be atleast 5 characters!';
					 
				} else {
					
					 //Creates the account
					 $sql = "INSERT INTO login (username, password, email, fname, lname, superuser) VALUES (:username, :password, :email, :fname, :lname, :superuser)";
					 $stmt = $conn->prepare($sql);
					 
					 $stmt->bindParam(':username', $_POST['username']);
					 $stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));
                     $stmt->bindParam(':email', $_POST['email']);
					 $stmt->bindParam(':fname', $_POST['fname']);
                     $stmt->bindParam(':lname', $_POST['lname']);
					 $stmt->bindParam(':superuser', $_POST['superuser']);
					 if( $stmt->execute() ):
						 $message = 'Success! You can now login with your username and password!';
					 else:
						 $message = 'Sorry there must have been an issue creating your account';
					 endif;
					
				}
				
			}
			
		} else {
			 $message = 'The passwords you entered dont match!';
		}
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
                            <h1>Register</h1>
                            <?php if(!empty($message)): ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <form action="register.php" method="post">
                                <p class="text-muted">Register a account</p>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Passwords must match" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" name="fname" class="form-control" placeholder="First name" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" name="lname" class="form-control" placeholder="Last name" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-user-plus"></i>
                                    </span>
                                    <select class="form-control" name="superuser" placeholder="Superuser?" required>
                                    <option value="" selected disabled>Superuser?</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button name="back" onclick="location.href='index.php';" class="btn btn-primary px-4">Go back</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" name="register" value="register" class="btn btn-primary px-4">Register</button>
                                    </div>
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

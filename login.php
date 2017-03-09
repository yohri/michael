<?php
    require_once('./dbinfo.inc.php');
	session_start();
	
	function login_form($message)
	{
		echo <<<EOD
		<body style="font-family: Arial, sans-serif;">
		
		<h2>Login Page</h2>
		<p>$message</p>
		<form action="login.php" method="POST">
			<p>Username: <input type="text" name="username"></p>
			<p>Password: <input type="password" name="password"></p>
			<input type="submit" value="Login">
		</form>
		</body>
EOD;
	}
	
	if (!isset($_POST['username']) || !isset($_POST['password'])){
		login_form('Welcome');
	}else{
		// Check validity of the supplied username & password
		$c = oci_pconnect(ORA_CON_UN,ORA_CON_PW,ORA_CON_DB);
		oci_set_client_identifier($c, 'admin');
		
		$s = oci_parse($c, 'select app_username from php_sec_admin.php_authentication
							where app_username = :un_bv and app_password = :pw_bv');
		oci_bind_by_name($s, ":un_bv", $_POST['username']);
		oci_bind_by_name($s, ":pw_bv", $_POST['password']);
		oci_execute($s);
		$r = oci_fetch_array($s, OCI_ASSOC);
		
		if ($r){
			// The password matches: the user can use the application.
			
			// Set the username to be used as the client identifier in future HTTP requests:
			$_SESSION['username'] = $_POST['username'];
			
			echo <<<EOD
			<body style="font-family: Arial, sans-serif;">
			<h2>Login was successful</h2>
			<p><a href="application.php">Run the Application</a></p>
			</body>
EOD;
		}else{
			// No rows matched so login failed
			login_form('Login failed. Invalid username/password'); 
		}
	}
?>
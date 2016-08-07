<?php
/**
 * This User will have functions that hadles user registeration,
 * login and forget password functionality
 * @author muni
 * @copyright www.smarttutorials.net
 */
 
class Cl_User
{
	/**
	 * @var will going contain database connection
	 */
	protected $_con;
	
	/**
	 * it will initalize DBclass
	 */
	public function __construct()
	{
		$db = new Cl_DBclass();
		$this->_con = $db->con; 
	}
    
    //Function to allow users to store venues into account.    
    public function store( array $data)
	{
        //checks if anyone is logged in
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
            if( !empty($data)) {
                $userId = $_SESSION['user_id'];
                
                 // Trim all the incoming data:
                $trimmed_data = array_map('trim', $data);
                
                // escape variables for security
                $Vname = mysqli_real_escape_string( $this->_con, $trimmed_data['vname'] );
                $Vid = mysqli_real_escape_string( $this->_con, $trimmed_data['vid'] );
                $Vaddress = mysqli_real_escape_string( $this->_con, $trimmed_data['vaddress'] );
                $Vimage = mysqli_real_escape_string( $this->_con, $trimmed_data['vimage'] ); 
                $Vlat = mysqli_real_escape_string( $this->_con, $trimmed_data['vlat'] ); 
                $Vlng = mysqli_real_escape_string( $this->_con, $trimmed_data['vlng'] );
                //makes sure the user hasn't already saved venue
                $query = "SELECT * FROM venuetable WHERE v_id='".$Vid."' AND user_id ='".$userId."'"; 
                $result = mysqli_query($this->_con,$query)or die(mysqli_error());
                $num_row = mysqli_num_rows($result);
                $row=mysqli_fetch_array($result);
                if( $row >=1 ) { 
                        echo 'Already saved!'; //echoes this message if the sales code is already in use
                }else{
                        $query1 = "INSERT INTO directions (direction_id, Lat, Lng) VALUES ('$Vid', '$Vlat', '$Vlng')";
                        if(mysqli_query($this->_con, $query1) or die(mysqli_error($this->_con))){};
                        //inputs data if all requirements have been met
                        $query = "INSERT INTO venuetable (VName, v_id, v_address, vimage, user_id, direction_id) VALUES ('$Vname', '$Vid', '$Vaddress', '$Vimage', '$userId', '$Vid')";
                        if(mysqli_query($this->_con, $query) or die(mysqli_error($this->_con))){
                            echo 'Venue saved!';
                            echo mysqli_error($this->_con);
                            mysqli_close($this->_con);
                            return true;
                        };
                }
            }
        }
        //If no one is logged in
        else{
            echo 'Login';   
        }
    }
    
    
	/**
	 * this will handles user registration process
	 * @param array $data
	 * @return boolean true or false based success 
	 */
    public function registration( array $data )
	{
        if( !empty( $data ) ){
			// Trim all the incoming data:
			$trimmed_data = array_map('trim', $data);
			
			// escape variables for security
			$name = mysqli_real_escape_string( $this->_con, $trimmed_data['name'] );
			$password = mysqli_real_escape_string( $this->_con, $trimmed_data['password'] );
			$cpassword = mysqli_real_escape_string( $this->_con, $trimmed_data['confirm_password'] );
			
			// Check for an email address:
            $email = mysqli_real_escape_string( $this->_con, $trimmed_data['email']);
            $query = "SELECT * FROM users WHERE email='".$email."'"; 
            $result = mysqli_query($this->_con,$query)or die(mysqli_error());
            $num_row = mysqli_num_rows($result);
            $row=mysqli_fetch_array($result);
            if( $row >=1 ) { 
                echo 'This email is already registered!'; //echoes this message if the sales code is already in use
            }
            else if((!$name) || (!$email) || (!$password) || (!$cpassword) ) {
				echo 'Missing fields';
			}
            else if ($password !== $cpassword) {
				echo 'Passwords do not match';
			}else {
                $password = md5( $password );
                $query = "INSERT INTO users (name, email, password, created) VALUES ( '$name', '$email', '$password', CURRENT_TIMESTAMP)";
                if(mysqli_query($this->_con, $query)){
                    $query = "SELECT user_id, name, email, created FROM users where email = '$email' and password = '$password' ";
                    $result = mysqli_query($this->_con, $query);
                    $data = mysqli_fetch_assoc($result);
                    $count = mysqli_num_rows($result);
                    mysqli_close($this->_con);
                    if( $count == 1){
                        echo 'reg worked';
                        $_SESSION = $data;
                        $_SESSION['logged_in'] = true;
                        return true;
                    }
                }
                else{
                    throw new Exception( USER_REGISTRATION_FAIL );
                }
            }
        }
    }
    
	/**
	 * This method will handle user login process
	 * @param array $data
	 * @return boolean true or false based on success or failure
	 */
	public function login( array $data )
	{
        $_SESSION['logged_in'] = false;
		if( !empty( $data ) ){
			// Trim all the incoming data:
			$trimmed_data = array_map('trim', $data);
			
			// escape variables for security
			$email = mysqli_real_escape_string( $this->_con,  $trimmed_data['email'] );
			$password = mysqli_real_escape_string( $this->_con,  $trimmed_data['password'] );

			if((!$email) || (!$password) ) {
                echo 'Email or Password are missing';
            }else{
                $password = md5( $password );
                $query = "SELECT user_id, name, email, created FROM users where email = '$email' and password = '$password' ";
                $result = mysqli_query($this->_con, $query);
                $data = mysqli_fetch_assoc($result);
                $count = mysqli_num_rows($result);
                mysqli_close($this->_con);
                
                if( $count == 1){
                    $_SESSION = $data;
                    $_SESSION['logged_in'] = true;
                    echo 'Login Successful';
                    return true;
                }else{
                echo 'Email and Password are mismatch';
                }
            }
        }else{
            echo 'Email or Password are missing';
        }
    }
	
	/**
	 * This will shows account information and handles password change
	 * @param array $data
	 * @throws Exception
	 * @return boolean
	 */
	
	public function account( array $data )
	{
        if( !empty( $data ) ){
            // Trim all the incoming data:
            $trimmed_data = array_map('trim', $data);
			
			// escape variables for security
            $name = mysqli_real_escape_string( $this->_con, $trimmed_data['name'] );
            $email = mysqli_real_escape_string( $this->_con, $trimmed_data['email'] );
			$old_password = mysqli_real_escape_string( $this->_con, $trimmed_data['old_password'] );
            $new_password = mysqli_real_escape_string( $this->_con, $trimmed_data['new_password'] );
			$cpassword = $trimmed_data['confirm_password'];
			$user_id = mysqli_real_escape_string( $this->_con, $trimmed_data['user_id'] );
            
            $pass = "SELECT * FROM users WHERE user_id = $user_id";
            
            $results = mysqli_query($this->_con, $pass);
			$row = mysqli_fetch_assoc($results);          
            $dbpassword = $row['password'];
            
            if ((!$old_password)){
                echo 'Input current password';
            }
            else if(($dbpassword) !== (md5($old_password))){
                echo 'Current password does not match';
            }
            else if(($new_password)) {
                if ($new_password !== $cpassword) {
                    echo 'New password does not match';
                }
                else
                {
                    $password = md5( $new_password );
                    $pass_query = "UPDATE users SET name = '".$name."', email = '".$email."', password = '$password' WHERE user_id = $user_id";
                    if(mysqli_query($this->_con, $pass_query)){
                        mysqli_close($this->_con);
                        echo 'Password changed';
                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        return true;
                    }
                }
            }
            else{
                $query = "UPDATE users SET name = '".$name."', email = '".$email."' WHERE user_id = $user_id";
                if(mysqli_query($this->_con, $query)){
                    mysqli_close($this->_con);
                    echo 'Update Successful';
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    return true;
                }
            } 
        }
    }
	
    
	/**
	 * This handle sign out process
	 */
    //login function
	public function logout()
	{
        session_unset();
		session_destroy();
		header('Location: index.php');
	}
    
    public function delete(array $data)
    {
        $trimmed_data = array_map('trim', $data);
			
			// escape variables for security
        $user_id = mysqli_real_escape_string( $this->_con, $trimmed_data['user_id'] );
		$query = "DELETE FROM users WHERE user_id =  '$user_id'";
		if(mysqli_query($this->_con, $query)or die(mysqli_error())){
        echo 'Delete Successful';
        session_destroy();
        };
    }
    //Delete stored venue from account    
    public function delvenue(array $data)
    {
        $trimmed_data = array_map('trim', $data);
        // escape variables for security
        $dir_id = mysqli_real_escape_string( $this->_con, $trimmed_data['dir_id'] );
        $query = "DELETE FROM directions WHERE direction_id = '$dir_id'";
        if(mysqli_query($this->_con, $query)or die(mysqli_error())){
            echo ".$dir_id";
        };
    }
    
        
	//SESSION IS THEN DESTROYED AND TAKES USER STRAIGHT BACK TO THE LOGIN PAGE
		
	/**
	 * This reset the current password and send new password to mail
	 * @param array $data
	 * @throws Exception
	 * @return boolean
	 */
	public function forgetPassword( array $data )
	{
		if( !empty( $data ) ){
			
			// escape variables for security
			$email = mysqli_real_escape_string( $this->_con, trim( $data['email'] ) );
			
			if((!$email) ) {
				throw new Exception( FIELDS_MISSING );
			}
			$password = $this->randomPassword();
			$password1 = md5( $password );
			$query = "UPDATE users SET password = '$password1' WHERE email = $email";
			if(mysqli_query($this->_con, $query)){
				mysqli_close($this->_con);
				
				return true;
			}
		} else{
			throw new Exception( FIELDS_MISSING );
		}
	}
	
	/**
	 * This will generate random password
	 * @return string
	 */
	
	private function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
}

 
?>
<?php

include("functions.php");
	
	//_________Login/Signup Action________
	if( $_GET["action"]=="loginSignup" )
	{

		$error = "";
		if( !$_POST["email"] ){
			$error="Please Enter the Email";
		}
		else if( !$_POST["password"] ){
			$error="Please Enter the Password";
		}
		else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL )) {
    		$error="Please Enter a Valid Email";
		}
		
		if( $error!="" )
		{
			echo $error;
		}
		else
		{
			//_____ Sign Up _______
			if( $_POST["loginActive"]=="0" )
			{
				$email = $_POST["email"];
    			$password = $_POST["password"];
   				$query = "SELECT * FROM accounts WHERE 
    					email='".mysqli_real_escape_string($link,$email)."'";
    			$result = mysqli_query($link , $query);
    			if(mysqli_num_rows($result)>0)
   				{
        			$error.="Already Have an Account";
    			}
    			else
    			{
        			$query= "INSERT INTO accounts VALUES
        					(NULL,'".mysqli_real_escape_string($link,$email)."','"
            				.mysqli_real_escape_string($link,$password)."')";
        			if(!mysqli_query($link, $query))
        			{
            			$error.="Failed to Create Account..Please Try Again";
        			}
        			else
        			{
            			$query="UPDATE accounts SET 
            					password='".md5(md5($email).$password)."' WHERE 
            					email='".$email."'";
            			if(mysqli_query($link,$query)) 
            			{
							echo "1";
							$_SESSION['sid']=session_id() ;
                			$_SESSION['email']=$email;
            			}
            		}
        		}
			}
			//_____ Sign In _______
			else if( $_POST["loginActive"]=="1" )
			{
				$query="SELECT * FROM accounts WHERE email='".
        				mysqli_real_escape_string($link,$_POST['email'])."'";
				$result = mysqli_query($link,$query);

    			if(mysqli_num_rows($result)==1)
    			{
    				$row = mysqli_fetch_array($result);
        			$hashedPassword = md5(md5($_POST['email']).$_POST['password']);
        			if ($hashedPassword == $row['password'])
        			{
						echo "1";
						$_SESSION['sid']=session_id() ;
            			$_SESSION['email']=$_POST['email'];
    				}
    				else
    				{
    					$error.="Failed to Sign In";
    				}
    			}
    			else
    			{
    				$error.="No Such an Account Exist";
    			}
			}

			if( $error!="" )
			{	
				echo $error;
			}
		}
	}

	//_________Follow/Unfollow Action________
	if( $_GET["action"] == "toggleFollow" )
    {
        $query="SELECT * FROM isfollowing WHERE follower='".
            mysqli_real_escape_string($link,$_SESSION["email"])."' AND isFollowing='".
            mysqli_real_escape_string($link,$_POST["email"])."'";
        $result = mysqli_query($link,$query);
        if( mysqli_num_rows($result)>0 )// if already following then unfollow
        {
            $row = mysqli_fetch_array($result);
            $query2 ="DELETE FROM isfollowing WHERE id='".
                mysqli_real_escape_string($link,$row["id"])."' LIMIT 1";
            mysqli_query($link, $query2);
            echo "1";
        }
        else // follow if not following
        {
            $row = mysqli_fetch_array($result);
            $query2 ="INSERT INTO isfollowing 
                VALUES(NULL,'".mysqli_real_escape_string($link,$_SESSION["email"])
                ."','".mysqli_real_escape_string($link,$_POST["email"])."')";
            mysqli_query($link, $query2);
            echo "2";
        }
    }

	//_________Post a Tweet Action________
    if( $_GET["action"] == "postTweet" )
    {
        if( !$_POST["tweetContent"] )
        {
            echo "Your Tweet is empty";
        }
        else if ( strlen( $_POST["tweetContent"] ) > 140 )
        {
            echo "Your tweet is too long";
        }
        else
        {
           $query ="INSERT INTO tweets 
                VALUES(NULL,'".mysqli_real_escape_string($link,$_POST["tweetContent"])
                ."','".mysqli_real_escape_string($link,$_SESSION["email"])."',NOW())";
            if(mysqli_query($link, $query))
                echo "1";
            else
                echo "2";
        }
    }

?>
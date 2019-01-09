<?php
		session_start();
		
		$link = mysqli_connect("localhost","root","","switter_db");
    	
    	if(mysqli_connect_error())
    	{
        	die("Failed to Connect");
    	}

    	if(array_key_exists("function",$_GET) AND $_GET["function"]=="logout")
		{
    		session_unset();
		}

		function time_since($since) 
		{
   			$chunks = array(
        	array(60 * 60 * 24 * 365 , 'year'),
        	array(60 * 60 * 24 * 30 , 'month'),
        	array(60 * 60 * 24 * 7, 'week'),
	        array(60 * 60 * 24 , 'day'),
	        array(60 * 60 , 'hour'),
	        array(60 , 'minute'),
	        array(1 , 'second')
	    	);

	    	for ($i = 0, $j = count($chunks); $i < $j; $i++) 
	    	{
	        	$seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        	if (($count = floor($since / $seconds)) != 0)
	         	{
	            	break;
	        	}
    		}

    		$print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    		return $print;
		}



		function displayTweets($type)
		{
            global $link;
			if( $type == "public" )
			{
				$whereClause = "";
			}
			else if ( $type == "isFollowing"  )
            {

                $query="SELECT * FROM isfollowing WHERE follower='".
                    mysqli_real_escape_string($link,$_SESSION["email"])."'";
                $result = mysqli_query($link,$query);
                $whereClause="";
                while( $row = mysqli_fetch_array($result) )
                {
                    if( $whereClause == "" ){
                        $whereClause = "WHERE";
                    }
                    else{
                        $whereClause .= " OR";
                    }
                    $whereClause .= " email='".$row["isFollowing"]."'";
                }
                if($whereClause=="") {
                    echo "<br><h5>&nbsp;&nbsp;No Tweets  to Show</h5>";
                    exit();
                }
            }
            else if ($type == "mytweets" )
            {
                $whereClause = "WHERE email='"
                .mysqli_real_escape_string($link,$_SESSION["email"])."'";
            }
            else if ( $type == "search" )
            {
                $whereClause = "WHERE tweet LIKE '%"
                    .mysqli_real_escape_string($link,$_GET["query"])."%'";
            }

			
			$query = "SELECT * FROM tweets ".$whereClause.
			" ORDER BY 'datetime' DESC LIMIT 10";
			
			$result = mysqli_query($link, $query);
			
			if ( mysqli_num_rows($result) == 0 )
			{
                echo "<br><h5>&nbsp;&nbsp;No Tweets  to Show</h5>";
			}
			else
			{
				while( $row = mysqli_fetch_array($result) )
				{
					//$userQuery = "SELECT * FROM accounts WHERE email="
					//.mysqli_real_escape_string($link, $row["email"])." LIMIT 1";
			
					//$userResult = mysqli_query($link, $userQuery);
					//$user = mysqli_fetch_array($userResult);
					echo "<div class='tweet'><p>".$row["email"]."<span class='time'> "
					.time_since(time()-strtotime($row["datetime"]))."</p>";
					echo "<p>".$row["tweet"]."</p>";

					if ( array_key_exists('email',$_SESSION) AND $_SESSION['email'] ) {
                        echo "<a class='btn btn-success text-white toggleFollow' data-email='"
                            . $row["email"] . "'>";
                        $isFollowingQuery = "SELECT * FROM isfollowing WHERE follower='" .
                            mysqli_real_escape_string($link, $_SESSION["email"]) . "' AND isFollowing='" .
                            mysqli_real_escape_string($link, $row["email"]) . "'";
                        $isFollowingResult = mysqli_query($link, $isFollowingQuery);
                        if (mysqli_num_rows($isFollowingResult) > 0) {
                            echo "Unfollow";
                        } else {
                            echo "Follow";
                        }
                        echo "</a></div>";
                    }
                    else
                    {
                        echo '<button class="btn btn-success" type="button" data-toggle="modal"
                                data-target="#exampleModal">Follow</button></div>';
                    }
				}
			}
		}

		function displayTweetBox()
        {
            if ( array_key_exists('email',$_SESSION) AND $_SESSION['email'] )
            {
                echo '<div class="alert alert-success" style="display:none;" id="tweetSuccess" >
                Tweet Posted Successfully</div>
                <div class="alert alert-danger" style="display:none;" id="tweetFail" > 
                Failed to Post the Tweet</div>
                <form class="form"><div class="form-group">
                <textarea class="form-control" id="tweetContent" rows="3"></textarea>
                </div><button type="button" class="btn btn-outline-success my-2 my-sm-0" id="postTweetButton">
                Post Tweet</button></form>';
            }
        }

        function displaySearchBox()
        {
            echo "<form class=\"form-inline\">
                <div class=\"form-group\">
                <input type=\"hidden\" name=\"page\" value=\"search\" >
                <input class=\"form-control mr-sm-2\" name='query' type=\"search\" placeholder=\"Search\" aria-label=\"Search\">
                <button class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\">
                 Search Tweets</button></div> </form><br>";
        }

?>
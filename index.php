<?php

include("functions.php");
include("Views/header.php");

if( array_key_exists("page",$_GET) AND $_GET["page"] == "timeline"
    AND array_key_exists('email',$_SESSION) AND $_SESSION['email'] )
{
    include("Views/timeline.php");
}

else if ( array_key_exists("page",$_GET) AND $_GET["page"] == "mytweets"
    AND array_key_exists('email',$_SESSION) AND $_SESSION['email'] )
{
    include ("Views/mytweets.php");
}

else
{
    include("Views/home.php");
}
include("Views/footer.php");

?>
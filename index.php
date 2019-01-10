<?php

include("functions.php");
include("Views/header.php");

if( array_key_exists("page",$_GET) AND $_GET["page"] == "timeline"
    AND array_key_exists('sid',$_SESSION) AND $_SESSION['sid'] )
{
    include("Views/timeline.php");
}

else if ( array_key_exists("page",$_GET) AND $_GET["page"] == "mytweets"
    AND array_key_exists('sid',$_SESSION) AND $_SESSION['sid'] )
{
    include ("Views/mytweets.php");
}

else if(  array_key_exists("page",$_GET) AND $_GET["page"] == "search" )
{
    include ("Views/search.php");
}

else
{
    include("Views/home.php");
}
include("Views/footer.php");

?>
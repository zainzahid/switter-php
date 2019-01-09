<footer class="footer">
    <div class="container">
        <span class="text-muted">&copy; Zain Zahid 2018.</span>
    </div>
</footer>


<script src="Views/bootstrap/jquery-3.3.1.min.js" ></script>
<script src="Views/bootstrap/popper.min.js" ></script>
<script src="Views/bootstrap/bootstrap.min.js" ></script>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginTitle1">Logins</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         	<input type="hidden" name="loginActive" id="loginActive" value="1">
      		<img class="mb-4" src="http://www.stickpng.com/assets/images/580b57fcd9996e24bc43c53e.png" alt="" width="72" height="72">
     		<h1 class="h3 mb-3 font-weight-normal" id="loginTitle2">Please Sign In</h1>
          <div class="alert alert-danger" id="signInAlert" role="alert" style="display:none;" ></div>
      		<label for="inputEmail" class="sr-only">Email address</label>
      		<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      		<br>
      		<label for="inputPassword" class="sr-only">Password</label>
      		<input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
      		<br>
      </div>
      
      <div class="modal-footer">
      	<a id="toggleLogin" >Sign Up</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitBtn">Sign In</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	
  $("#toggleLogin").click(function(){
		
		if($("#loginActive").val()=="1"){
			$("#loginActive").val("0");
			$("#loginTitle1").html("Sign Up");
			$("#loginTitle2").html("Please Sign Up");
			$("#toggleLogin").html("Sign In");
			$("#submitBtn").html("Sign Up")
		}
		else{
			$("#loginActive").val("1");	
			$("#loginTitle1").html("Sign In");
			$("#loginTitle2").html("Please Sign In");
			$("#toggleLogin").html("Sign Up");
			$("#submitBtn").html("Sign In")
		}

	})

  $("#submitBtn").click(function(){
     $.ajax({
                  method: "POST",
                  url: "actions.php?action=loginSignup",
                  data: { email: $("#inputEmail").val(),
                          password:$("#inputPassword").val(),
                          loginActive:$("#loginActive").val() },
                  success: function(result)
                  {
                      if( result == "1" )
                      {
                        window.location.assign("index.php");
                      }
                      else
                      {
                        $("#signInAlert").html(result).show();
                      }
                  }
            })
  })

  $(".toggleFollow").click(function () {
      alert('cliked');
      $email = $(this).attr("data-email");
      $.ajax({
          method: "POST",
          url: "actions.php?action=toggleFollow",
          data: { email: $email},
          success: function(result)
          {
              if( result == "1" )
                  $("a[data-email='"+$email+"']").html("Follow");
              else if ( result == "2" )
                  $("a[data-email='"+$email+"']").html("Unfollow");
          }
      })
  })

  $("#postTweetButton").click(function () {
      $.ajax({
          method: "POST",
              url: "actions.php?action=postTweet",
              data: {tweetContent: $("#tweetContent").val()},
                success: function (result)
                {
                   if ( result == "1" ) {
                       $("#tweetSuccess").show();
                       $("#tweetFail").hide();
                   }
                   else if ( result == "2" ) {
                       $("#tweetFail").show();
                       $("#tweetSuccess").hide();
                   }
                   else {
                       $("#tweetFail").html(result).show();
                       $("#tweetSuccess").hide();
                   }
                }
      })
  })


</script>

</body>
</html>
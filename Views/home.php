<div class="container mainContainer">
	<div class="row">

  		<div class="col-md-8">
  			<h2 class="display-4">Public Tweets</h2>
  			<?php displayTweets('public'); ?>
  		</div>

  		<div class="col-md-4">

            <?php
            displaySearchBox();
            displayTweetBox(); ?>

  		</div>

	</div>
</div>
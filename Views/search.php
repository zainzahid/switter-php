<div class="container mainContainer">
    <div class="row">

        <div class="col-md-8">
            <h2 class="display-4">Search Result for
                "<?php echo $_GET["query"] ?>"</h2>

            <?php displayTweets("search"); ?>

        </div>

        <div class="col-md-4">

            <?php
            displaySearchBox();
            displayTweetBox(); ?>

        </div>

    </div>
</div>
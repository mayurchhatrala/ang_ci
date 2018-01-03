<?php $headerData = $this->headerlib->data(); ?>
<!doctype html>
<html lang="en-us">
    <head>
        <title><?= $title ?></title>
        <?= $headerData['meta_tags']; ?> 
        <link type="text/css" href="<?= BASEURL; ?>css/base.css" rel="stylesheet"/>
    </head>
    <body>
        <div id="loading">
            <div id="error404" class="other_pages">
                <div class="row-fluid container spacer fluid">
                    <div class="span1"></div>
                    <div class="span11">
                        <h2>Page Not Found</h2>
                            <h1>404 !!</h1>
                        <h3 class="bottom-line">The page which you're looking for is not available.</h3>
                        <div class="spacer fluid"></div>
                    </div>
                </div>
                <div class="row-fluid spacer fluid">
                    <div class="span4">
                        <a href="<?= BASEURL; ?>dashboard" class="btn btn-primary row-fluid">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
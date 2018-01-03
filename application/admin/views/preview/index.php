<!DOCTYPE html>
<html lang="en">

    <!-- META TAGS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- TITLE TAG -->
    <title><?= PROJ_TITLE; ?></title>

    <!-- STYLE-SHEET -->
    <link href="<?= DWNLD_DOC_URL; ?>dist/css/bootstrap.css" rel="stylesheet" />
    <link href="<?= DWNLD_DOC_URL; ?>assets/css/docs.css" rel="stylesheet" />

    <!-- FAVI-ICONS -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= DWNLD_DOC_URL; ?>assets/ico/apple.icns">
    <link rel="shortcut icon" href="<?= DWNLD_DOC_URL; ?>assets/ico/windows.ico">

    <style>*{font-family: calibri !important;}#back-to-top{position: fixed;bottom: 25px;right:25px;z-index: 9999;}.back-top{cursor: pointer;}</style>

</head>
<body>

    <a class="sr-only" href="#content">Skip navigation</a>

    <!-- HEADER -->
    <header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?= BASE_URL; ?>doc/preview" class="navbar-brand">Web Service Documentation</a>
            </div>
        </div>
    </header>

    <!-- PAGE LAYOUT -->
    <div class="bs-header" id="content">
        <div class="container">
            <h1><?= PROJ_TITLE; ?></h1>
        </div>
    </div>

    <div class="container bs-docs-container">
        <div id="back-to-top">
            <a class="back-top">
                <img src="<?= DWNLD_DOC_URL; ?>assets/img/top_button.png"/>
            </a>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="bs-sidebar hidden-print" role="complementary">
                    <ul class="nav bs-sidenav" style="max-height: 500px;  overflow-y: scroll;">

                        <?php
                        for ($i = 0; $i < count($data); $i++) {
                            $info = $data[$i]['info'];
                            $input = $data[$i]['input'];
                            $hasVal = str_replace(' ', '_', strtolower($info['title']));
                            ?>
                            <li>
                                <a href="#<?= $hasVal; ?>"><?= $info['title']; ?></a>
                                <ul class="nav">
                                    <li><a href="#<?= $hasVal; ?>type">Type</a></li>
                                    <?php if(count($input) > 0) { ?>
                                        <li><a href="#<?= $hasVal; ?>input">Input</a></li>
                                    <?php } ?>
                                    <li><a href="#<?= $hasVal; ?>output">Output</a></li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <div class="col-md-9" role="main" style="border-left: solid 1px #AAA;">
                <div class="bs-docs-section">
                    <div class="page-header" style="border: none;">
                        <?php
                        for ($i = 0; $i < count($data); $i++) {
                            $info = $data[$i]['info'];
                            $header = $data[$i]['header'];
                            $input = $data[$i]['input'];
                            $output = $data[$i]['output'];

                            $hasVal = str_replace(' ', '_', strtolower($info['title']));
                            ?>

                            <section style="border-bottom: solid 1px #AAA;">
                                <h1 id="<?= $hasVal; ?>"><?= $info['title']; ?></h1>
                                <div class="bs-callout bs-callout-info">
                                    <h4><?= $info['url']; ?></h4>
                                </div>
                                <div class="highlight boderleft">
                                    <h4 class="colorblue">Header Parameters</h4>
                                    <?php for ($h = 0; $h < count($header); $h++) { ?>
                                        <code class="colorblue"><?= $header[$h]['title']; ?></code>
                                    <?php } ?>
                                    <br><br>
                                    <p class = "colorred">*<?= $info['desc']; ?></p>
                                </div>
                                <div class="highlight boderleft">
                                    <h4 class="colorblue">Supported Formats</h4>
                                    <?php for ($k = 0; $k < count($info['format']); $k++) { ?>
                                        <code class="colorblue"><?= $info['format'][$k]['name']; ?></code>
                                    <?php } ?>
                                    <br><br>
                                </div>
                                <h3 id="<?= $hasVal; ?>type">Type</h3>
                                <div class="bs-callout bs-callout-info">
                                    <h4>Type : <code><?= strtoupper($info['type']); ?></code></h4>
                                </div>
                                <?php if(count($input) > 0) { ?>
                                    <h3 id="<?= $hasVal; ?>input">Input</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="textcenter" style="width:100px;">Name</th>
                                                    <th class="textcenter" style="width:50px;">Type</th>
                                                    <th class="textcenter" style="width:100px;">Default</th>
                                                    <th class="textcenter" style="width:50px;">Status</th>
                                                    <th class="textcenter">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($l = 0; $l < count($input); $l++) { ?>
                                                    <tr>
                                                        <td><?= $input[$l]['name']; ?></td>
                                                        <td><code><?= $input[$l]['type']; ?></code></td>
                                                        <td><?= $input[$l]['value']; ?></td>
                                                        <td><?= $input[$l]['require']; ?></td>
                                                        <td><?= $input[$l]['desc']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                                <h3 id="<?= $hasVal; ?>output">Output</h3>
                                <div class="highlight boderleft">
                                    <h4 class="colorblue">Success</h4>
                                    <pre><code class="html"><?= $output['success']; ?></code></pre>
                                </div>
                                <div class="highlight boderleft">
                                    <h4 class="colorblue">Fail</h4>
                                    <pre><code class="html"><?= $output['fail']; ?></code></pre>
                                </div>
                                <br>

                            </section>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REQUIRE SCRIPTS -->
    <script src="<?= DWNLD_DOC_URL; ?>assets/js/jquery.js"></script>
    <script src="<?= DWNLD_DOC_URL; ?>dist/js/bootstrap.js"></script>
    <script src="<?= DWNLD_DOC_URL; ?>assets/js/application.js"></script>
    <script>
        $(function () {
            $(window).scroll(function () {
                ($(this).scrollTop() > 100) ? $('#back-to-top').fadeIn() : $('#back-to-top').fadeOut();
            });
            // scroll body to 0px on click
            $('#back-to-top a').click(function () {
                $('body,html').animate({scrollTop: 0}, 800);
                return false;
            });
        });
    </script>
</body>

</html>
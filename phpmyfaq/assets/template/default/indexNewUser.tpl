<!doctype html>
<!--[if lt IE 7 ]> <html lang="{metaLanguage}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html lang="{metaLanguage}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="{metaLanguage}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="{metaLanguage}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{metaLanguage}" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>{title}</title>
    <base href="{baseHref}" />

    <meta name="description" content="{metaDescription}">
    <meta name="author" content="{metaPublisher}">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <meta name="application-name" content="phpMyFAQ {phpmyfaqversion}">
    <meta name="copyright" content="(c) 2001-2011 phpMyFAQ Team">
    <meta name="publisher" content="{metaPublisher}">
    <meta name="robots" content="INDEX, FOLLOW">
    <meta name="revisit-after" content="7 days">
    <meta name="MSSmartTagsPreventParsing" content="true">

    <!-- Share on Facebook -->
    <meta property="og:title" content="{title}" />
    <meta property="og:description" content="{metaDescription}" />
    <meta property="og:image" content="" />

    <link rel="stylesheet" href="assets/template/{tplSetName}/css/{stylesheet}.css?v=1">
    <link rel="stylesheet" media="handheld" href="assets/template/{tplSetName}/css/handheld.css?v=1">
    <link rel="stylesheet" media="print" href="assets/template/{tplSetName}/css/print.css?v=1">

    <script src="assets/js/libs/modernizr.min.js"></script>
    <script src="assets/js/libs/jquery.min.js"></script>
    <script src="assets/js/phpmyfaq.js"></script>

    <link rel="shortcut icon" href="assets/template/{tplSetName}/favicon.ico">
    <link rel="apple-touch-icon" href="assets/template/{tplSetName}/apple-touch-icon.png">

    <link rel="alternate" title="News RSS Feed" type="application/rss+xml" href="feed/news/rss.php">
    <link rel="alternate" title="TopTen RSS Feed" type="application/rss+xml" href="feed/topten/rss.php">
    <link rel="alternate" title="Latest FAQ Records RSS Feed" type="application/rss+xml" href="feed/latest/rss.php">
    <link rel="alternate" title="Open Questions RSS Feed" type="application/rss+xml" href="feed/openquestions/rss.php">
    <link rel="search" type="application/opensearchdescription+xml" title="{metaTitle}" href="{opensearch}">
</head>
<body dir="{dir}">

<!--[if lt IE 8 ]>
<div class="internet-explorer-error">
    Did you know that your Internet Explorer is out of date?<br/>
    Please use Internet Explorer 8+, Mozilla Firefox 4+, Google Chrome, Apple Safari 5+ or Opera 11+
</div>
 <![endif]-->

<header id="header">
    <h1>
        <a title="{header}" href="{faqHome}">{header}</a>
    </h1>
</header>

<nav>
    <ul>
        <li>{registerUser}</li>
        <li>{sendPassword}</li>
    </ul>
</nav>

<a id="top"></a>

<section id="main">
    <div class="container-fluid">
        <div class="row-fluid">
        {writeContent}
        </div>
    </div>
</section>

<footer>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <ul class="footer-menu">
                    <li>{showSitemap}</li>
                    <li>{msgContact}</li>
                    <li>{msgGlossary}</li>
                </ul>
            </div>
            <div class="span6">
                <form action="{writeLangAdress}" method="post" class="pull-right">
                {switchLanguages}
                    <input type="hidden" name="action" value="" />
                </form>
            </div>
        </div>
        <div class="row">
            <p class="copyright pull-right">
            {copyright}
            </p>
        </div>
    </div>
</footer>

{debugMessages}

</body>
</html>
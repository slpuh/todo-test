<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/gijgo.min.js" type="text/javascript"></script>
    <link href="/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <div class="header-logo">
                    <a href="/" class="logo">To.<span>Do</span></a>
                </div>
                <div class="header-nav">
                    <ul class="nav-list">
                        <?php if (!isset($_SESSION["user"])) : ?>
                            <li class="nav-item">
                                <a href="/user/login">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/register">Sign Up</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a href="/cabinet">Account</a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/logout">Logout</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div id="nav-button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </header>
        <?= $content ?>
    </div>
    <script src="/js/script.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/jquery.formstyler.min.js"></script>
</body>
</html>
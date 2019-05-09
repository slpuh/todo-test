<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="/css/main.css">
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
                        <li class="nav-item">
                            <a href="/user/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="/user/register">Registration</a>
                        </li>
                    </ul>                    
                </div>
            </div>
        </header>
                
            <?php include  __DIR__ . '/../' . $content; ?>        
       
    </div>
    <script src="js/main.js"></script>
    <script src="js/jquery.formstyler.min.js"></script>
</body>
</html>
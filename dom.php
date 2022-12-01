<?php
	ini_set("user_agent","Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0");
	include_once("./simplehtmldom_1_5/simple_html_dom.php");
	$message = "";
	if (isset($_POST["url"])) {
		$uri = $_POST["url"];
		
		// Check URL
		if( ! preg_match( "/^([a-z][a-z0-9+.-]*):(?:\\/\\/((?:(?=((?:[a-z0-9-._~!$&'()*+,;=:]|%[0-9A-F]{2})*))(\\3)@)?(?=(\\[[0-9A-F:.]{2,}\\]|(?:[a-z0-9-._~!$&'()*+,;=]|%[0-9A-F]{2})*))\\5(?::(?=(\\d*))\\6)?)(\\/(?=((?:[a-z0-9-._~!$&'()*+,;=:@\\/]|%[0-9A-F]{2})*))\\8)?|(\\/?(?!\\/)(?=((?:[a-z0-9-._~!$&'()*+,;=:@\\/]|%[0-9A-F]{2})*))\\10)?)(?:\\?(?=((?:[a-z0-9-._~!$&'()*+,;=:@\\/?]|%[0-9A-F]{2})*))\\11)?(?:#(?=((?:[a-z0-9-._~!$&'()*+,;=:@\\/?]|%[0-9A-F]{2})*))\\12)?$/i", $uri ) )
		{
		    $message = "Url is invalid. Please try another url.";
		}
		
		// Create DOM from URL or file
		$html = file_get_html($uri);
		
		$ret = $html->find('.cardGrid_o1rkka');
		echo '<pre>';
		print_r($ret);
		echo '</pre>';
		die();
		// Find Grid DIV
		foreach($html->find('div') as $element) {
			if ($element->class != null) {
				$class_css = $element->class;
				if (strpos($class_css,"cardGrid") !== FALSE) {
					var_dump($class_css);
					break;
				}
			}
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://getbootstrap.com/favicon.ico">

    <title>Check AirBNB</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="https://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    	
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/examples/starter-template/starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="https://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Check AirBNB</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
       		<h4 class="page-header">Get Data From AirBNB</h4>
            <form role="form" method="POST" action="">
                <div class="form-group float-label-control">
          			<?php if (!empty($message)) : ?>
					<div class="alert alert-danger">
						<strong>Message!</strong> <?php echo $message; ?>
					</div>
          			<?php endif; ?>
          			<div class="row">
	                    <div class="col-sm-1"><label for="">URL</label></div>
	                    <div class="col-sm-10"><input type="url" class="form-control" placeholder="Enter URL" name="url" /></div>
	          			<div class="col-sm-1"><input type="submit" class="btn btn-primary" value="Get Now" /></div>
          			</div>
                </div>
            </form>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
<style>
	body {
		padding-top: 50px;
	}
	.starter-template {
		padding: 40px 15px;
		text-align: left;
	}
</style>
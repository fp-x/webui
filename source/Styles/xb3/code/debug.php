<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<?php
	session_start();
	
	/* demo flag in session */
	if (!isset($_SESSION['_DEBUG'])) {
		$_DEBUG = file_exists('/var/ui_dev_debug');
		$_SESSION['_DEBUG'] = $_DEBUG;
	}
	else {
		$_DEBUG = $_SESSION['_DEBUG'];
	}
	// disable timeout when debug mode


?>


<head>
	<title>MAXX</title>

	<!--CSS-->
	<link rel="stylesheet" type="text/css" media="screen" href="./cmn/css/common-min.css?sid=<?php echo $_SESSION["sid"]; ?>" />
	<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="./cmn/css/ie6-min.css" />
	<![endif]-->
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="./cmn/css/ie7-min.css" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="print" href="./cmn/css/print.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="./cmn/css/lib/jquery.radioswitch.css" />

	<!--Character Encoding-->
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <script type="text/javascript" src="./cmn/js/lib/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="./cmn/js/lib/jquery-migrate-1.2.1.js"></script>
    <script type="text/javascript" src="./cmn/js/lib/jquery.validate.js"></script>
    <script type="text/javascript" src="./cmn/js/lib/jquery.alerts.js"></script>
	<script type="text/javascript" src="./cmn/js/lib/jquery.alerts.progress.js"></script>
	<script type="text/javascript" src="./cmn/js/lib/jquery.ciscoExt.js"></script>
	<script type="text/javascript" src="./cmn/js/lib/jquery.highContrastDetect.js"></script>
	<script type="text/javascript" src="./cmn/js/lib/jquery.radioswitch.js"></script>
	<script type="text/javascript" src="./cmn/js/lib/jquery.virtualDialog.js"></script>

	<script type="text/javascript" src="./cmn/js/utilityFunctions.js"></script>
    <script type="text/javascript" src="./cmn/js/comcast.js"></script>

	<style>
	#div-skip-to {
		position:relative; 
		left: 150px;
		top: -300px;
	}

	#div-skip-to a {
		position: absolute;
		top: 0;
	}

	#div-skip-to a:active, #div-skip-to a:focus {
		top: 300px;
		color: #0000FF;		
		/*background-color: #b3d4fc;*/
	}
	</style>	
</head>

<body>
    <!--Main Container - Centers Everything-->
	<div id="container">
		
		<!--Main Content-->
		<div id="main-content">




<!-- $Id: at_a_glance.dory.php 2943 2009-08-25 20:58:43Z slemoine $ -->


<div id="content">
	<h1>Gateway > Debug</h1>

	<div id="educational-tip">
		<ul>

		<li>Login: <?php echo $_SESSION['loginuser']; ?> </li>
		<li>Debug: <?php if ($_DEBUG) { echo "true"; } else { echo "false";} ?> </li>
		<li>/var/ui_dev_debug exists: <?php if (file_exists('/var/ui_dev_debug')) { echo "true"; } else { echo "false";} ?> </li>
		<li>/var/cosa_php_debug: <?php if (file_exists('/var/cosa_php_debug')) { echo "true"; } else { echo "false";} ?> </li>
		<li>/var/tmp/logs/cosa_php_ext.log exists: <?php if (file_exists('/var/tmp/logs/cosa_php_ext.log')) { echo "true"; } else { echo "false";} ?> </li>
		<li>cosa.so found: <?php if (function_exists('getStr')) { echo "true"; } else { echo "false";} ?> </li>
		<li>test: <?php if (function_exists('xxx_getStr')) { echo "true"; } else { echo "false";} ?> </li>

		<li>
		<?php 
		if(isset($_GET["p"])) {
			echo $_GET["p"]." found: ";
			if (function_exists('getStr')) { 
				echo getStr($_GET["p"]); // "?p=Device.DeviceInfo.SupportedDataModel.1.URL"
			} else {
				echo "N/A";
			}
		}
		?>
		</li>
		
		</ul>
		<pre><?php print_r(get_loaded_extensions()); ?></pre>
	</div>

</div><!-- end #content -->
<?php include('includes/footer.php'); ?>

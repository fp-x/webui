
	<div id="internet-usage" class="module form" style="width: 96%;">
		<div>
			<h2>Dev Diagnostics</h2>
			<?php
			include_once('includes/ccsp.php'); 

			function printRow($str) {
				static $odd = false;
				$odd = !$odd;
				$oddStr = $odd?"odd":"";

				echo "<div class=\"form-row $oddStr \"> <span class=\"readonlyLabel\">$str</span></div>";
			}
			function getFileExistsStr($f) {
				return $f." exists: ". (ccsp_fileExists($f)?"true":"false");
			}

			echo printRow("Debug: ". ($_DEBUG? "true":"false"));
			echo printRow(getFileExistsStr("ui_dev_debug"));
			echo printRow(getFileExistsStr("ui_dev_mode"));
			echo printRow(getFileExistsStr("cosa_php_debug"));
			echo printRow(getFileExistsStr("/var/tmp/logs/cosa_php_ext.log"));
			echo printRow("cosa extension loaded: ". (extension_loaded("cosa")?"true":"false"));
			echo printRow("ccsp ready: ". (ccsp_isReady()?"true":"false"));

			if(isset($_SESSION['loginuser'])) {
				echo printRow("Login: ". $_SESSION['loginuser']);
				if(isset($_GET["p"])) {
					// "?p=Device.DeviceInfo.SupportedDataModel.1.URL"
					echo printRow("Parameter test: ".$_GET["p"]."=".ccsp_getStr($_GET["p"]));
				}
				echo printRow("<pre>". shell_exec("ifconfig"). "</pre>");
				echo printRow("<pre>". json_encode(get_loaded_extensions(), JSON_PRETTY_PRINT). "</pre>");
				if(isset($_GET["reset_usage_map"])) {
					echo printRow("Resetting usage map");
					ccsp_resetUseMap();
				}
				echo printRow("<pre>". json_encode(ccsp_getUseMap(), JSON_PRETTY_PRINT). "</pre>");
			}
		?>

	</div>
	</div>

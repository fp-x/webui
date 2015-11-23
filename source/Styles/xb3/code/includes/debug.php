
<?php
include_once('includes/ccsp.php'); 
if(isset($_SESSION['loginuser'])) {
	?>
	<div id="internet-usage" class="module form"  style="width: 96%;">
		<h2 style="margin-bottom: -5px;">Network Devices</h2>
		<table class="data" summary="This table displays Online Devices connected">
		    <tr>
			<th style="background: #f85f01;" id="host-name" >Name</th>
			<th style="background: #f85f01;" id="mac-address" >MAC Address</th>
			<th style="background: #f85f01;" id="connection-type" >IP</th>
		    </tr>
		<?php

		$ifc = shell_exec("ifconfig");
		$ifcArray = explode("\n\n", $ifc);
		$i = 0;
		foreach ($ifcArray as $d) {
			$strs = explode(" ", $d);
			$deviceName = $strs[0];
			if($deviceName == "") continue;
			$length = count($strs);
			$mac = $addr = "";
			for ($j = 0; $j < $length; $j++) {
				if($strs[$j] == "HWaddr") {
					$mac = $strs[$j+1];
				}
				if($strs[$j] == "inet") {
					$addr = str_replace("addr:", "", $strs[$j+1]);
				}
			}

			if( $i%2 ) {$divClass="class='form-row '";}
			else {$divClass="class='form-row odd'";}
			echo "<tr $divClass>
				<td width='40%' class='readonlyLabel' headers='host-name'>$deviceName</td>
				<td width='' class='readonlyLabel' headers='mac-address'>$mac</td>
				<td width='' class='readonlyLabel' headers='connection-type'>$addr</td>
				</tr>
			";
			$i++;
		}
		?>
		</table>
		</div>
<?php
} // if(isset($_SESSION['loginuser'])) {
?>

	<div id="internet-usage" class="module form" style="width: 96%;">
		<div>
			<h2>Dev Diagnostics</h2>
			<?php

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
				if(isset($_GET["ifconfig"])) {
					echo printRow("<pre>". shell_exec("ifconfig"). "</pre>");
				}
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

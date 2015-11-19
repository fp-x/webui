<!--
 If not stated otherwise in this file or this component's Licenses.txt file the
 following copyright and licenses apply:

 Copyright 2015 RDK Management

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
-->
<?php
header("Content-Type: application/json");

if (isset($_POST['Bridge'])){
	$isBridgeModel=$_POST['isBridgeModel'];
	
	if($isBridgeModel=="Enabled"){
		ccsp_setStr("Device.X_CISCO_COM_DeviceControl.LanManagementEntry.1.LanMode","bridge-static",true);
	}else{
		ccsp_setStr("Device.X_CISCO_COM_DeviceControl.LanManagementEntry.1.LanMode","router",true);
	}
	
	//20140523
	//set LanManagementEntry_ApplySettings after change LanManagementEntry table
	ccsp_setStr("Device.X_CISCO_COM_DeviceControl.LanManagementEntry_ApplySettings", "true", true);
	
	$bridgeModel=ccsp_getStr("Device.X_CISCO_COM_DeviceControl.LanManagementEntry.1.LanMode");
	
	if($bridgeModel=="bridge-static"){
		echo json_encode("Enabled");
	}else{
		echo json_encode("Disabled");
	}
}

if (isset($_POST['IGMP'])){
	$IGMPEnable=($_POST['IGMPEnable']=="Enabled"?"true":"false");
	ccsp_setStr("Device.X_CISCO_COM_DeviceControl.IGMPSnoopingEnable",$IGMPEnable,true);
	$IGMPModel=(ccsp_getStr("Device.X_CISCO_COM_DeviceControl.IGMPSnoopingEnable")=="true"?"Enabled":"Disabled");
	echo json_encode($IGMPModel);
}
?>

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

$devBlockInfo = json_decode($_REQUEST['BlockInfo'], true);

if (array_key_exists('privateDevice', $devBlockInfo)) {
	
	$exist = false;
    $macAddr = $devBlockInfo['macAddr'];
    $idArr = explode(",", ccsp_getInstanceIds("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device."));

    foreach ($idArr as $key => $value) {
        if ( $macAddr == ccsp_getStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device.$value.MACAddress")){
            $exist = true;
            break;
        }
    }

    if(! $exist){

		ccsp_addTblObj("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device.");
		$IDs  = ccsp_getInstanceIds("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device.");
		$idArr = explode(",", $IDs);
		$instanceid = array_pop($idArr);

		ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device." .$instanceid. ".Type", "Block", false);
		ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device." .$instanceid. ".Description", $devBlockInfo['hostName'], false);
		ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device." .$instanceid. ".MACAddress", $devBlockInfo['macAddr'], false);
		ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.Device." .$instanceid. ".AlwaysBlock", "true", true);
	
	}

	/*
	* if managed device is disabled, enable it
	*/
    $enableFlag =  ccsp_getStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.Enable");
    if ( !strcasecmp($enableFlag, "false") ) {
    	ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.Enable", "true", true);
    }

   	//ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedDevices.AllowAll", "true", true);

}
else if (array_key_exists('xhsSSID', $devBlockInfo)) {

	$filter_enable = ccsp_getStr("Device.WiFi.AccessPoint.3.X_CISCO_COM_MACFilter.Enable");
	$filter_block  = ccsp_getStr("Device.WiFi.AccessPoint.3.X_CISCO_COM_MACFilter.FilterAsBlackList");

	// allow_all 	then add and change to deny
	// allow	then check if its there in list and remove
	if ("true" == $filter_enable && "true" != $filter_block) {
		//$filtering_mode	= "allow";
		$arrayIDs=explode(",",getInstanceIDs("Device.WiFi.AccessPoint.3.X_CISCO_COM_MacFilterTable."));
		foreach ($arrayIDs as $key=>$i) {
			if (strcasecmp($devBlockInfo['macAddr'], ccsp_getStr("Device.WiFi.AccessPoint.3.X_CISCO_COM_MacFilterTable.$i.MACAddress")) == 0) {
				ccsp_delTblObj("Device.WiFi.AccessPoint.3.X_CISCO_COM_MacFilterTable.$i.");
				break;
			}
		}
	}
	else {
		//$filtering_mode	= "allow_all" or "deny"
		//this is going to set add xhsSSID connected device to MAC filter list
		//wi-fi SSID 3 mapped to xhsSSID
		ccsp_setStr("Device.WiFi.AccessPoint.3.X_CISCO_COM_MACFilter.Enable", 'true', true);
		ccsp_setStr("Device.WiFi.AccessPoint.3.X_CISCO_COM_MACFilter.FilterAsBlackList", 'true', true);
	
		ccsp_addTblObj("Device.WiFi.AccessPoint.3.X_CISCO_COM_MacFilterTable.");
		$idArr = explode(",", ccsp_getInstanceIds("Device.WiFi.AccessPoint.3.X_CISCO_COM_MacFilterTable."));
		$id = array_pop($idArr);
	
		ccsp_setStr("Device.WiFi.AccessPoint.3.X_CISCO_COM_MacFilterTable.$id.DeviceName", $devBlockInfo['hostName'], false);
		ccsp_setStr("Device.WiFi.AccessPoint.3.X_CISCO_COM_MacFilterTable.$id.MACAddress", $devBlockInfo['macAddr'], true);
	}

}
else {
	//this is going to set add XfinitySSID connected device to MAC filter list
	//wi-fi ssie 5 and 6 mapped to XfinitySSID

	//for Wi-Fi SSID 5 mapped to XfinitySSID
	$filter_enable = ccsp_getStr("Device.WiFi.AccessPoint.5.X_CISCO_COM_MACFilter.Enable");
	$filter_block  = ccsp_getStr("Device.WiFi.AccessPoint.5.X_CISCO_COM_MACFilter.FilterAsBlackList");

	// allow_all 	then add and change to deny
	// allow	then check if its there in list and remove
	if ("true" == $filter_enable && "true" != $filter_block) {
		//$filtering_mode	= "allow";
		$arrayIDs=explode(",",getInstanceIDs("Device.WiFi.AccessPoint.5.X_CISCO_COM_MacFilterTable."));
		foreach ($arrayIDs as $key=>$i) {
			if (strcasecmp($devBlockInfo['macAddr'], ccsp_getStr("Device.WiFi.AccessPoint.5.X_CISCO_COM_MacFilterTable.$i.MACAddress")) == 0) {
				ccsp_delTblObj("Device.WiFi.AccessPoint.5.X_CISCO_COM_MacFilterTable.$i.");
				break;
			}
		}
	}
	else {
		//$filtering_mode	= "allow_all" or "deny"
		//this is going to set add xhsSSID connected device to MAC filter list
		//wi-fi SSID 3 mapped to xhsSSID
		ccsp_setStr("Device.WiFi.AccessPoint.5.X_CISCO_COM_MACFilter.Enable", 'true', true);
		ccsp_setStr("Device.WiFi.AccessPoint.5.X_CISCO_COM_MACFilter.FilterAsBlackList", 'true', true);
	
		ccsp_addTblObj("Device.WiFi.AccessPoint.5.X_CISCO_COM_MacFilterTable.");
		$idArr = explode(",", ccsp_getInstanceIds("Device.WiFi.AccessPoint.5.X_CISCO_COM_MacFilterTable."));
		$id = array_pop($idArr);
	
		ccsp_setStr("Device.WiFi.AccessPoint.5.X_CISCO_COM_MacFilterTable.$id.DeviceName", $devBlockInfo['hostName'], false);
		ccsp_setStr("Device.WiFi.AccessPoint.5.X_CISCO_COM_MacFilterTable.$id.MACAddress", $devBlockInfo['macAddr'], true);
	}

	//for Wi-Fi SSID 6 mapped to XfinitySSID
	$filter_enable = ccsp_getStr("Device.WiFi.AccessPoint.6.X_CISCO_COM_MACFilter.Enable");
	$filter_block  = ccsp_getStr("Device.WiFi.AccessPoint.6.X_CISCO_COM_MACFilter.FilterAsBlackList");

	// allow_all 	then add and change to deny
	// allow	then check if its there in list and remove
	if ("true" == $filter_enable && "true" != $filter_block) {
		//$filtering_mode	= "allow";
		$arrayIDs=explode(",",getInstanceIDs("Device.WiFi.AccessPoint.6.X_CISCO_COM_MacFilterTable."));
		foreach ($arrayIDs as $key=>$i) {
			if (strcasecmp($devBlockInfo['macAddr'], ccsp_getStr("Device.WiFi.AccessPoint.6.X_CISCO_COM_MacFilterTable.$i.MACAddress")) == 0) {
				ccsp_delTblObj("Device.WiFi.AccessPoint.6.X_CISCO_COM_MacFilterTable.$i.");
				break;
			}
		}
	}
	else {
		//$filtering_mode	= "allow_all" or "deny"
		//this is going to set add xhsSSID connected device to MAC filter list
		//wi-fi SSID 3 mapped to xhsSSID
		ccsp_setStr("Device.WiFi.AccessPoint.6.X_CISCO_COM_MACFilter.Enable", 'true', true);
		ccsp_setStr("Device.WiFi.AccessPoint.6.X_CISCO_COM_MACFilter.FilterAsBlackList", 'true', true);
	
		ccsp_addTblObj("Device.WiFi.AccessPoint.6.X_CISCO_COM_MacFilterTable.");
		$idArr = explode(",", ccsp_getInstanceIds("Device.WiFi.AccessPoint.6.X_CISCO_COM_MacFilterTable."));
		$id = array_pop($idArr);
	
		ccsp_setStr("Device.WiFi.AccessPoint.6.X_CISCO_COM_MacFilterTable.$id.DeviceName", $devBlockInfo['hostName'], false);
		ccsp_setStr("Device.WiFi.AccessPoint.6.X_CISCO_COM_MacFilterTable.$id.MACAddress", $devBlockInfo['macAddr'], true);
	}

	//For WECB
	ccsp_setStr("Device.MoCA.X_CISCO_COM_WiFi_Extender.X_CISCO_COM_SSID_Updated", "true", true);
}

?>

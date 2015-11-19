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
<?php include('../includes/utility.php'); ?>
<?php 

$flag = json_decode($_REQUEST['TrustFlag'], true);
//var_dump($flag);

if( $flag['trustFlag'] == "true" ){
    // "no" => "yes"
    //if device not in trusted user table, add this device to Trusted user table, set the trusted flag == true
    //if already exist, just set the trusted flag  == true
    
   /* $IDs  = ccsp_getInstanceIds("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.");
    $idArr = explode(",", $IDs);*/
    $deviceExist = false;

    $rootObjName    = "Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.";
    $paramNameArray = array("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.");
    $mapping_array  = array("IPAddress");
    $TrustedUserValues = getParaValues($rootObjName, $paramNameArray, $mapping_array, true);

    foreach ($TrustedUserValues as $key => $value) {
        if ($flag['IPAddress'] == $value["IPAddress"]) {
           $deviceExist = true;
           $id = $value["__id"];
           ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$id.Trusted", $flag['trustFlag'], true);
           break; 
        }
    }

    if (!$deviceExist)
    {
        ccsp_addTblObj("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser."); 
    
        $IDs  = ccsp_getInstanceIds("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.");
        $idArr = explode(",", $IDs);
        $instanceid = array_pop($idArr);

        ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$instanceid.HostDescription", $flag['HostName'], false);
        ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$instanceid.IPAddress", $flag['IPAddress'], false);
        if ( strpbrk($flag['IPAddress'], ':') != FALSE ){
            ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$instanceid.IPAddressType", "IPv6", false);
        }
        else{
            ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$instanceid.IPAddressType", "IPv4", false);
        }
        ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$instanceid.Trusted", $flag['trustFlag'], true);
    }
    
}
else{
    // "yes" => "no" not trusted
   /* $IDs  = ccsp_getInstanceIds("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.");
    $idArr = explode(",", $IDs);*/

    $rootObjName    = "Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.";
    $paramNameArray = array("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.");
    $mapping_array  = array("IPAddress");
    $TrustedUserValues = getParaValues($rootObjName, $paramNameArray, $mapping_array, true);

    foreach ($TrustedUserValues as $key => $value) {
        if ($flag['IPAddress'] == $value["IPAddress"]) {
           $index = $value["__id"];
           break; 
        }
    }

    ccsp_setStr("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$index.Trusted", 'false', true);
    //ccsp_delTblObj("Device.X_Comcast_com_ParentalControl.ManagedSites.TrustedUser.$index.");

}

?>

<?php 

$ip_config = json_decode($_REQUEST['configInfo'], true);

if(!array_key_exists('IPv6', $ip_config)){
    //set ipv4 part
	setStr("Device.X_CISCO_COM_DeviceControl.LanManagementEntry.1.LanIPAddress", $ip_config['Ipaddr'], false);
	setStr("Device.X_CISCO_COM_DeviceControl.LanManagementEntry.1.LanSubnetMask", $ip_config['Subnet_mask'], true);
	
	//20140523
	//set LanManagementEntry_ApplySettings after change LanManagementEntry table
	setStr("Device.X_CISCO_COM_DeviceControl.LanManagementEntry_ApplySettings", "true", true);
	
	setStr("Device.DHCPv4.Server.Pool.1.MinAddress", $ip_config['Dhcp_begin_addr'], false);
	setStr("Device.DHCPv4.Server.Pool.1.MaxAddress", $ip_config['Dhcp_end_addr'], false);
	setStr("Device.DHCPv4.Server.Pool.1.LeaseTime" , $ip_config['Dhcp_lease_time'], true);

}
else{
	//set ipv6 part
	$state = $ip_config['Stateful'];
	$restore = $ip_config['restore'];

	if ($state == 'true') {//stateful	
        getStr("Device.IP.Interface.1.IPv6Prefix.1."); //this line is a trick fix for Yan, may delete in future 
		setStr("Device.RouterAdvertisement.InterfaceSetting.1.AdvManagedFlag", "true", true);
		setStr("Device.DHCPv6.Server.X_CISCO_COM_Type", "Stateful", true);
		setStr("Device.DHCPv6.Server.Pool.1.PrefixRangeBegin", $ip_config['dhcpv6_begin_addr'], false);
		setStr("Device.DHCPv6.Server.Pool.1.PrefixRangeEnd", $ip_config['dhcpv6_end_addr'], false);
		setStr("Device.DHCPv6.Server.Pool.1.LeaseTime", $ip_config['dhcpv6_lease_time'], true);
	}
	else{//stateless
		setStr("Device.RouterAdvertisement.InterfaceSetting.1.AdvManagedFlag", "false", true);  

		setStr("Device.DHCPv6.Server.X_CISCO_COM_Type", "Stateless", true);
	}
	if ($restore == 'true'){
		getStr("Device.IP.Interface.1.IPv6Prefix.1."); //this line is a trick fix for Yan, may delete in future 
		setStr("Device.RouterAdvertisement.InterfaceSetting.1.AdvManagedFlag", "true", true);
		setStr("Device.DHCPv6.Server.X_CISCO_COM_Type", "Stateful", true);
		setStr("Device.DHCPv6.Server.Pool.1.PrefixRangeBegin", $ip_config['dhcpv6_begin_addr'], false);
		setStr("Device.DHCPv6.Server.Pool.1.PrefixRangeEnd", $ip_config['dhcpv6_end_addr'], false);
		setStr("Device.DHCPv6.Server.Pool.1.LeaseTime", $ip_config['dhcpv6_lease_time'], true);
	}
}

?>

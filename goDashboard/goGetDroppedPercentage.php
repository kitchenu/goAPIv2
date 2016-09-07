<?php
    ##############################################################
    #### Name: goGetDroppedPercentage.php            	      ####
    #### Description: API to get total drops Call percentage  ####
    #### Version: 0.9                              	      ####
    #### Copyright: GOAutoDial Inc. (c) 2011-2014  	      ####
    #### Written by: Jeremiah Sebastian V. Samatra 	      ####
    #### License: AGPLv2                           	      ####
    ##############################################################
    
    include_once("../goFunctions.php");
    
    $groupId = go_get_groupid($goUser);
    
    if (!checkIfTenant($groupId)) {
        $ul='';
    } else { 
        $stringv = go_getall_allowed_users($groupId);
        $stringv .= "'j'";
        $ul = " and campaign_id IN ($stringv) and user_level != 4";
    }

    $NOW = date("Y-m-d");
    
    $query = "SELECT concat(round((sum(drops_today)/sum(answers_today) * 100)),'') as getDroppedPercentage from vicidial_campaign_stats where calls_today > -1 and update_time BETWEEN '$NOW 00:00:00' AND '$NOW 23:59:59' $ul";
    $rsltv = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($rsltv);
    $apiresults = array("result" => "success", "data" => $data);
    
?>

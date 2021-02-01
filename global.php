<?php
    $globalvars = array();
    $globalvars["sitedata_filename"] = "sitedata.json";
    $globalvars["listname"] =  json_decode(file_get_contents($globalvars["sitedata_filename"]), true)["selected_list"];
    $globalvars["root_lists"] =  "lists/";
    $globalvars["std_listname"] =  $globalvars["root_lists"]."General.tdls";
?>
<?php

    include "filehandler.php";
    include "global.php";
    
    $sitedata_filename = $globalvars["sitedata_filename"];
    $listname = $globalvars["listname"];

    date_default_timezone_set('CET');

    function joinLinesToString($lines){
        $array_length = count($lines);
        $output = "";
        for($i = 0; $i < $array_length; $i++){
            $output .= $lines[$i]["content"];
        }
        return $output;
    }

    function incrementStateOfEntry($filehandler, $index){
        $lines = getLines($filehandler);

        switch($lines[$index]["content"][0]){
            case "T":
                $lines[$index]["content"][0] = "P";
            break;
            case "P":
                $lines[$index]["content"][0] = "D";
            break;
            case "D":
                unset($lines[$index]);
                $lines = array_values($lines);
            break;
            default:       
        }

        ftruncate($filehandler, 0);
        fseek($filehandler, 0, SEEK_SET);
        fwrite($filehandler, joinLinesToString($lines));
    }

    function manageNewEntry($entry, $filehandler, $importance){
        $output = strip_tags($entry);
        $output = "T".$output."  ".getImportanceHTML($importance).date("d.m.y")."\r\n";

        return $output;
    }
	
	function getImportanceHTML($importance){	
		if($importance == 50){
			//No specified importance of task
			return "";
		}
		
		if($importance >= 66){
			$div_text = "[important]";
			$div_color = "red";
		}
		else if($importance >= 33){
			$div_text = "[moderate]";
			$div_color = "orange";
		}
		else{
			$div_text = "[chill]";
			$div_color = "green";
		}
		
		$output = "<div style='background-color: var(--body_color); display: inline; width: 3rem; height: auto; color: ".$div_color."'>".$div_text."</div>";
		
		return $output;
	}

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["submit_entry"])){
            if($_GET["todo_input"] === ""){
                header("Location: /todo/index.php");
            }
            $file = fopen($listname, "a+");
            echo($_GET["todo_input"]);
            $entry_string = manageNewEntry($_GET["todo_input"], $file, $_GET["importance"]);
            fwrite($file, $entry_string);
            fclose($file);
        }

        else if(isset($_GET["submit_list"])){
            if($_GET["list_input"] == "" || $_GET["list_input"] == "&#92"){
                $filename = $globalvars["listname"];
            }

            else{
                $filename = $globalvars["root_lists"].$_GET["list_input"].".tdls";
            }
                        
            if(!file_exists($filename)){
                fclose(fopen(str_replace(" ", "_", $filename), "w"));
            }
        }
        
        else if(isset($_GET["button_selectlist"])){
            writeSelectedListInJSONFile($globalvars["root_lists"].$_GET["button_selectlist"].".tdls", $sitedata_filename);
        }

        else if(($entry_index = $_GET["button_shiftentry"])>=0){
            $file = fopen($listname, "r+");
            incrementStateOfEntry($file, $entry_index);
            fclose($file);
        }

        header("Location: /todo/index.php");
    }

    function writeSelectedListInJSONFile($filename, $json_filename){
        $fileobj = array("selected_list"=>$filename);
        $json_string = json_encode($fileobj);
        $file = fopen($json_filename, "w");
        fwrite($file, $json_string);
        fclose($file);
    }
?>

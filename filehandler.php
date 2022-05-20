<?php
    function getLines($filehandler){
        $lines = array();
        fseek($filehandler, -1, SEEK_END);
        $end = ftell($filehandler);
        fseek($filehandler, 0, SEEK_SET);
        $line = 0;

        for($i = 0; $i < $end; $i++){ 
            $current_char = fgetc($filehandler);
            $lines[$line]["content"] .= $current_char;
            $lines[$line]["index"] = $line;
            if($current_char === "\n"){
                $line++;
            }
        }
        return $lines;
    }

    function getEntriesArray($lines, $symbol){
        $entries_array = array();
        $lines_count = count($lines);

        for($i = 0; $i < $lines_count; $i++){
            if(strpos($lines[$i]["content"], $symbol) === 0)
                array_push($entries_array, $lines[$i]);
        }

        return $entries_array;
    }

    function getListsArray($dir){
        $lists = scandir($dir);
        array_splice($lists, 0, 2);
        $output = array();
        for($i = 0; $i < count($lists); $i++){           
            $output[$i] = array();
            $output[$i]["content"] = substr($lists[$i], 0, strpos($lists[$i], ".tdls"));
            $output[$i]["index"] = $i;
        }
        return $output;
    }
?>
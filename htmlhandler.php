<?php
    $mask_todo = array(
        "actionpage" => "actionpage_get.php",
        "container_class" => "todo_entry",
        "container_name" => "todo_entry_",
        "button_class" => "todo_entry_button",
        "button_name" => "button_shiftentry",
        "content_class" => "todo_entry_content",
        "content_name" => "todo_entry_content_",
        "button_text" => "START",
        "index" => 0,
        "content" => 0);


    $mask_progress = array(
        "actionpage" => "actionpage_get.php",
        "container_class" => "progress_entry",
        "container_name" => "progress_entry_",
        "button_class" => "progress_entry_button",
        "button_name" => "button_shiftentry",
        "content_class" => "progress_entry_content",
        "content_name" => "progress_entry_content_",
        "button_text" => "DONE",
        "index" => 0,
        "content" => 0);

    $mask_done = array(
        "actionpage" => "actionpage_get.php",
        "container_class" => "done_entry",
        "container_name" => "done_entry_",
        "button_class" => "done_entry_button",
        "button_name" => "button_shiftentry",
        "content_class" => "done_entry_content",
        "content_name" => "done_entry_content_",
        "button_text" => "DELETE",
        "index" => 0,
        "content" => 0);
    
    /*
    <!--    FORMAT
    <div class=todo_entry name=todo_entry_0>
    <form action=actionpage_get.php method='get'>
        <button class=todo_entry_button name=button_shiftentry value=0>-></button>
    </form>
    <div class=todo_entry_content name=todo_entry_content_0> TEST  18.10.20
    </div>
    */

    function formatEntry($entry){
        $output = "<div class='entry' name=".$entry["container_name"].$entry["index"].">
        <form action=".$entry["actionpage"]." method='get'>
            <button class=".$entry["button_class"]." name=".$entry["button_name"]." value=".$entry["index"].">".$entry["button_text"]."</button>
        </form>
        <div class='entry_content' name=".$entry["content_name"].$entry["index"]."> ".$entry["content"]."</div>
        </div>";

        return $output;
    }

    function echoEntriesInFormat($entries){
        $array_size = count($entries);
        for($i = 0; $i < $array_size; $i++){
            echo formatEntry($entries[$i]);
        }
    }

    function displayEntries($input, $mask){
        $entries = array();        
        $entries = castEntriesAfterArray($input, $mask);
        echoEntriesInFormat($entries);
    }

    function castEntriesAfterArray($input, $mask){
        $entries = array();
        for($i = 0; $i < count($input); $i++){
            $entries[$i] = $mask;
            $entries[$i]["index"] = $input[$i]["index"];
            $entries[$i]["content"] = substr($input[$i]["content"], 1);
        }
        return $entries;
    }

    function displayListOptions($input){
        $array_size = count($input);
        for($i = 0; $i < $array_size; $i++){
            echo formatListOption($input[$i]);
        }
    }

    function formatListOption($list){
        $list_underlines_replaced = str_replace("_", " ", $list["content"]);
        $output = "<button class='lists_button' name='button_selectlist' value=".$list["content"].">".$list_underlines_replaced."</button>";
        return $output;
    }

?>
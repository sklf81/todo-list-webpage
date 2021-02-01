<!-- 
    
    TODO

    -   Backgorund Color for the lists menu show how many TODOS and PROGRESSES are stored
        (red -> much to do, green -> almost nothing to do)




-->

<?php
            include "filehandler.php";
            include "htmlhandler.php";
            include "global.php";

            $sitedata_filename = $globalvars["sitedata_filename"];
            $filecontent = file_get_contents($sitedata_filename);

            $listname = $globalvars["listname"];
            $file = fopen($listname, "r");
            $entries = getLines($file);
            $entries_todo = getEntriesArray($entries, "T");
            $entries_progress = getEntriesArray($entries, "P");
            $entries_done = getEntriesArray($entries, "D");

            fclose($file);

            $lists = getListsArray($globalvars["root_lists"]);
?>



<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css"/>
        <link rel="icon" href="icon.png"/>
        <title>TODO</title>
    </head>
    <body>
        <div class="tab" name="todo_tab"><div class="tabtitle">Todo</div>
            <div class="tab_content">
                <?php
                    displayEntries($entries_todo, $mask_todo);
                ?>
            </div>
        </div>  
        <div class="tab" id="progress_tab"><div class="tabtitle">In Progress</div>
            <div class="tab_content">
                <?php
                    displayEntries($entries_progress, $mask_progress);
                ?>
            </div>
        </div>
        <div class="tab" id="progress_tab"><div class="tabtitle">Done</div>
            <div class="tab_content">
                <?php
                    displayEntries($entries_done, $mask_done);
                ?>
            </div>
        </div>
        <div class="selectlist" name="selectlist">
            <form action="actionpage_get.php" method="get">
                <input type="text" autocomplete="off" id="list_input" name="list_input" placeholder="Select List..."></input>
                <input type="submit" name="submit_list"></input>
                <div name="lists">
                    <?php
                        displayListOptions($lists);
                    ?>
                </div>
            </form>
        </div>
        <div class="newentry" name="newentry">
            <form action="actionpage_get.php" method="get">
                <input type="text" autocomplete="off" id="todo_input" name="todo_input" placeholder="New TODO ..."></input>
                <input type="submit" name="submit_entry"></input>
            </form>
        </div>
    </body>
</html>
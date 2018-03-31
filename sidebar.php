
<?php
        require 'content.php';
        function printChats() {
            global $arrayChats;
            if(isset($arrayChats)) {
                foreach($arrayChats as $value) {
                    echo $value;
                }
            }
            else echo "";           
        }

?>

<div class="col-3 d-none d-md-block h-100 p-0 m-0" style="background-color:white !important;">
<div class="flex-row flex-row" style="height:7vh">
    <div class="col-12 m-0 p-0" style="height:2vh"></div> <!-- margine -->
        <!-- Search form -->
        <div class="col-12 mb-2">
            <input class="form-control d-block d-flex" type="text" placeholder="Search" aria-label="Search">
         </div>
</div>

<div class="d-flex flex-row m-0 p-0" id="scrollbar" style="overflow-y:scroll; height:85vh;">
    <div class="col-12 d-none d-sm-block p-0 m-0"  style="background-color:white !important;">
        <?php printChats() ?>
    </div>
</div>
</div>
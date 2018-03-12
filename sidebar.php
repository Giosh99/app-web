
<?php
        require 'content.php';
        function printChats() {

            global $arrayChats;
            if(isset($arrayChats)) {
                foreach($arrayChats as $value) {
                    echo '<div class="col-4 p-0 ml-0 mr-auto mt-4">'.$value.'</div>';
                }
            }
            else echo "";           
        }

?>
<div class="col-3 d-none d-sm-block" id="scrollbar" style="background-color:white !important; overflow-y:scroll;">
        <?php printChats() ?>
</div>
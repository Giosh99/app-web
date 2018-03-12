
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
<style>
    #scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    #scrollbar::-webkit-scrollbar-thumb {
        background-color: black;
        border-radius: 20px; 
        height: 100px;
    }
    #scrollbar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        padding-bottom: 400px;
    }




input[type=range] {
  -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
  width: 100%; /* Specific width is required for Firefox. */
  background: transparent; /* Otherwise white in Chrome */
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
}

input[type=range]:focus {
  outline: none; /* Removes the blue border. You should probably do some kind of focus styling for accessibility reasons though. */
}

input[type=range]::-ms-track {
  width: 100%;
  cursor: pointer;

  /* Hides the slider so custom styles can be added */
  background: transparent; 
  border-color: transparent;
  color: transparent;
}

</style>
<?php
        include 'classes.php';
        $chats = new classes\chats();
        $chats->inizialiseChats();
        $n_chats = count($chats->arrayChats);
        function printChats() {
            $a = 0;
            global $chats;
            if(isset($chats->arrayChats)) {
                foreach($chats->arrayChats as $value) {
                    echo $value->singleMessageBox($a);
                    $a++;
                }
            }       
        }
        // it takes the id of the user chat
        if($_GET != null) {
            if($_GET['id'] != null) {
                echo $chats->arrayChats[$_GET['id']]->user->getUserId();
            }    
        }
?>
<?php

    function createChatContent($name) {
        return '<span>'.$name.'</span>';    
    } 

    $arrayChats = array(createChatContent("ciao"));
        for($x = 0; $x<20; $x++) {
            array_push($arrayChats, createChatContent("ciao"));
        }
?>
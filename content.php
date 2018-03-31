<?php

    class chat {
        public $name;
        public $img;
        public $messages;
        public function __construct($name, $img, $messages) {
           $this->name = createNameBox($name);
            $this->img = $img;
            $this->messages = $messages;
        }
    }
    function createNameBox($name) {
     return "<span>".$name."</span>";
    }

    function single_message_box($value, $id) { 
        return '<div class="col-12 p-0 m-0 mt-1 mb-1 message_box" id="message_box_id_'.$id.'">
        <div class="d-flex flex-row w-100 align-items-center" style="height:5vh">
            <div class="col-3"></div>
            <div class="col">'.$value.'</div>
        </div>
      </div>';}

      $arrayChats = Array();
        for($x = 0; $x<20; $x++) {
            $chat = new chat("Gio", "qualcosa", "lista messaggi");
            array_push($arrayChats, single_message_box($chat->name, $x));
        }
?>
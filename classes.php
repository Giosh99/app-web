<?php
class chat {
        public $name;
        public $img;
        public $messages;
        private $n = 0;
        public function __construct($name, $img) {
           $this->name = createNameBox($name);
            $this->img = $img;
            $this->n = 0;
            $this->message = array();
        }
        public function addChat($message) {
                $this->message[$this->n] = $message;
                $this->$n = $this->$n +1;
        }
}

class user {

}
?>
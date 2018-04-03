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

class user {

}
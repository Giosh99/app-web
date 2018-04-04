<?php
    namespace app;
    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;

    class chat implements MessageComponentInterface {
        protected $clients;

        public function __construct() {
            $this->clients = new SplObjectStorage();
        }

        public function onOpen(ConnectionInterface $conn) { // it is calles every time a connection in opened in the browser
            //here we store the connection
            $this->clients.attach($conn);
            echo '<strong>connection estabilished</strong>';
            
        }
        public function onClose(ConnectionInterface $conn) {
            
        }
        public function onMessage(ConnectionInterface $from, $mess) {
            
        }
       /* public function onError(ConnectionInterface $conn, /Exception $e) {
            
        }*/

    }
?>
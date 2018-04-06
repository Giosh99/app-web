<?php
set_time_limit(0);

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require_once '../vendor/autoload.php';


    class chat implements MessageComponentInterface {
        protected $clients;

        public function __construct() {
            $this->clients = new SplObjectStorage();
        }

        public function onOpen(ConnectionInterface $conn) { // it is calles every time a connection in opened in the browser
            //here we store the connection
            $this->clients->attach($conn);
            echo '<strong>connection estabilished</strong>';
            
        }
        public function onClose(ConnectionInterface $conn) {
            $this->clients->detach($conn);
        }
        public function onMessage(ConnectionInterface $from, $mss) {
                //send the message to all the other clients except the one who sent.
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send($msg);
                }
            }
            echo $mss;
        }
        public function onError(ConnectionInterface $conn, \Exception $e) {
            echo "An error has occurred: {$e->getMessage()}\n";
    
            $conn->close();
        }

    }

$server = IoServer::factory(
	new chat(),//new HttpServer(new WsServer(new chat())),
	8080
);
$server->run();
?>
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
        private $msg;
        public function __construct() {
            $this->clients = new SplObjectStorage();
        }

        public function onOpen(ConnectionInterface $conn) { // it is called every time a connection is opened in the browser
            //here we store the connection
            $this->clients->attach($conn);
            echo 'connection estabilished';
            
        }
        public function onClose(ConnectionInterface $conn) {
            $this->clients->detach($conn);
        }
        public function onMessage(ConnectionInterface $from, $msg) {
                $output = $msg;
                var_dump($output);
            foreach ($this->clients as $client) {
                $client->send($output);
            }
        }
        public function onError(ConnectionInterface $conn, \Exception $e) {
            echo "An error has occurred: {$e->getMessage()}\n";
            $conn->close();
        }

    }

$server = IoServer::factory(
    
    new HttpServer(new WsServer(new chat())),
	8080
);
$server->run();
?>
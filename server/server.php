<?php
include '../classes.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require_once '../vendor/autoload.php';

class server implements MessageComponentInterface {
    const ACTION_USER_CONNECTED = 'connect';
    const ACTION_MESSAGE_RECEIVED = 'message';
    const ACTION_IDENTIFIED_USER = 'to';
    const ACTION_CLOSE = 'close';

    protected $clients;
    public $database;

    public function __construct() {
        $this->clients = Array(); 
        $this->database = new classes\database();
    }
    public function onMessage(ConnectionInterface $conn, $message) {
        $message = json_decode($message,true);
        if($message['action'] != 'connect') {
            $client = $this->findClient($message['personal_id']);
        }
        echo $message['action'].'       ';
        switch($message['action']) {
            case self::ACTION_USER_CONNECTED:
                $this->clients[$message['personal_id']] = Array('connection'=>$conn, 'to' => "");

                echo 'connection estabilished';
                break;
            case self::ACTION_IDENTIFIED_USER:
                $this->clients[$message['personal_id']]["to"] = $message['to'];
                break;
            case self::ACTION_MESSAGE_RECEIVED:
                $this->sendMessageToClient($message['personal_id'],$message);
                break;
        }


    }

    public function sendMessageToClient($from, $message) {
        $to = $this->clients[$from]['to'];
        
        $receiver = $this->findClient($to);
        if(isset($receiver)) {
            $connectionTo = $receiver['connection'];
            $message = json_encode($message);
            $connectionTo->send($message);
            $message = json_decode($message, true);
        }
        $this->database->AddMessage($from,$to, $message);
    }
    public function findClient($id) {
        if(isset($this->clients[$id])) {
            return $this->clients[$id];
        }
        else {
            echo 'client doesnt exist';
        }
    }
    public function LoadMessages() {
        
    }


    public function onOpen(ConnectionInterface $conn) {
        
    }
    public function onClose(ConnectionInterface $conn) {
        foreach($this->clients as $client) {
            if($client['connection'] == $conn) {
                unset($client);
                echo "disconnected";
            }
        }
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {

    }

}
$server = IoServer::factory(
    
    new HttpServer(new WsServer(new server())),
    8080
);
$server->run();
?>
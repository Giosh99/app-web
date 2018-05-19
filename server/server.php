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
    public $chats;
    public function __construct() {
        $this->clients = Array(); 
        $this->database = new classes\database();
        $this->chats = Array();
    }

    public function onMessage(ConnectionInterface $conn, $message) {
        $message = json_decode($message,true);
        if($message['action'] != 'connect') {
            $client = $this->findClient($message['userId']);
        }
        switch($message['action']) {
            case self::ACTION_USER_CONNECTED:
                $this->clients[$message['userId']] = new classes\user(
                    $message['userId'],
                    $message['name'],
                    $message['mail'],
                    $message['img'],
                    $conn
                );
                // 
                echo  " ".$this->clients[$message['userId']]->getName().' estabilished a connection.... ';
                $buffer = $this->database->getChats((int)$message['userId']);
                $chats['chats'] = $buffer;
                $chats['type'] = 'chat';
                if($chats != null) {
                    $message = json_encode($chats);
                    var_dump($message);
                    $conn->send($message);
                }
                break;
            case self::ACTION_IDENTIFIED_USER:
                $this->clients[$message['userId']]->setSpeaker($message['to']);
                break;
            case self::ACTION_MESSAGE_RECEIVED:
                $this->sendMessageToClient($message);
                break;
        }
    }

    public function sendMessageToClient($message) {
        $from = $this->clients[$message['userId']];
        $to = $from->getSpeaker();
        $message = json_encode($message);
        $receiver = $this->findClient($to);
        if(isset($receiver)) {
            $connectionReceiver = $receiver->getConnection();
            $connectionReceiver->send($message);
        }
        $from->getConnection()->send($message);
        $this->database->AddMessage($message);
    }

    public function findClient($id) {
        if(isset($this->clients[$id])) {
            return $this->clients[$id];
        }
        else {
            echo 'client doesnt exist';
        }
    }

    public function LoadMessages($id) {
        
    }

    public function LoadChats($id) {

    }

    public function onOpen(ConnectionInterface $conn) {
        
    }

    public function onClose(ConnectionInterface $conn) {
        foreach($this->clients as $client) {
            if($client->getConnection() == $conn) {
                unset($client);
                echo 'disconnected \n';
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
<?php
namespace classes;
class chat {
        public $user;
        private $n;
        public function __construct($userId,$name,$surname, $mail, $img, $messages) {
                $this->user = new user($userId,$this->createNameBox($name),$surname,$mail, $img, $messages);
        }

        private function createNameBox($name) {
                return "<span>".$name."</span>";
        }
           
        public function singleMessageBox($id) { 
                return '<div class="col-12 p-0 m-0 mt-1 mb-1 message_box" id="'.$id.'">
                   <div class="d-flex flex-row w-100 align-items-center" style="height:5vh">
                       <div class="col-3"></div>
                       <div class="col">'.$this->user->getName().'</div>
                   </div>
                 </div>';
        }

        public function addChat($message) {
                $this->message[$this->n] = $message;
                $this->$n = $this->$n +1;
        }
}

class chats {
        private $username;
        private $servername;
        private $password;
        private $databasename;
        private $conn;
        public $arrayChats;

        public function __construct() {
            $this->arrayChats = Array();
        }


        public function inizialiseChats() {

                $chat1 = new chat("1","Giosuè", "Calgaro","nope","","first message");
                $chat2 = new chat("2","Giorgio", "Diprima","nope","","first message");
                array_push($this->arrayChats,$chat1);
                array_push($this->arrayChats,$chat2);
        }
    }

class user {
        private $userId;
        private $name;
        private $mail;
        private $img;
        private $connection;
        private $speaker;

        public function getUserId() {
                return $this->userId;
        }
        public function setUserId($id)  {
                $this->userId = $id;
        }
        public function getName() {
                return $this->name;
        }
        public function setName($name)  {
                $this->name = $name;
        }
        public function getMail() {
                return $this->mail;
        }
        public function setMail($mail)  {
                $this->mail = $mail;
        }
        public function getImg() {
                return $this->img;
        }
        public function setImg($img)  {
                $this->img = $img;
        }
        public function getConnection() {
                return $this->connection;
        }
        public function setConnection($conn) {
                $this->connection = $conn;
        }
        public function getSpeaker() {
                return $this->speaker;
        }
        public function setSpeaker($speaker) {
                $this->speaker = $speaker;
        }
        public function __construct($userId,$name,$mail, $img, $connection) {
                $this->setUserId($userId);
                $this->setName($name);
                $this->setMail($mail);
                $this->setImg($img);
                $this->setConnection($connection);
        }
}

class database {
        public $connection;

        private function connectToDatabase() {
                $localhost = 'localhost';
                $user = 'root';
                $password = '';
                $database = 'sail';
                $this->connection = new \mysqli($localhost, $user, $password, $database);
                if ($this->connection->connect_error) {
                        echo 'connection failed';
                        die("Connection failed: " . $connection->connect_error);
                }
        }

        public function AddMessage($message, $to) {

                $stm_add_message = $this->connection->prepare('INSERT INTO messages(Message, Direction, chatId ) values(?,?,?);');
                $messageDecoded = json_decode($message, true);
                
                $sender = (int)$messageDecoded['userId'];
                $receiver = (int)$to;
                $textMessage = (string)$messageDecoded['text'];
                $messageId = (int) $messageDecoded['id'];

                $chat = $this->getChatId($sender, $receiver);
                $chatId = (int)$chat['ID'];
                $date = date("l");

                $stm_add_message->bind_param("sii",$textMessage, $sender, $chatId);
                $stm_add_message->execute();
        }

        private function getChatId($from, $to) {
               // $stm_search_chat = $this->connection->prepare("SELECT ID FROM chat WHERE (Sender=? AND Receiver=?) OR (Sender=? AND Receiver=?)");
                $sender = (int)$from;
                $receiver = (int)$to;
                echo '  sender:'.$sender;
                echo '  receiver: '.$receiver;
                $query = "SELECT ID FROM chat WHERE (Sender='$sender' AND Receiver='$receiver') OR (Sender='$receiver' AND Receiver='$sender')";
               // echo $receiver." ".$sender;
                //$ReverseReceiver = $receiver;
                //$ReverseSender = $sender;
                //$stm_search_chat->bind_param("iiii",$sender,$receiver,$ReverseReceiver,$ReverseSender);
                //$result = $stm_search_chat->execute();
                $result = $this->connection->query($query);
                var_dump($result);
                if($result->num_rows > 0) {
                        return $result->fetch_assoc();
                }
                else {
                        echo "error in the select chat";
                }
        }

        public function getChats($userId) {
                $userId = (int)$userId;
                $chats = Array();
                $returningStatement = Array();
                $query = 'SELECT Sender,Receiver FROM chat WHERE (Sender='.$userId.' OR Receiver='.$userId.')';
                /*$stm_select_chats = $this->connection->prepare($query);
                $stm_select_chats->bind_param("ii",$userId, $userId);
                $result = $stm_select_chats->execute();*/
                $result = $this->connection->query($query);
                if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                                if($row['Sender'] == $userId) {
                                        array_push($chats, $row['Receiver']);
                                }
                                else {
                                        array_push($chats, $row['Sender']);
                                }
                        }
                        foreach($chats as $chat) {
                                $query = 'SELECT userId, user_name FROM users WHERE userId='.(int)$chat.'';
                                $result = $this->connection->query($query);
                                array_push($returningStatement, $result->fetch_assoc());
                        }
                        return $returningStatement;
                }
                else {
                        return;
                }
        }
        public function getMessages($client) {
                $messages = Array();
                /*$stm_take_messages = $this->connection->prepare('SELECT MessageID,Message,Direction FROM messages WHERE chatId=?;');*/
                $id = (int)$this->getChatId($client->getUserId(), $client->getSpeaker());
                echo $id;
                /*
                echo $id;
                $stm_take_messages->bind_param("i",$id);
                $result = $stm_take_messages->execute();*/
                $query = 'SELECT MessageID,Message,Direction FROM messages WHERE chatId='.$id.';';
                $result = $this->connection->query($query);
                if($result->num_rows>0) {
                        while($row = $result->fetch_assoc()) {
                                $msg = $this->trasformMessageToRightFormat($row, $client->getSpeaker());
                                array_push($messages, $msg);
                        }
                }
                return $messages;
        }
        private function trasformMessageToRightFormat($message, $to) {
                $msg = Array();
                $msg['userId'] = $message['Direction'];
                $msg['text'] = $message['Message'];
                $msg['to'] = $to;
                return $msg;
        }

        public function __construct() {
                $this->connectToDatabase();
        }
}
?>
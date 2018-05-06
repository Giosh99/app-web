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
            $this->username = 'root';
            $this->servername = 'localhost';
            $this->password = 'password';
            $this->databasename = 'sail';
        /*   $this->conn = \mysqli_connect($this->servername,$this->username,$this->password, $this->databasename);
            if(!$this->conn) {
                    echo 'fkg error';
                die();
            } */
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
        private $surname;
        private $mail;
        private $img;
        private $messages;

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

        public function getSurname() {
                return $this->surname;
        }
        public function setSurname($surname)  {
                $this->surname = $surname;
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
        public function getMessage($id) {
                return $this->messages[$id];
        }
        public function setMessage($message)  {
                array_push($this->messages, $message);
        }

        public function __construct($userId,$name,$surname, $mail, $img, $message) {
                $this->setUserId($userId);
                $this->setName($name);
                $this->setSurname($surname);
                $this->setMail($mail);
                $this->setImg($img);
                $this->messages = Array();
                $this->setMessage($message);
        }
}

class database {
        private $connection;
       // private $stm_add_message_into_message;
       // private $stm_add_message_into_message_references;
       // private $stm_load_messages;

        private function connectToDatabase() {
                $localhost = 'localhost';
                $user = 'root';
                $password = 'password';
                $database = 'sail';
                $this->connection = new \mysqli($localhost, $user, $password, $database);
                if ($this->getConnection()->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                }
        }
        public function getConnection() {
                return $this->connection;
        }
        private function setConnection($conn) {
                $this->connection = $conn;
        }
        public function AddMessage($message) {
              /*  $stm_add_message = $this->connection->prepare("INSERT INTO messages(message) values(?);");
                $stm_add_message->bind_param("s",$message);
                $stm_add_message_into_message_references = $this->connection->prepare("INSERT INTO message_references(Sender_UserID, Reciver_UserID, MessageID) values(?,?,?)");
                $stm_add_message_into_message_references->bind_param("iis", $sender, $receiver, $messageId);*/
                $messageDecoded = json_decode($message, true);
                $sender = (int)$messageDecoded['personal_id'];
                $receiver = (int)$messageDecoded['to'];
                $textMessage = (string)$messageDecoded['text'];
                $messageId = (int) $messageDecoded['id'];
              /*  $this->stm_add_message_into_message->execute();
                $this->stm_add_message_into_message_references->execute();*/
                $this->connection->query('INSERT INTO messages(Message) values("'.$textMessage.'")');
                $this->connection->query('INSERT INTO message_references(Sender_UserID, Reciver_UserID, MessageID) values('.$sender.','.$receiver.','.$messageId.')');
                $this->connection->query('INSERT INTO message_references(Sender_UserID, Reciver_UserID, MessageID) values('.$receiver.','.$sender.','.$messageId.')');
        }
        public function getMessages($user) {

        }
        private function prepareLoadMessagesQuery() {
                //load messages
        }
        public function __construct() {
                $this->connectToDatabase();
                $this->prepareLoadMessagesQuery();
        }
}
?>
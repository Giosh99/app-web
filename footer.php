<?php
include 'thisUserInformations.php';
?>
<html lang="en">
        <footer>
    </footer>

<script>
window.onload = function() {
    var x = <?php echo $n_chats ?>;
    var activatedChat = "";
    var receiver;
    for(var a = 0; a< x; a++) {

        document.getElementById(a).addEventListener("click",clicked_message_box,false);

        function clicked_message_box() {
            if(activatedChat != "") {
                document.getElementById(activatedChat).style.backgroundColor = "white";
            }
            document.getElementById(this.id).style.backgroundColor = "#009788";
            activatedChat = this.id;
            
            sendDestinationMessage(this.id);
    }
    }

    function sendDestinationMessage(id) {
        console.log(id);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                receiver = this.responseText;
                $message = {
                    personal_id: <?php echo $user->getUserId();?>,
                    action: 'to',
                    to: receiver,
                }
                wbSocket.send(JSON.stringify($message));
            }
        };
        xhttp.open("GET", 'sidebarLogic.php?id='+id+'', true);
        xhttp.send();
    }

    document.getElementById("send").addEventListener("click",sendMessage,false );

    function sendMessage() {
        ///TODO
        //i campi dell'oggetto json devono essere quelli presenti nella tabella messages.

        var message = document.getElementById("textarea").value;
        document.getElementById("textarea").value = "";
        var msg = {
            action: 'message',
            personal_id :<?php echo $user->getUserId();?>,
            user : "<?php echo $user->getName();?>",
            text: message,
            to: receiver,
        };
        wbSocket.send(JSON.stringify(msg));
    }



    // initialize the websocket
    var wbSocket = new WebSocket("ws://localhost:8080");
    // it's fired when the connection is estabilished
    wbSocket.onopen = function(event) {
        console.log("connection estabilished");
        $connectionMessage = {
            action: 'connect',
            personal_id: <?php echo $user->getUserId();?>,
        }
        wbSocket.send(JSON.stringify($connectionMessage));
    }
    //it's fired when a message arrives from server
    wbSocket.onmessage = function(event) {
        console.log(event.data);
        var msg = JSON.parse(event.data);
        var message_list = message_list + msg.text;
        document.getElementById("msg").innerHTML = message_list + "/////" + msg.text;
    }
    wbSocket.onerror = function() {
        wbSocket.close();
    }
};

</script>
</html>

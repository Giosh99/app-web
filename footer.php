<?php
include 'thisUserInformations.php';
?>
<html lang="en">

<script>
window.onload = function() {
    // x is the number of chats in the database;
    let x = <?php echo $n_chats ?>;
    // 
    let activatedChat = "";
    let receiver;
    let viewChanged = false;

    if(activatedChat == "") {
        loadViewForUnclickedChat();
    }

    function loadViewForUnclickedChat() {
        // display none on the normal view
        document.getElementById("view").style.display = "none";
        parent = document.getElementById("content-part");

        let column = document.createElement("div");
        column.className += "col-9 align-self-end h-100 w-100 p-0";
        column.setAttribute("id", "firstLoadView")
        let row = document.createElement("div");
        row.className += "flex-row d-flex w-100 h-100 justify-content-center align-items-center";
        let node = document.createElement("div");
        node.className += "col text-center";
        let textNode = document.createTextNode("Please select a chat to start messaging");
        node.appendChild(textNode);
        node.style.color = "rgb(179, 179, 203)";
        row.appendChild(node);
        column.appendChild(row);
        column.style.backgroundColor = "white";
        parent.appendChild(column);
    }

    /*-----------------Add event listener for all the chats appeard in the database-----------*/

        //document.getElementById(a).addEventListener("click",clicked_message_box,false);

    function clicked_message_box() {
        if(activatedChat != "") {
            document.getElementById(activatedChat).style.backgroundColor = "white";
        }
        document.getElementById(this.id).style.backgroundColor = "#009788";
        activatedChat = this.id;
            //change view
        if(viewChanged != true) {
            loadViewForClickedChat();
        }
        sendDestinationMessage(this.id);
    }

    function loadViewForClickedChat() {
        parent = document.getElementById("content-part");
        child = document.getElementById("firstLoadView");
        parent.removeChild(child);
        document.getElementById("view").style.display = "block"
        viewChanged = true;
    }

    function sendDestinationMessage(id) {
        console.log(id);
        $message = {
            userId: <?php echo $user->getUserId();?>,
            action: 'to',
            to: id,
        }
        wbSocket.send(JSON.stringify($message));
    }

    document.getElementById("send").addEventListener("click",sendMessage,false );

    function sendMessage() {
        ///TODO
        //i campi dell'oggetto json devono essere quelli presenti nella tabella messages.
        let message = document.getElementById("textarea").value;
        document.getElementById("textarea").value = "";
        let msg = {
            action: 'message',
            userId: <?php echo $user->getUserId();?>,
            text: message,
            to: receiver,
            id: 1,
        };
        console.log(<?php echo $user->getUserId() ?>);
        wbSocket.send(JSON.stringify(msg));
    }



    // initialize the websocket
    var wbSocket = new WebSocket("ws://localhost:8080");
    // it's fired when the connection is estabilished
    wbSocket.onopen = function(event) {
        console.log("connection estabilished");
        $connectionMessage = {
            action: 'connect',
            userId: <?php echo $user->getUserId();?>,
            name: "<?php echo $user->getName(); ?>",
            mail: "<?php echo $user->getMail();?>",
            img: "<?php echo $user->getImg();?>",
        }
        wbSocket.send(JSON.stringify($connectionMessage));
    }
    //formatting the message with some classes and css
    function createRowForMessageSent(text) {
        let row = document.createElement("div");
        row.className += "flex-row d-flex ml-6";
        let col = document.createElement("div");
        col.className += "offset-4 col-6";
        let subRow = document.createElement("div");
        subRow.className+= "flex-row d-flex mt-2";
        let chat = document.createElement("div");
        chat.className += "chat self col-12";
        let userFoto = document.createElement("div");
        userFoto.className += "user-photo";
        let chatMessage = document.createElement("p");
        chatMessage.className += "chat-message wrap";
        let textNode = document.createTextNode(text);
        // append elements
        chatMessage.appendChild(textNode);
        chat.appendChild(chatMessage);
        chat.appendChild(userFoto);
        subRow.appendChild(chat);
        col.appendChild(subRow);
        row.appendChild(col);
        return row;
    }

    function createRowForMessageReceived(text) {
        let row = document.createElement("div");
        row.className += "flex-row d-flex mr-6";
        let col = document.createElement("div");
        col.className += "col-6 offset-4";
        let subRow = document.createElement("div");
        subRow.className+= "flex-row d-flex mt-2";
        let chat = document.createElement("div");
        chat.className += "chat friend col-12";
        let userFoto = document.createElement("div");
        userFoto.className += "user-photo";
        let chatMessage = document.createElement("p");
        chatMessage.className +="chat-message wrap";
        let textNode = document.createTextNode(text);
        // append elements
        chatMessage.appendChild(textNode);
        chat.appendChild(userFoto);
        chat.appendChild(chatMessage);
        subRow.appendChild(chat);
        col.appendChild(subRow);
        row.appendChild(col);
        return row;
    }

    function createRowForOpenedChat(name) {
        let rowMessageBox = document.createElement("div");
        rowMessageBox.className += "col-12 p-0 m-0 mt-1 mb-1 message_box";
        let internalRow = document.createElement("div");
        internalRow.className += "d-flex flex-row w-100 align-items-center";
        internalRow.style.height = "5vh";
        let imgSpace = document.createElement("div");
        imgSpace.className += "col-3";
        let usernameBox = document.createElement("div");
        usernameBox.className += "col";
        let username = document.createTextNode(name);
        // append chil
        usernameBox.appendChild(username);
        internalRow.appendChild(usernameBox);
        internalRow.appendChild(imgSpace);
        rowMessageBox.appendChild(internalRow);
        return rowMessageBox;
    }

    //it's fired when a message arrives from server
    wbSocket.onmessage = function(event) {
        console.log(event.data);
        let msg = JSON.parse(event.data);
        if(msg.type = 'chat') {
            let parent = document.getElementById("sidebar");
            for(i=0; i< msg['chats'].length; i++) {
                let element = createRowForOpenedChat(msg['chats'][i].user_name);
                element.setAttribute("id",msg['chats'][i].userId);
                element.addEventListener("click",clicked_message_box,false);
                parent.appendChild(element);
            }
        }
        else {
            if(msg.userId == <?php echo $user->getUserId();?>) {
            row = createRowForMessageSent(msg.text);
        }
        else {
            row = createRowForMessageReceived();
        }
        document.getElementById("msg").appendChild(row);
        }
    }
    wbSocket.onerror = function() {
        wbSocket.close();
    }
};

</script>
</html>

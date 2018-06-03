<?php
include 'classes.php';
use classes\user;

$userId = 2;
$name = "Giosue";
$surname = 'Calgaro';
$mail = '....';
$img = '';
$connection = " ";
$user = new classes\user($userId,$name,$mail, $img, $connection);

?>
<script src="classes.js"></script>
<script>
window.onload = function() {

    let activatedChat = "";
    let receiver;
    let viewChanged = false;
    let chatList;
    let notifications = [];

    if(activatedChat == "") {
        loadViewForUnclickedChat();
    }

    function loadViewForUnclickedChat() {
        // display none on the normal view
        document.getElementById("view").style.display = "none";
        parent = document.getElementById("content-part");

        let column = document.createElement("div");
        column.className += "col-9 align-self-end h-100 w-100 p-0";
        column.setAttribute("id", "firstLoadView");
        let row = document.createElement("div");
        row.className += "flex-row d-flex w-100 h-100 justify-content-center align-items-center";
        let node = document.createElement("div");
        node.className += "col text-center";
        let textNode = document.createTextNode("Please select a chat to start messaging");
        node.appendChild(textNode);
        node.style.color = "#999";
        node.classList.add("noselect");
        row.appendChild(node);
        column.appendChild(row);
        column.style.backgroundColor = "white";
        parent.appendChild(column);
    }

    /*-----------------Add event listener for all the chats appeard in the database-----------*/

    function clicked_message_box() {
        if(activatedChat != "") {
            document.getElementById(activatedChat).classList.remove("message_box_clicked");
            document.getElementById(activatedChat).classList.add("message_box");
        }
        document.getElementById(this.id).classList.remove("message_box");
        document.getElementById(this.id).classList.add("message_box_clicked");
        if(document.getElementById("notification-"+this.id).classList.contains("notification")) {
            document.getElementById("notification-"+this.id).classList.remove("notification");
        }
        activatedChat = this.id;
            //change view
        if(viewChanged != true) {
            loadViewForClickedChat();
        }
        // mando le info della nuova chat
        sendDestinationMessage(this.id);
        // tolgo i messaggi della chat precedente
        var myNode = document.getElementById("msg");
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }
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
        if (!message.replace(/\s/g, '').length) {
            // string only contained whitespace (ie. spaces, tabs or line breaks)
            return;
        }
        document.getElementById("textarea").value = "";
        let msg = {
            action: 'message',
            userId: <?php echo $user->getUserId();?>,
            text: message,
            to: activatedChat,
            type: 'message',
            load: 'client',
        };
        console.log(<?php echo $user->getUserId() ?>);
        wbSocket.send(JSON.stringify(msg));
    }

    // initialize the websocket
    var wbSocket = new WebSocket("ws://localhost:8080");
    // it's fired when the connection is estabilished
    wbSocket.onopen = function(event) {
        console.log("connection estabilished");
        connectionMessage = {
            action: 'connect',
            userId: <?php echo $user->getUserId();?>,
            name: "<?php echo $user->getName(); ?>",
            mail: "<?php echo $user->getMail();?>",
            img: "<?php echo $user->getImg();?>",
        }
        wbSocket.send(JSON.stringify(connectionMessage));
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
        userFoto.className += "user-photo-desktop";
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
        userFoto.className += "user-photo-desktop";
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

    function createRowForChat(e) {
        let rowMessageBox = document.createElement("div");
        rowMessageBox.className += "col-12 p-0 m-0 mt-1 mb-1 message_box chat-box";
        let internalRow = document.createElement("div");
        internalRow.className += "d-flex flex-row w-100 align-items-center";
        internalRow.style.height = "5vh";
        let imgSpace = document.createElement("div");
        imgSpace.className += "col-3 justify-self-center align-self-center";
        let img = document.createElement("div");
        img.className += "user-photo-chat-desktop";
        let usernameBox = document.createElement("div");
        usernameBox.className += "col-7";
        let notificationBox = document.createElement("div");
        notificationBox.className+="col";
        notificationBox.setAttribute("id", "notification-"+e.userId);
        let username = document.createTextNode(e.user_name);
        // append chil
        usernameBox.appendChild(username);
        imgSpace.appendChild(img);
        internalRow.appendChild(imgSpace);
        internalRow.appendChild(usernameBox);
        internalRow.appendChild(notificationBox);
        rowMessageBox.appendChild(internalRow);
        return rowMessageBox;
    }

    function rowErrorSearchChat() {
        let rowMessageBox = document.createElement("div");
        rowMessageBox.className += "col-12 p-0 m-0 mt-1 mb-1";
        let internalRow = document.createElement("div");
        internalRow.className += "d-flex flex-row w-100 align-items-center";
        internalRow.style.height = "5vh";
        let usernameBox = document.createElement("div");
        usernameBox.className += "col";
        let username = document.createTextNode("There are no chats");
        usernameBox.style.color = "#999";
        usernameBox.classList.add("noselect");
        // append chil
        usernameBox.appendChild(username);
        internalRow.appendChild(usernameBox);
        rowMessageBox.appendChild(internalRow);
        return rowMessageBox;
    }

    function addChatsToSidebar(array) {
        // eseguo un foreach per prendermi tutte le chat
        let parent = document.getElementById("sidebar");
        array.forEach(function(e) {
            let element = createRowForChat(e);
            element.setAttribute("id",e.userId);
            element.addEventListener("click",clicked_message_box,false);
            parent.appendChild(element);
        }); 
    }

    //it's fired when a message arrives from server
    wbSocket.onmessage = function(event) {
        console.log(event.data);
        let msg = JSON.parse(event.data);
        console.log(msg);
        if(msg.type == 'chat') {
            console.log(" chat  arrived   ");
            console.log(msg['chats']);
            // salvo in una variabile globale tutte le chat in modo 
            // da accederci durante la ricerca delle chat
            chatList = msg['chats'];
            // aggiungo le chat alla sidebar
            addChatsToSidebar(msg['chats']);

        }
        else {
                let speaker
                if(msg.userId == <?php echo $user->getUserId();?>) {
                    row = createRowForMessageSent(msg.text);
                    speaker = msg.to;
                }
                else if(activatedChat == msg.userId) {
                    row = createRowForMessageReceived(msg.text);
                    speaker = msg.userId;
                }
                else {
                    document.getElementById("notification-"+msg.userId).classList.add("notification");
                }
                document.getElementById("msg").appendChild(row);
                if(msg.load == 'client') {
                    let chatNode = document.getElementById(speaker);
                    let parent = document.getElementById("sidebar");
                    parent.prepend(chatNode);
                }
        }
    }
    wbSocket.onerror = function() {
        wbSocket.close();
    }

//----------------------------------- search for a chat ---------------------------------
    searchbar = document.getElementById("searchbar");
    searchbar.addEventListener("keyup", searchForChat, false);

    function searchForChat() {
        let chats = [];
        let val = this.value;
        let lenghtVal = val.length;
        let buffer = [];
        let node = document.getElementById("sidebar");
        // uso la selector con le classi perchè più precisa, 
        // dato che era già capitato che childNodes prendesse
        // nodi con id undefined, opto per questa scelta
        let nodes = node.querySelectorAll(".chat-box");
        e = document.getElementById("error");
        if(e != null) {
            node.removeChild(e);
        }
        /////////////////////initialise buffer/////////////////////////////////////////
        for(var q = 0; q<chatList.length; q++) {
            buffer[q] = false;
        }
        /////////////////////////////////////////////////////////////

        for(let a = 0; a < chatList.length; a++) {
            let char = chatList[a].user_name.substr(0, lenghtVal);
            if(char == "" || val == "" || val == null || val == " ") {
                while (node.firstChild) {
                    node.removeChild(node.firstChild);
                }
                addChatsToSidebar(chatList);
                if(activatedChat != "") {
                    for(var r = 0; r<chatList.length; r++) {
                        if(chatList[r].userId == activatedChat) {
                            document.getElementById(activatedChat).classList.remove("message_box");
                            document.getElementById(activatedChat).classList.add("message_box_clicked");
                        }
                    }
                }
                return;
            }
            else if(val == char) {
                chats.push(chatList[a].userId);
            }
        }
        //////////////////////////////////
        for(var x = 0; x<chats.length; x++) {
            console.log(chats[x]);
        }
        ///////////////////////////////////
        if(chats=="") {
            let error = rowErrorSearchChat();
            while (node.firstChild) {
                node.removeChild(node.firstChild);
            }
            error.setAttribute("id", "error")
            node.append(error);
            if(this.value == "" || this.value == null) {
                node.removeChild(node.firstChild);
                addChatsToSidebar(chatList);        
            }
        }
        else {
            for(var a = 0; a < chats.length; a++) {
                for(var i = 0; i< nodes.length; i++) {
                    if(chats[a] == nodes[i].id) {  
                        buffer[i] = true;
                        continue;
                    }
                    else {
                        if(buffer[i] == true) {
                            continue;
                        }
                        else {
                            buffer[i] = false;
                        }
                    }
                    }
            }
            for(var z = 0; z<buffer.length; z++) {
                if(buffer[z] == false && nodes[z] != null) {
                    document.getElementById("sidebar").removeChild(nodes[z]);
                    buffer[z] = "";
                }
            }

            for(z = 0; z<chats.length; z++) {
                b = document.getElementById(chats[z]);
                if(b==null) {
                    for(var t = 0; t<chatList.length; t++) {
                        if(chatList[t].userId == chats[z]) {
                            let param = [chatList[t]];
                            addChatsToSidebar(param);
                            // se una chat era attiva e poi è stata tolta dal dom, quando riappare deve 
                            // tornare allo stato di prima.
                            if(chats[z] == activatedChat) {
                            document.getElementById(activatedChat).classList.remove("message_box");
                            document.getElementById(activatedChat).classList.add("message_box_clicked");
                        }
                    }
                    }
                }
            }

        }
    }
    //////////////////////////notification///////////////////////////////////
    function createNotification(n) {
        let notBox = document.createElement("div");
        notBox.className+="notification";
        let number = document.createTextNode(n);
        notBox.appendChild(number);
        return notBox;
    }

}

</script>
</html>

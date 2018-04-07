<!DOCTYPE html>
<html lang="en">
        <footer>
    </footer>

<script>
window.onload = function() {
    var x = <?php echo $x ?>;
    var activatedChat = "";
    for(var a = 0; a< x; a++) {

        var id = "message_box_id_"+a;
        document.getElementById(id).addEventListener("click",clicked_message_box,false);

        function clicked_message_box() {
            if(activatedChat != "") {
                document.getElementById(activatedChat).style.backgroundColor = "white";
            }
            document.getElementById(this.id).style.backgroundColor = "#009788";
            activatedChat = this.id;
            httpRequest = new XMLHttpRequest();
            httpRequest.onreadystatechange = function() {
                
            }
            httpRequest.open();
            httpRequest.send();
    }
    }

    document.getElementById("send").addEventListener("click",sendMessage,false );
/*	function sendMessage() {
		var msg = document.getElementById("textarea").value;

        httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() {
            if(httpRequest.readyState == 4 && httpRequest.status==200) {
                document.getElementById("msg").innerHTML = httpRequest.responseText;
            }
        }
        httpRequest.open("GET", 'insert.php?msg='+msg, true);
        httpRequest.send();
	}*/

    function sendMessage() {
        // initialize the websocket
        var wbSocket = new WebSocket("ws://localhost:8080");
        // it's fired when the connection is estabilished
        wbSocket.onopen = function(event) {
        console.log("connection estabilished");
        var message = document.getElementById("textarea").value;
        var msg = {
            id : 1,
            user : "username",
            text: message,
            date: Date.now()
        };
        wbSocket.send(JSON.stringify(msg));
    }
    //it's fired when a message arrives from server
    wbSocket.onmessage = function(event) {
        console.log(event.data);
        var msg = JSON.parse(event.data);
        var message_list = document.getElementById("msg").value;
        document.getElementById("msg").innerHTML = message_list + "/////" + msg.text;
    }
    wbSocket.onerror = function() {
        wbSocket.close();
    }
    }

};

</script>
</html>

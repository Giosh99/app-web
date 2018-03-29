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
    }
    }

    document.getElementById("send").addEventListener("click",sendMessage,false );
	function sendMessage() {
		var msg = document.getElementById("textarea").value;
        httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() {
            if(httpRequest.readyState == 4 && httpRequest.status==200) {
                document.getElementById("msg").innerHTML = httpRequest.responseText;
            }
        }
        httpRequest.open("GET", 'insert.php?msg='+msg, true);
        httpRequest.send();
	}
};

</script>
</html>
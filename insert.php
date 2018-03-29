<?php
if($_GET != null) {
	if($_GET["msg"] != null) {
        $msg = $_GET["msg"];
        $connection = mysqli_connect("localhost","root","password","app");
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $insert_query = "insert into logs(username,msg) values ('boh', '$msg')";
        mysqli_query($connection, $insert_query);

        $select_logs_query = "select * from logs";
        $result = mysqli_query($connection, $select_logs_query);
        while($extract = mysqli_fetch_array($result)) {
            echo "messaggio: ".$extract["msg"]."<br>";
        }
	}
} 
?> 
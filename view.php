<div class="col align-self-end h-100 w-100 p-0" >
	<div class="flex-row d-flex w-100" style="height:80vh; background-color:white; overflow-y: scroll;" id="scrollbar">
	    <div class="col-md-12 col-sm-12 h-100 radius-5 h-100">
	    	gaia non rompere il cazzo
	    </div>
	</div>
	<div class="flex-row d-flex">
		<div class="input-group p-0 col-sm-12 " style="height:12vh">
			<div class="input-group-prepend"><span class="input-group-text input-text-message">Message</span></div>
			<textarea id="textarea" class="form-control" style="resize:none;" placeholder="Write here your message" value=""></textarea>
			<div class="input-group-prepend"><span class="input-group-text input-text-send" id="send" style="cursor:pointer" >SEND</span></div>
		</div>
	</div>
</div>

	<script>
	$(document).ready(function(){
    	$("#send").click(function(){
        	alert($("#textarea").val());
    	});	
	});
	</script>
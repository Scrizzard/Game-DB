
function fetchGamePage(ele){
	var gameID = $(ele).find(".gameID").html();
	
	$.ajax({
	    data: 'gameID=' + gameID,
	    url: 'fetchGamePage.php',
	    method: 'POST',
	    success: function(msg) {
	        $("body").append(msg);
	    }
	});
}	

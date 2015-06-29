window.onload = function(){
	$("#tabs").tabs();
	$(".addField").button();
	
	$("#gameTable").dataTable({
		"lengthChange": false,
        "stripeClasses": [ 'evenStripe', 'oddStripe'],
        //maybe add some math to determine pageLength as a function of monitor resolution
        "pageLength": 15,
	});

	$("#gameTable > tbody > tr").click(function(){fetchGameView(this);});
};

function fetchGameView(ele){
	var gameID = $(ele).find(".gameID").html();
	
	$.ajax({
	    data: 'gameID=' + gameID,
	    url: 'fetchGameView.php',
	    method: 'POST',
	    success: function(msg) {
	        $("body").append(msg);
	    }
	});
}

function addField(ele, fieldName) {
	var container = $(ele).parent();
	var trimLength = fieldName.length;
	
	var inputNum = container.children("input").last().attr("name").slice(trimLength);
	inputNum = parseInt(inputNum) + 1;
	
	var appendString = '<input class="field" type="text" name="' + fieldName + inputNum + '">' +
	'<span class="removeX noSelect" onclick="removeField(this,' + trimLength + ')">X</span>' +
	"<br/>";
	
	container.append(appendString);
}

function removeField(ele, trimLength){
	decrementName($(ele), trimLength);
	
	$(ele).prev().remove(); //input
	$(ele).next().remove(); //br
	$(ele).remove(); //X span
}

function decrementName(ele, trimLength){

	ele.nextAll('input').each(function(index, value){
		var name = $(this).attr('name');
		var fieldName = name.slice(0, trimLength);
		var fieldNumber = parseInt(name.slice(trimLength));
		var newName = fieldName + (fieldNumber - 1);
		
		$(this).attr('name', newName);
	});
}

function makePopup(message){
	alert(message);
}

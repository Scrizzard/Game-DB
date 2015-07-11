window.onload = function(){

	//initialize jQuery widgets
	$("#tabs").tabs();
	$(".addField, .xButton").button();
	
	//datatable for viewing and sorting gmaes
	$("#gameTable").dataTable({
		"lengthChange": false,
        "stripeClasses": [ 'evenStripe', 'oddStripe'],
        //maybe add some math to determine pageLength as a function of monitor resolution
        "pageLength": 15
	});

	//event listener to open up an individual game view
	$("#gameTable > tbody").on('click', 'tr', function(){
		fetchGameView(this);
	});
	
    addRemovalListeners();
};

//perform an AJAX request for a game view
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

//create event listeners to close an individual game view
function addRemovalListeners(){
	$(document).keypress(function(e){
		if(e.which = 27){ //27 is 'esc' keycode
			removeGameView();
		}
	});
	
	$(document).on('click', ".gameViewWrapper", function(){
		console.log("trigger");
		removeGameView();
	});
}

function removeGameView(){
	$(".gameViewWrapper, .gameView").remove();
}

//generic function for adding a new input field (for developer, publisher, genre)
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

//generic function for removing an input field
function removeField(ele, trimLength){
	decrementName($(ele), trimLength);
	
	$(ele).prev().remove(); //input
	$(ele).next().remove(); //br
	$(ele).remove(); //X span
}

//decrement the trailing number name attribute of each subsequent element
function decrementName(ele, trimLength){

	ele.nextAll('input').each(function(index, value){
		var name = $(this).attr('name');
		var fieldName = name.slice(0, trimLength);
		var fieldNumber = parseInt(name.slice(trimLength));
		var newName = fieldName + (fieldNumber - 1);
		
		$(this).attr('name', newName);
	});
}

//placeholder for when I make a nicer version
function makePopup(message){
	alert(message);
}

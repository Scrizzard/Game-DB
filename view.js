/*****************************************************************/
/* Onload Events
/*****************************************************************/

window.onload = function(){

	initializeDataTable();
	$("#tabs").tabs();
	$(".addField, .xButton").button();
	


    addViewFetchListener();
    addViewHideListener();
    addDeletionListener();
    addAutocompletion();    
};

/*****************************************************************/
/* Initialize Widgets and Listeners
/*****************************************************************/

//create or refresh the game DataTable
function initializeDataTable(){
	$("#gameTable").dataTable({
		"bDestroy": true,
		"lengthChange": false,
        "stripeClasses": [ 'evenStripe', 'oddStripe'],
        //maybe add some math to determine pageLength as a function of monitor resolution
        "pageLength": 15
	});	
}

//create event listener to open up an individual game view
function addViewFetchListener(){
	$("#gameTable > tbody").on('click', 'td:not(:last-child)', function(){
		var id = $(this).closest('tr').find("td:first > .gameID").html();
		fetchGameView(id);
	});
}
	
//create event listener to delete records when we press the X button
function addDeletionListener(){
	$("#gameTable > tbody").on('click', '.xButton', function(){
		var gameRow = $(this).closest('tr');
		var id = gameRow.find("td:first > .gameID").html();

		$("#gameTable").dataTable().fnDestroy();
		gameRow.remove();
		initializeDataTable();
		deleteGame(id);
	});
}

//create event listeners to close an individual game view
function addViewHideListener(){
	$(document).keypress(function(e){
		if(e.which = 27){ //27 is 'esc' keycode
			$(".gameViewWrapper, .gameView").remove();
		}
	});
	
	//also close the view if we click outside
	$(document).on('click', ".gameViewWrapper", function(){
		$(".gameViewWrapper, .gameView").remove();
	});
}

//Stores each JSON autocomplete suggestion list
function addAutocompletion(){
	autocompleteField("developer");
	autocompleteField("publisher");
	autocompleteField("genre");	
}

function autocompleteField(attrBase){
	$.ajax({
	    data: 'table=' + attrBase,
	    url: 'fetchNames.php',
	    method: 'POST',
	    success: function(list) {
  	    	$("#" + attrBase + "InputWrapper > input").autocomplete({source: $.parseJSON(list)});
	    }
	});
}

/*****************************************************************/
/* AJAX Queries
/*****************************************************************/

//fetch and display a game's view
function fetchGameView(id){
	$.ajax({
	    data: 'gameID=' + id,
	    url: 'fetchGameView.php',
	    method: 'POST',
	    success: function(msg) {
	        $("body").append(msg);
	    }
	});
}

//drop the game with the passed ID
function deleteGame(id){
	$.ajax({
	    data: 'gameID=' + id,
	    url: 'dropGame.php',
	    method: 'POST',
	    success: function(msg) {
	        console.log(msg);
	    }
	});
}

//fetch the JSON-encoded name column of a passed table


/*****************************************************************/
/* Miscellaneous (TODO: sort better)
/*****************************************************************/

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
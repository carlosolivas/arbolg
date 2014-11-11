$(function() {

  var idOfDropped;
  
  $("#panel").show( 'drop', null, 1500 );

  $( ".toAssign" ).draggable({ revert: "invalid" });
  $( "#connector" ).droppable({
    drop: function( event, ui ) {
      idOfDropped = parseInt(ui.draggable.context.attributes.id.value);  

      if (confirm($("#sendRequestQuestion").text()) == true) {
        window.location = /sendRequest/ + idOfDropped;       
      } 
    }
  });  

});
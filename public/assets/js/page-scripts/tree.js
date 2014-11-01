$(function(){ // on dom ready

// Plugins configuration
$('.datePicker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
    language: "es",
    clearBtn: true,
    changeYear: true,
    startView: 2
}); 

// Global variables
var initNodes;
var initEdges;
var currentMousePos;
/*var rootNodes = [];*/

// Capture the mouse position
$(document).mousemove(function(event) {
    currentMousePos = event;
});


// Load the initial nodes (Persons)
function loadNodesAndRelations()
{
  $.ajax({
    type: "get",
    url: "/loadTreePersons",
    }).done(function( json ) {
      initNodes = json;

      /*initNodes.forEach(function(nodeItem) {
        if (nodeItem.data.isRootNode) {
          rootNodes.push(parseInt(nodeItem.data.id));  
        }                
      });*/

      // Load the initial edges (Relations)
      $.ajax({
        type: "get",
        url: "/loadTreeRelations",
        }).done(function( json ) {
          initEdges = json;    
          initializeCytoscape();    
      });
  });
}

loadNodesAndRelations();

// cy is an instance of Cytoscape, so cy is a graph
var cy;
function initializeCytoscape()
{
  cy = cytoscape({
    container: document.getElementById('tree'),

    style: [
            {
              selector: 'node',
              css: {
                'content': 'data(fullname)',
                'text-valign': 'center',
                'text-halign': 'center'
              }
            },
            {
              selector: 'edge',
              css: {
                'width': 6,
              }
            },
            {
              selector: '$node > node',
              css: {
                'padding-top': '10px',
                'padding-left': '10px',
                'padding-bottom': '10px',
                'padding-right': '10px',
                'text-valign': 'top',
                'text-halign': 'center'
              }
            },
            {
              selector: ':selected',
              css: {
                'background-color': 'green',
                'line-color': 'black',
                'target-arrow-color': 'black',
                'source-arrow-color': 'black',
                'border-width': 3,
                'border-color': '#333'
              }
            }
    ],

    elements:{
      nodes: initNodes,
      edges: initEdges
    },

    layout: {
      name: 'breadthfirst',
      fit: true,
      animate: true,
      padding: 100,
      /*roots: rootNodes,*/
      animationDuration: 1500,
      directed: true,
      avoidOverlap: true,
      maximalAdjustments: 10
    }

  });

  // On click of node 
  cy.on('tap', 'node', function(){    
    
    // Control of opening dialogue
    if ( $( "#menu-form" ).dialog() != null && $( "#menu-form" ).dialog() != undefined) {
      if ($( "#menu-form" ).dialog("isOpen")) {
         $( "#menu-form" ).dialog("close");
       }     
    }

    if ( $( "#addDirectFamiliarDialog-form" ).dialog() != null && $( "#addDirectFamiliarDialog-form" ).dialog() != undefined) {
      if ($( "#addDirectFamiliarDialog-form" ).dialog("isOpen")) {
         $( "#addDirectFamiliarDialog-form" ).dialog("close");
         setValidationBlockMessage();
       }     
    }

    // Data of selected node
    var personDetail_id = this.data('id');
    var personDetail_name = this.data('name');
    var personDetail_lastname = this.data('lastname');
    var personDetail_mothersname = this.data('mothersname');
    var personDetail_email = this.data('email');
    var personDetail_birthdate = this.data('birthdate');
    var personDetail_gender = this.data('gender');
    var personDetail_phone = this.data('phone');
    var personDetail_fullname = this.data('fullname');    
    var personDetail_canAddParents = this.data('canAddParents');

    // Familiar option selected
    var optionSelected = 0;

    // Menu with node selected data
    var menuDialog = $( "#menu-form" ).dialog({
      autoOpen: false,
      open: function(event, ui) { 
        $(".ui-widget-header").css('border','none');
        $(".ui-dialog-titlebar-close").hide();   

        // Put the data of selected node       
        $("#personDetailName").val(personDetail_name);
        $("#personDetailLastName").val(personDetail_lastname);
        $("#personDetailMothersName").val(personDetail_mothersname);
        $("#personDetailEmail").val(personDetail_email);
        $("#personDetailBirthDate").val(personDetail_birthdate);
        $("#personDetailGender").val(personDetail_gender); 
        $("#personDetailPhone").val(personDetail_phone);        

      },
      draggable: false,
      resizable: false,
      show: {
        effect: "scale",
        duration: 200
      },
      modal: false,
      title: 'Menu de ' + personDetail_fullname,
      buttons:{
        "addParent" : {
         text: "Agregar padre",
         id: "addParent",
         class: "btn btn-sm btn-primary",
         click: function(){
          if (!personDetail_canAddParents) {
            return false;
          }
          else {
          optionSelected = getFamiliarOptionsToAdd().PARENT;
          $( this ).dialog().parent().hide("scale",200);
          }

          addDirectFamiliarDialog.dialog('option','title', getTitleForDialog(optionSelected) + personDetail_fullname);
          addDirectFamiliarDialog.dialog( "open" );
         }
       },
        "addBrother" : {
         text: "Agregar hermano",
         id: "addBrother",
         class: "btn btn-sm btn-primary"
       },
       "closeMenu" : {
         text: "Cerrar",
         id: "closeMenu",
         class: "btn btn-sm btn-white",
         click: function(){
           $( this ).dialog( "close" );
         }
       }
      }
    }); 
    menuDialog.dialog({ position: { my: "left+30 bottom+30 center", at: "right bottom", of: currentMousePos } }); 
    
    // Dialog for create a parent
    var addDirectFamiliarDialog = $( "#addDirectFamiliarDialog-form" ).dialog({
      autoOpen: false,
      open: function(event, ui) { 
        $(".ui-widget-header").css('border','none');
        $(".ui-dialog-titlebar-close").hide(); 
        
      },
      draggable: false,
      resizable: false,
      show: {
        effect: "scale",
        duration: 200
      },
      modal: false,
      title: '' ,
       buttons:{
        "Save" : {
         text: "Guardar",
         id: "saveFamiliar",
         class: "btn btn-sm btn-primary",
         click: function(){
          if (addFamiliar_completeFields()) 
          {
              // Fields of new Person
            var newPerson_sonId = personDetail_id; 
            var newPerson_name = $("#newPerson_name").val();
            var newPerson_lastname = $("#newPerson_lastname").val();
            var newPerson_mothersname = $("#newPerson_mothersname").val(); 
            var newPerson_dateOfBirth = $("#newPerson_dateOfBirth").val();
            var newPerson_gender = $("#newPerson_gender").val();
            var newPerson_phone = $("#newPerson_phone").val();

            // Save
            $.ajax({
              type: "post",
              url: getUrlForSaveFamiliar(optionSelected),
              data: { 
                son: newPerson_sonId,
                name: newPerson_name,
                lastname: newPerson_lastname,
                mothersname: newPerson_mothersname,
                dateOfBirth: newPerson_dateOfBirth,
                gender: newPerson_gender,
                phone: newPerson_phone
              }
              }).done(function( json ) {
                   if (json == 'successful') { 

                    $("#newPerson_name").val("");
                    $("#newPerson_lastname").val("");
                    $("#newPerson_mothersname").val(""); 
                    $("#newPerson_dateOfBirth").val("");
                    $("#newPerson_gender").val("");
                    $("#newPerson_phone").val("");          

                    // Reload the graph elements
                    loadNodesAndRelations();

                    // Set the updated elements
                    var elements = initNodes;
                    elements.push(initEdges); 
                    cy.load([ elements ]);    

                   } else {
                  alert(json);
                 }
            });

            // Reset the validation block message to original status
            setValidationBlockMessage();

            // Close the dialog
            $(this).dialog("close");  
            menuDialog.dialog("close");  
          } else {
              setValidationBlockMessage(false);
          }
                              
         }
       },
       "Cancel" : {
         text: "Cancelar",
         id: "cancelSaveFamiliar",
         class: "btn btn-sm btn-white",
         click: function(){

           // Reset the validation block message to original status
           setValidationBlockMessage();

           $( this ).dialog( "close" );   
           $( "#menu-form" ).dialog().parent().show("scale",200);
         }
       }
      }    
    });   
    addDirectFamiliarDialog.dialog({ position: { my: "left+30 bottom", at: "right bottom", of: currentMousePos } }); 

    // Open the menu dialog when the user 'on tap' a node
    menuDialog.dialog( "open" );
  });
}
}); // on dom ready

// Auxiliar functions
function getTitleForDialog(optionSelected)
{
  var options = getFamiliarOptionsToAdd();
  var title;
  switch(optionSelected) {
    case options.PARENT:
        title = 'Agregar padre/madre a: ';
        break;
    case options.SON:
        title = 'Agregar hijo/a a: ';
        break;
     case options.COUP:
        title = 'Agregar pareja a: ';
        break;
    default:
        title = 'Agregar familiar a: ';
        break;    
  }

  return title;
}

function getUrlForSaveFamiliar(optionSelected)
{
  var options = getFamiliarOptionsToAdd();

  var url;
  switch(optionSelected) {
    case options.PARENT:
        url = '/saveParent';
        break;
    case options.SON:
        url = '#';
        break;
     case options.COUP:
        url = '#';
        break;
    default:
        url = '#';
        break;  
  }
  return url;
}

function getFamiliarOptionsToAdd()
{
  var options = {
      PARENT: 1,
      SON: 2,
      COUP: 3
    };

    return options;
}

function addFamiliar_completeFields()
{
  if (($("#newPerson_name").val() != null && $("#newPerson_name").val() != "") &&
    ($("#newPerson_lastname").val() != null && $("#newPerson_lastname").val() != "") &&
    ($("#newPerson_gender").val() != null && $("#newPerson_gender").val() != "") ) {
      return true;
  } else {
    return false;
  }
}

// Set the validation block message for creation of familiar. The function works as "reset" when
// the parameter "fieldsCompleted" is not passed (by default set true)
function setValidationBlockMessage(fieldsCompleted)
{
  if (fieldsCompleted == undefined) {
    fieldsCompleted = true;
  }

  if (fieldsCompleted) {
    $("#validationBlockMessage").text("Los campos marcados con (*) son obligatorios.");
    $("#validationBlockMessage").removeClass( "alert-danger" );
  } else {
    $("#validationBlockMessage").text("Complete los campos obligatorios.");
    $("#validationBlockMessage").addClass( "alert-danger" );
  }
}
                    
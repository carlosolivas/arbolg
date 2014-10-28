$(function(){ // on dom ready

// Plugins configuration
$('.datePicker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
    language: "es",
    clearBtn: true
}); 

// Global variables
var initNodes;
var initEdges;
var currentMousePos;

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
      animate: true,
      padding: 100,
      animationDuration: 1500,
      directed: true,
      avoidOverlap: true,
      maximalAdjustments: 5, 
    }

  });

  // On click of node 
  cy.on('tap', 'node', function(){    
    // Node's options menu

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
      title: 'Menu: ' + personDetail_fullname,
      buttons:{
        "addParent" : {
         text: "Agregar padre",
         id: "addParent",
         class: "btn btn-sm btn-primary",
         click: function(){
             $( this ).dialog().parent().hide("scale",200);
             addParentDialog.dialog( "open" );
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
    var addParentDialog = $( "#addParent-form" ).dialog({
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
      title: 'Agregar padre/madre a: ' + personDetail_fullname,
      buttons:{
        "Save" : {
         text: "Guardar",
         id: "saveParent",
         class: "btn btn-sm btn-primary",
         click: function(){

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
            url: "/saveParent",
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
                 if (json == true) { 

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
                alert('error!');
               }
          });

          // Close the dialog
          $(this).dialog("close");  
          menuDialog.dialog("close");                      
         }
       },
       "Cancel" : {
         text: "Cancelar",
         id: "cancelSaveParent",
         class: "btn btn-sm btn-white",
         click: function(){
             $( this ).dialog( "close" );   
             $( "#menu-form" ).dialog().parent().show("scale",200);
         }
       }
      }
    });    
    addParentDialog.dialog({ position: { my: "left+30 bottom", at: "right bottom", of: currentMousePos } });

    menuDialog.dialog( "open" );
  });
}
}); // on dom ready










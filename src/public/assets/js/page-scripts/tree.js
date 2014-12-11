var cy;
var graph;

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

function initializeCytoscape()
{
  cy = graph =  cytoscape({
    container: document.getElementById('cy'),

    style: [
            {
              selector: 'node',
              css: {
                'content': 'data(fullname)',
                'text-valign': 'bottom',                
                'text-halign': 'center',
                'font-weight': 'bold',
                'font-size': '6px',
                'font-family': 'Helvetica',
                'color': 'black'
              }
            },
            {
              selector: 'edge',
              css: {
                'width': 6,
                'line-color': '#ffaaaa',
                'target-arrow-color': '#ffaaaa',
                'display': 'none'
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
      name: 'dagre',
      animate: false,
      padding: 10,
      rankSep: 60, // separación entre niveles
      edgeSep: 0,
      rankDir: 'TB',
      stop: function () {
        drawRelations();
      },
    },


    // initial viewport state:
    //
    //fit: true,
    //zoom: 1,
    pan: { x: 0, y: 0 },  
    
    //
    // interaction options:
    //
    minZoom: 1e-1,
    maxZoom: 1e1,
    zoomingEnabled: true,
    userZoomingEnabled: true,
    panningEnabled: true,
    userPanningEnabled: false,
    //selectionType: (isTouchDevice ? 'additive' : 'single'),
    autolock: false,
    autoungrabify: true,
    autounselectify: false,

    // 
    // rendering options
    //
    headless: false,
    styleEnabled: true,
    hideEdgesOnViewport: true,
    hideLabelsOnViewport: false,
    textureOnViewport: false,
    motionBlur: false,
    wheelSensitivity: 1,
    pixelRatio: 1,

  });


  cy.on('zoom', null, null, function(evt){
    if(canvasContext) {
      drawRelations();
    }
  });

  cy.on('pan', null, null, function(evt){
    if(canvasContext) {
      drawRelations();
    }
  });  

  cy.panzoom({
   panDistance: 100,
  }); 

  // On click of node 
  cy.on('tap', 'node', function(){    

    /* Set the tree view like disabled */
    $("#cy").fadeTo( "slow", 0.33 );
    
    // Control of opening dialogue
    if ( $( "#menu-form" ).dialog() != null && $( "#menu-form" ).dialog() != undefined) {
      if ($( "#menu-form" ).dialog("isOpen")) {
         $( "#menu-form" ).dialog("close");
       }     
    }

    if ( $( "#familiarDialog-form" ).dialog() != null && $( "#familiarDialog-form" ).dialog() != undefined) {
      if ($( "#familiarDialog-form" ).dialog("isOpen")) {
         $( "#familiarDialog-form" ).dialog("close");
         setValidationBlockMessage();
       }     
    }

    if ( $( "#extendTree-form" ).dialog() != null && $( "#extendTree-form" ).dialog() != undefined) {
      if ($( "#extendTree-form" ).dialog("isOpen")) {         
          $( "#extendTree-form" ).dialog("close");
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
    var canBeUpdatedByLoggedUser =  this.data('canBeUpdatedByLoggedUser');   

    // Familiar option selected
    var optionSelected = 0;

    // Menu with node selected data
    var menuDialog = $( "#menu-form" ).dialog({
      autoOpen: false,
      zIndex: 50000,
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
      title: 'Menú de ' + personDetail_fullname,
      buttons:{
         "updateData" : {
         text: "Editar",
         id: "updateData",
         class: (canBeUpdatedByLoggedUser ? "btn btn-success btn-xs" : "btn btn-default btn-xs"),
         click: function(){

          if (!canBeUpdatedByLoggedUser) {
            return false;
          }

          optionSelected = getFamiliarOptionsToAdd().UPDATEDATA;
          $( this ).dialog().parent().hide("scale",200);

          // If has real data loaded (is not an auxiliar node for create brohers)
          if (personDetail_lastname.trim().length > 0)
          {
            $("#newPerson_name").val(personDetail_name);
            $("#newPerson_lastname").val(personDetail_lastname);
            $("#newPerson_mothersname").val(personDetail_mothersname);
            $("#newPerson_dateOfBirth").val(personDetail_birthdate);
            $("#newPerson_gender").val(personDetail_gender); 
            $("#newPerson_phone").val(personDetail_phone);   
          }         

          familiarDialog.dialog('option','title', getTitleForDialog(optionSelected) + personDetail_fullname);
          familiarDialog.dialog( "open" );
         }
       },
        "addParent" : {
         text: "Agregar padre/madre",
         id: "addParent",
         class: "btn btn-success btn-xs",
         click: function(){   
          if (!personDetail_canAddParents) {
            return false;
          }
          else {
          optionSelected = getFamiliarOptionsToAdd().PARENT;
          $( this ).dialog().parent().hide("scale",200);  
          }        

          familiarDialog.dialog('option','title', getTitleForDialog(optionSelected) + personDetail_fullname);
          familiarDialog.dialog( "open" );
         }
       },      
        "extendTree" : {
         text: "Agregar hermano/a",
         id: "extendTree",         
         class: "btn btn-success btn-xs",
         click: function() {

          if (!canBeUpdatedByLoggedUser) {
            return false;
          }          

          $( this ).dialog().parent().hide("scale",200);
          suggestedsDialog.dialog("open");          
        }
       },
       "setPhoto" : {
         text: "Cambiar Foto",
         id: "setPhoto",
         class: "btn btn-success btn-xs",
         click: function(){
          window.location = "/setPhoto/" + personDetail_id;
         }
       },
       "closeMenu" : {
         text: "Cerrar",
         id: "closeMenu",
         class: "btn btn-success btn-xs",
         click: function(){
          $("#extendTree-form").html("");
           $( this ).dialog( "close" );

           /* Remove the tree view like disabled  */
           $("#cy").css({opacity: 1})
         }
       }
      }
    }); 
    menuDialog.dialog({ position: { my: "left+30 bottom+30 center", at: "right bottom", of: currentMousePos }, width: 550}); 
    menuDialog.parent().css('z-index', 50000);
    // Dialog for create a familiar and manage the data edition of them and the person logged
    var familiarDialog = $( "#familiarDialog-form" ).dialog({
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
         class: "btn btn-success btn-xs",
         click: function(){

          if (addFamiliar_completeFields()) 
          {
              // Fields of new Person
            var selectedPersonId = personDetail_id; 
            var newPerson_name = $("#newPerson_name").val();
            var newPerson_lastname = $("#newPerson_lastname").val();
            var newPerson_mothersname = $("#newPerson_mothersname").val(); 
            var newPerson_dateOfBirth = $("#newPerson_dateOfBirth").val();
            var newPerson_gender = $("#newPerson_gender").val();
            var newPerson_phone = $("#newPerson_phone").val();  
            var newPerson_email = $("#newPerson_email").val();                         
            
            // Save
            $.ajax({
              type: "post",
              url: getUrlForSaveFamiliar(optionSelected),
              data: { 
                id: selectedPersonId, // Used when editing data of the Person
                son: selectedPersonId, // Used when adding parent to Person
                name: newPerson_name,
                lastname: newPerson_lastname,
                mothersname: newPerson_mothersname,
                dateOfBirth: newPerson_dateOfBirth,
                gender: newPerson_gender,
                phone: newPerson_phone,
                email: newPerson_email
              }
              }).done(function( json ) {
                   if (json == 'successful') { 

                    $("#newPerson_name").val("");
                    $("#newPerson_lastname").val("");
                    $("#newPerson_mothersname").val(""); 
                    $("#newPerson_dateOfBirth").val("");
                    $("#newPerson_gender").val("");
                    $("#newPerson_phone").val("");      
                    $("#newPerson_email").val("");     

                    // Reload the graph elements
                    loadNodesAndRelations();

                    // Set the updated elements
                    var elements = initNodes;
                    elements.concat(initEdges); 
                    cy.load({nodes: initNodes, edges: initEdges});    
                    //cy.layout();
                    window.location = "/tree";

                   } else {
                      $("#newPerson_name").val("");
                      $("#newPerson_lastname").val("");
                      $("#newPerson_mothersname").val(""); 
                      $("#newPerson_dateOfBirth").val("");
                      $("#newPerson_gender").val("");
                      $("#newPerson_phone").val("");      
                      $("#newPerson_email").val("");   
                      alert(json);
                 }
            });

            // Reset the validation block message to original status
            setValidationBlockMessage();

            // Close the dialog
            $(this).dialog("close");  
            menuDialog.dialog("close");  

            /* Remove the tree view like disabled  */
            $("#cy").css({opacity: 1});
          } else {
              setValidationBlockMessage(false);
          }
                              
         }
       },
       "Cancel" : {
         text: "Cancelar",
         id: "cancelSaveFamiliar",
         class: "btn btn-success btn-xs",
         click: function(){

          $("#newPerson_name").val("");
          $("#newPerson_lastname").val("");
          $("#newPerson_mothersname").val(""); 
          $("#newPerson_dateOfBirth").val("");
          $("#newPerson_gender").val("");
          $("#newPerson_phone").val("");        

           // Reset the validation block message to original status
           setValidationBlockMessage();

           $( this ).dialog( "close" );   
           $( "#menu-form" ).dialog().parent().show("scale",200);
         }
       }
      }    
    });   
    familiarDialog.dialog({ position: { my: "left+30 bottom", at: "right bottom", of: currentMousePos } });     
    familiarDialog.parent().css('z-index', 50000);
    /* Dialog for suggesteds persons to connect */
    var suggestedsDialog = $("#extendTree-form").dialog({
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
      title: 'Sugeridos',
      buttons: {
        "Cancel" : {
         text: "Cancelar",
         id: "cancelExtend",
         class: "btn btn-success btn-xs",
         click: function(){
           $( this ).dialog( "close" );   
           $( "#menu-form" ).dialog().parent().show("scale",200);
         }
       }
      }
    });
    suggestedsDialog.dialog({ position: { my: "left+30 bottom", at: "right bottom", of: currentMousePos } }); 
    suggestedsDialog.parent().css('z-index', 50000);

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
    case options.UPDATEDATA:
        title = 'Actualizar datos a: ';
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
    case options.UPDATEDATA:
      url = '/updatePersonData';
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
      COUP: 3,
      UPDATEDATA: 4
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

/* Suggested functionalities */
$(document).on('mouseenter', '.onHoverShow', function () {
    $(this).find(":button").show('slide');
}).on('mouseleave', '.onHoverShow', function () {
    $(this).find(":button").hide('slide');
});

$("#closeSuggesteds").click(function(){
  $("#suggesteds").hide('slide');
  $("html, body").animate({ scrollTop: 1 }, "slow");
})
                    
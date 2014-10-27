$(function(){ // on dom ready

// Global variables
var initNodes;
var initEdges;
var currentMousePos;


  $(document).mousemove(function(event) {
      currentMousePos = event;
  });


// Load the initial nodes (Persons)
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
                'content': 'data(name)',
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

  cy.on('tap', 'node', function(){    
    // Node's options menu

    // Data of selected node
    var name = this.data('name');
    var lastname = this.data('lastname');
    var mothersname = this.data('mothersname');
    var email = this.data('email');
    var birthdate = this.data('birthdate');
    var gender = this.data('gender');
    var phone = this.data('phone');

    var dialog = $( "#menu-form" ).dialog({
      autoOpen: false,
      closeOnEscape: true,
      open: function(event, ui) { 
        $(".ui-widget-header").css('border','none');
        $(".ui-dialog-titlebar-close").hide();   

        // Put the data of selected node
        var list = $("#menu-form-message").append('<ul></ul>').find('ul');        
        list.append("<li> Nombre: " + name + "</li>");
        list.append("<li> Apellido: " + lastname + "</li>");
        list.append("<li> Apellido materno: " + mothersname + "</li>");
        list.append("<li> Email: " + email + "</li>");
        list.append("<li> Cumpleaños: " + birthdate + "</li>");
        list.append("<li> Sexo: " + gender + "</li>");
        list.append("<li> Teléfono: " + phone + "</li>");
        
        dialog.prepend('<button href="javascript:void(0);" id="addBrother">Agregar hermano</button>');
        dialog.prepend('<button href="javascript:void(0);" id="addParent">Agregar padre</button>');  

        $('#addParent').click(function () {
          window.location = '/create';
        });  
      },
      draggable: false,
      resizable: false,
      show: {
        effect: "scale",
        duration: 200
      },
      width: 'auto',
      modal: false,
      buttons:{
      'Cerrar': function(){
         $( this ).dialog( "close" );
         $( "#menu-form-message" ).empty();
         $( "#addBrother" ).remove();
         $( "#addParent" ).remove();
        }
      }
    });   

    dialog.dialog({ position: { my: "left+30 center", at: "right center", of: currentMousePos } });
    dialog.dialog( "open" );
    
    // Node's options menu

  });
}
}); // on dom ready










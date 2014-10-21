$(function(){ // on dom ready

var initNodes;
var initEdges;

// Flags
var initNodesLoaded = false;

// Load the initial nodes (Persons)
$.ajax({
  type: "get",
  url: "/loadTreePersons",
  }).done(function( json ) {
    initNodes = json;
    initNodesLoaded = true;
  });

// Load the initial edges (Relations)
  $.ajax({
  type: "get",
  url: "/loadTreeRelations",
  }).done(function( json ) {
    initEdges = json;
    if (initNodesLoaded) {
       initializeCytoscape();
     } else {
        alert('Cannot load initial nodes');
     }   
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
                'background-color': 'black',
                'line-color': 'black',
                'target-arrow-color': 'black',
                'source-arrow-color': 'black'
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
    }

  });
}

}); // on dom ready






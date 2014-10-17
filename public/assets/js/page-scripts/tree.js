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
     };   
  });

// cy is an instance of Cytoscape.js, so cy is a graph
  var cy;
  function initializeCytoscape()
  {
    cy = cytoscape({
      container: document.getElementById('tree'),

      elements:{
        nodes: initNodes,
        edges: initEdges
      }

    });
}
}); // on dom ready






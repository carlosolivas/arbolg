/**
 * Arbolizr.js
 *
 * Agnostic tree edge drawer for cytoscape.js
 *
 * @author Kiwing IT <info@kiwing.it>
 * @author Leandro Banchio <lbanchio@gmail.com>
 *
 */

var canvasContext = null;
var GRAPH_CONTAINER = '#cy';
var CANVAS_SELECTOR = '[data-id="layer1"]';
var LAYER_SELECTOR = '[data-id="relations"]';
var COINTAINER_SELECTOR = '#cy div:first';
var NODE_SELECTOR = 'node';
var NODE_BORDER_WIDTH = 1;
var DEBUG = true;
var FIRST = 0;
var canvasHeight = 500;
var canvasWidth = 500;
var COUPLE_LINE_STYLE = '#FF0000';


//var nodes = 

function dd (obj) {
    if(DEBUG) {
        console.debug(obj);
    }
}

function pos(node) {
    if (node.position) {
        console.log(node.position());
    }
}

function clearTree() {
	canvasContext.clearRect(0, 0, $(LAYER_SELECTOR)[FIRST].width, $(LAYER_SELECTOR)[FIRST].height);
}

function drawRelations() {

    if($(LAYER_SELECTOR).length < 1) {
        if ($(COINTAINER_SELECTOR).height() != 0 && $(COINTAINER_SELECTOR).width() != 0) {
            canvasHeight = $(COINTAINER_SELECTOR).height();
            canvasWidth = $(COINTAINER_SELECTOR).width();
        };
        
        $(COINTAINER_SELECTOR).append("<canvas data-id=\"relations\" width=\"" + canvasWidth + "\" height=\"" + canvasHeight + "\" style=\"position: absolute; z-index: 10; width: " + $(COINTAINER_SELECTOR).width() + "px; height: " + $(COINTAINER_SELECTOR).height() + "px;\"></canvas>");
        canvasContext = $(LAYER_SELECTOR)[FIRST].getContext("2d");
    } else {
        canvasContext.clearRect(0, 0, $(LAYER_SELECTOR)[FIRST].width, $(LAYER_SELECTOR)[FIRST].height);     
    }
    
    canvasContext.clearRect ( 0 , 0 , $(LAYER_SELECTOR).width, $(LAYER_SELECTOR).height );
    
    if(canvasContext) {

        for (i = 0; i < graph.$('node').length; i++) { 
            
            n = graph.$('node')[i];
            childrens = getChildrens(n.data().id);

            canvasContext.lineWidth = NODE_BORDER_WIDTH * graph.zoom();
            canvasContext.strokeStyle = '#0081CB';
            canvasContext.lineCap = 'round';
            
            cp = parentCoParents(n.data().id);
            cp.push(parseInt(n.data().id));

            if(childrens.length == 1) {
                if(graph.$('node#' + childrens[0]).data('aux')) {
                    drawCoupleLine(cp);
                    continue;
                }
                    h = hLineBounds(cp, true); 
                    v = vLineBounds(cp, true);

                    makeLineBounds(h, v);

                    drawChildrensSupLine(childrens);
                    drawLine(lineBounds);
                drawParentsLine(graph.$('node')[i].data().id);
                
                //return
            } else if(childrens.length > 1) {
                if(isLeftParent(n.data().id, cp)) {
                    //dd(childrens);
                    h = hLineBounds(childrens); 
                    v = vLineBounds(childrens);

                    makeLineBounds(h, v);

                    drawChildrensSupLine(childrens);
                    drawLine(lineBounds);
                }
                drawParentsLine(graph.$('node')[i].data().id);
            }
        }
    }
}


function makeLineBounds(h, v) {
    lineBounds = {
        p1:{
            x: h.p1.x,
            y: v.p1.y
        },
        p2:{
            x: h.p2.x,
            y: v.p2.y,
        }
    }

    return lineBounds;  
}
/** 
 * Returns the coparents of a node
 *
 */
function parentCoParents(nodeId) {
    var _coparents = [];
    var _parents = null;
    var _kids = getChildrens(nodeId);

    Array.prototype.inArray = function(comparer) { 
        for(var ei=0; ei < this.length; ei++) { 
            if(comparer(this[ei])) return true; 
        }
        return false; 
    }; 
    
    Array.prototype.pushIfNotExist = function(element, comparer) { 
        if (!this.inArray(comparer)) {
            this.push(element);
        }
    }; 

    for (var k in _kids) {
        var _parents = graph.$('edge[target="'+_kids[k]+'"]');
        for(var p = 0; p < _parents.length; p++) {

            var parentId = _parents[p].data().source;

            if(parseInt(parentId) === parseInt(nodeId)) {
                continue;
            }

            _coparents.pushIfNotExist(parseInt(parentId), function (p) {
                return p === parseInt(parentId);
            });
        }    
        //console.log(_parents);
    }

    return _coparents;
}

function coParents (children) 
{
    var _coparents = [];
    var _relations  = graph.$('edge[target="'+children+'"]');

    for (var r = 0; r < _relations.length; r++) {
        //dd('Parent found: ' + _relations[r].data().source);
        _coparents.push(parseInt(_relations[r].data().source));
    }

    return _coparents;
}

function parentsOf(nodeId)
{
    ret = [];
    relations = graph.$('edge');

    for (ci = 0; ci < relations.length; ci++) {
        if (relations[ci].data().source == nodeId) {
            ret.push(relations[ci].data().target)
        }
    }

    return ret;
}

function parentsOfChild() {

}

function isLeftParent (parentId, parents) {
    return leftParent(parents) == parentId;

}

function leftParent (parents) {
    _leftParent = null;
    for (var idx in parents) {

        if (!isFinite(parents[idx])) {
            continue;
        }

        if(_leftParent === null || _leftParent === 'undefined' ) {
            _leftParent = parents[idx];
            _position = graph.$('node#' + _leftParent).position().x
            continue;
        }

        nPos = parseInt(graph.$('node#' + parents[idx]).position().x);

        if(nPos < _position) {
            _leftParent = parents[idx];
            _position = graph.$('node#' + _leftParent).position().x
        }
    }

    return _leftParent;
}

function rightParent (parents) {
    _rightParent = null;
    _position = null;
    for (var idx in parents) {
        if(_rightParent === null || _rightParent === 'undefined' ) {
            _rightParent = parents[idx];
            _position = graph.$('node#' + _rightParent).position().x
            continue;
        }

        nPos = parseInt(graph.$('node#' + parents[idx]).position().x);

        if(nPos > _position) {
            _rightParent = parents[idx];
            _position = graph.$('node#' + _rightParent).position().x
        }
    }

    return _rightParent;
}
    

/**
*  Returns an array with childrens ids of a node
*/
function getChildrens(nodeId) 
{
    var _relations = graph.$('edge[source="'+nodeId+'"]');

    var _childrens = [];

    for(var r = 0; r < _relations.length; r++) {
        //dd('Children found: ' + _relations[r].data().target);
        _childrens.push(parseInt(_relations[r].data().target));
    }

    return _childrens;
}

function drawChildrensSupLine (childrens)
{
    separation = graph.options().layout.rankSep / 2;
    lineHeight = parseInt(graph.$(NODE_SELECTOR).css().height) / 2;

    for (var child in childrens) {
        if(isFinite(child)) {
            canvasContext.beginPath();

            node = graph.getElementById(childrens[child]);

            xStart = posH(node.position().x);
            xEnd = xStart;
            yStart = posV(node.position().y - (separation + lineHeight));   
            yEnd = posV(node.position().y - lineHeight - NODE_BORDER_WIDTH);

            canvasContext.moveTo(xStart, yStart);
            canvasContext.lineTo(xEnd, yEnd);

            canvasContext.stroke();
        }
    }
 }

function drawCoupleLine(couple) {
    nodeWidth = parseInt(graph.$(NODE_SELECTOR).css().width) / 2;
    
    if(isLeftParent(couple[0], couple)) {
        signA = 1;
        signB = -1;
    } else {
        signA = -1;
        signB = 1;
    }

    bounds = {
        p1:{
            x:posH(graph.$('node#' + couple[0]).position().x + (nodeWidth + 1) * signA),
            y:posV(graph.$('node#' + couple[0]).position().y)
        },
        p2: {
            x:posH(graph.$('node#' + couple[1]).position().x + (nodeWidth + 1) * signB),
            y:posV(graph.$('node#' + couple[1]).position().y)
        }
    };
    drawLine(bounds, COUPLE_LINE_STYLE);
}


function drawParentsLine (parentId) {
    separation = graph.options().layout.rankSep / 2;
    lineHeight = parseInt(graph.$(NODE_SELECTOR).css().height) / 2;
    LABEL_BOTTOM_SPACE = 8;

        bounds = {
            p1:{
                x:posH(graph.$('#' + parentId).position().x),
                y:posV(graph.$('#' + parentId).position().y + lineHeight + NODE_BORDER_WIDTH + LABEL_BOTTOM_SPACE)
            },
            p2: {
                x:posH(graph.$('#' + parentId).position().x),
                y:posV(graph.$('#' + parentId).position().y + lineHeight + separation)
            }
        };
        drawLine(bounds);

}

    function drawLine (bounds, strokeStyle) {
        canvasContext.beginPath();

        if(strokeStyle) {
            canvasContext.strokeStyle = strokeStyle;
        }
        canvasContext.moveTo(bounds.p1.x, bounds.p1.y);
        canvasContext.lineTo(bounds.p2.x, bounds.p2.y);
        canvasContext.stroke();


    }

    function posH (xPos) {
        //return xPos + graph.viewport().getCenterPan().x;
        return (xPos * graph.zoom()) + (graph.viewport().pan().x);
    }

    function posV (yPos) {
        //yCenterPan = graph.viewport().pan().y;
        //return (yPos * graph.zoom()) +  yCenterPan) * graph.zoom();
        return (yPos * graph.zoom()) + (graph.viewport().pan().y);
    }

function vLineBounds (childrens, isBottomLine) {
    yChildrens = [];

    separation = graph.options().layout.rankSep / 2;
    lineHeight = parseInt(graph.$(NODE_SELECTOR).css().height) / 2;

    for (var child in childrens) {
        if(isFinite(child)) {
            node = graph.getElementById(childrens[child]);
            if(isBottomLine) {
                nodeVerticalPosition = posV(node.position().y + (separation + lineHeight));
            } else {
                nodeVerticalPosition = posV(node.position().y - (separation + lineHeight));
            }
            yChildrens.push(nodeVerticalPosition);
        }
    } 

    yPos = minMax(yChildrens);

    return {p1: {y:yPos.min}, p2: {y:yPos.max}};
}

function hLineBounds (childrens, noParentsCheck) {
    var xChildrens = [];

    for (var child in childrens){
        
        if(!noParentsCheck) {
            _parents = graph.elements('edge[target = "' + childrens[child] + '"]');
            if(_parents.length >= 2) {
                for(ii = 0; ii < _parents.length; ii++) {
                    xChildrens.push(posH(_parents[ii].source().position().x));
                }
            }
        }

        if(isFinite(child)) {
            xChildrens.push(posH(graph.getElementById(childrens[child]).position().x));
        }
    }

    
    
    xPos = minMax(xChildrens);

    return {p1: {x:xPos.min}, p2: {x:xPos.max}};
}


function minMax (elements) {
    min = null;
    max = null;

    if(elements.length == 1) {
        return {'min': elements[0], 'max': elements[0]};
    }

    for (var elem in elements){
        if(elements[elem] < min) {
            min = elements[elem];
        }
        if(elements[elem] > max) {
            max = elements[elem];
        }
        if(min == null) {
            min = elements[elem];
        }
    }
    return {'min': min, 'max': max};
}



$(document).ready(function () {

});

var concentric = {
	name: 'concentric',

	fit: true, // whether to fit the viewport to the graph
	padding: 65, // the padding on fit
	startAngle: 3 / 2 * Math.PI, // where nodes start in radians
	sweep: undefined, // how many radians should be between the first and last node (defaults to full circle)
	clockwise: true, // whether the layout should go clockwise (true) or counterclockwise/anticlockwise (false)
	equidistant: false, // whether levels have an equal radial distance betwen them, may cause bounding box overflow
	minNodeSpacing: 10, // min spacing between outside of nodes (used for radius adjustment)
	boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
	avoidOverlap: true, // prevents node overlap, may overflow boundingBox if not enough space
	nodeDimensionsIncludeLabels: false, // Excludes the label when calculating node bounding boxes for the layout algorithm
	height: undefined, // height of layout area (overrides container height)
	width: undefined, // width of layout area (overrides container width)
	spacingFactor: undefined, // Applies a multiplicative factor (>0) to expand or compress the overall area that the nodes take up
	concentric: function( node ){ // returns numeric value for each node, placing higher nodes in levels towards the centre
		return node.degree();
	},
	levelWidth: function( nodes ){ // the letiation of concentric values in each level
		return nodes.maxDegree() / 4;
	},
	animate: false, // whether to transition the node positions
	animationDuration: 500, // duration of animation in ms if enabled
	animationEasing: undefined, // easing of animation if enabled
	animateFilter: function ( node, i ){ return true; }, // a function that determines whether the node should be animated.  All nodes animated by default on animate enabled.  Non-animated nodes are positioned immediately when the layout starts
	ready: undefined, // callback on layoutready
	stop: undefined, // callback on layoutstop
	transform: function (node, position ){ return position; } // transform a given node position. Useful for changing flow direction in discrete layouts
};


var circle = {
	name: 'circle',
	fit: true, // whether to fit the viewport to the graph
	padding: 30, // the padding on fit
	boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
	avoidOverlap: true, // prevents node overlap, may overflow boundingBox and radius if not enough space
	nodeDimensionsIncludeLabels: false, // Excludes the label when calculating node bounding boxes for the layout algorithm
	spacingFactor: undefined, // Applies a multiplicative factor (>0) to expand or compress the overall area that the nodes take up
	radius: undefined, // the radius of the circle
	startAngle: 3 / 2 * Math.PI, // where nodes start in radians
	sweep: undefined, // how many radians should be between the first and last node (defaults to full circle)
	clockwise: true, // whether the layout should go clockwise (true) or counterclockwise/anticlockwise (false)
	sort: undefined, // a sorting function to order the nodes; e.g. function(a, b){ return a.data('weight') - b.data('weight') }
	animate: false, // whether to transition the node positions
	animationDuration: 500, // duration of animation in ms if enabled
	animationEasing: undefined, // easing of animation if enabled
	animateFilter: function ( node, i ){ return true; }, // a function that determines whether the node should be animated.  All nodes animated by default on animate enabled.  Non-animated nodes are positioned immediately when the layout starts
	ready: undefined, // callback on layoutready
	stop: undefined, // callback on layoutstop
	transform: function (node, position ){ return position; } // transform a given node position. Useful for changing flow direction in discrete layouts
};



var cy = cytoscape({
	container: document.getElementById('cy'),
	elements: [],
	style: [
		{
			selector: 'node',
			style: {
				'background-color': 'blue',
				label: 'data(name)',
			}
		},
		{
			selector: 'edge',
			style: {
				'label': 'data(metric)'
			}
		}]
});
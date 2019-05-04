$.ajax({
	url: "/data/onload",
	cache: true
})
	.done(function(data) {
		data['networks'].forEach(function (network) {
			cy.add({
				data: {id: network['id'], name:network['name']}
			});
		});

		data['nodes'].forEach(function (node) {
			cy.add({
				data: {
					id: "n_" + node['id'],
					source: node['network_a'],
					target: node['network_b'],
					metric: node['metric']
				}
			});
		});
		cy.layout({
			name: 'cose-bilkent',
			animate: 'end',
			animationEasing: 'ease-out',
			animationDuration: 1000,
			randomize: true,
			idealEdgeLength: 490,
		}).run();
	});

document.getElementById("randome").addEventListener("click", function(){
	var layout = cy.layout({
		name: 'random',
		animate: 'end',
		animationEasing: 'ease-out',
		animationDuration: 1000,
		randomize: true
	});

	layout.run();
});

document.getElementById("circle").addEventListener("click", function(){
	var layout = cy.layout({
		name: 'circle',
		animate: 'end',
		animationEasing: 'ease-out',
		animationDuration: 1000,
		randomize: true
	});

	layout.run();
});

document.getElementById("grid").addEventListener("click", function(){
	var layout = cy.layout({
		name: 'grid',
		animate: 'end',
		animationEasing: 'ease-out',
		animationDuration: 1000,
		randomize: true
	});

	layout.run();
});

document.getElementById("topology").addEventListener("click", function(){
	var layout = cy.layout({
		name: 'cose-bilkent',
		animate: 'end',
		animationEasing: 'ease-out',
		animationDuration: 1000,
		randomize: true
	});

	layout.run();
});


cy.on('click', 'node', function(evt){
	var target = evt.target._private.data;
	var href = document.getElementById("redirHref");
	 href.setAttribute('href','/homepage/generate/'+target.id);
	 href.innerText = "Zobrazit routovací tabulku pro: "+target.name;
});
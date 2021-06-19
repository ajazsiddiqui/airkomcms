
dragula([
	document.getElementById('1'),
	document.getElementById('2'),
	document.getElementById('3'),
	document.getElementById('4'),
	document.getElementById('5'),
	document.getElementById('6'),
	document.getElementById('7'),
	document.getElementById('8'),
	document.getElementById('9'),
	document.getElementById('10')
])

.on('drag', function(el) {
	
	// add 'is-moving' class to element being dragged
	el.classList.add('is-moving');
})
.on('dragend', function(el) {
	
	// remove 'is-moving' class from element after dragging has stopped
	el.classList.remove('is-moving');
	
	console.log(el.offsetParent.attributes["data-stage"].value);
	console.log(el.attributes['data-spt'].value);
	console.log(el.attributes['data-id'].value);
	
	stage = el.offsetParent.attributes["data-stage"].value;
	spt = el.attributes['data-spt'].value;
	pipeline = el.attributes['data-id'].value;
	user = el.attributes['data-user'].value;
	
	$.ajax({
	  url: baseurl + 'pipeline/changeStage?pipeline='+pipeline+'&spt='+spt+'&stage='+stage+'&user='+user,
	  type: 'GET',
	  dataType: 'json',
	  success: function(data) {
		  console.log(data);
	  },
	  error: function(jqXHR, textStatus, errorThrown) {
		  console.log(textStatus, errorThrown);
		}
	})
	
	// add the 'is-moved' class for 600ms then remove it
	window.setTimeout(function() {
		el.classList.add('is-moved');
		window.setTimeout(function() {
			el.classList.remove('is-moved');
		}, 600);
	}, 100);
});
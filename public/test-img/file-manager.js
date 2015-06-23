function handleFileSelect(evt) {
	//evt.stopPropagation();
    //evt.preventDefault();
    //var file = evt.dataTransfer.files[0]; // FileList object.
	
	var file = evt.target.files[0]; // FileList object
	console.log("File: " + file);

	// Only process image files.
	if(!file.type.match('image.*')){
		return;
	}
	var reader = new FileReader();
	// Closure to capture the file information.
	reader.onload = (function(theFile) {
		return function(e) {
		  // Render thumbnail.
		  var span = document.createElement('span');
		  span.innerHTML = ['<img class="thumb" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
		  document.getElementById('preview').insertBefore(span, null);
		};
	})(file);
	// Read in the image file as a data URL.
	reader.readAsDataURL(file);

	var output = '<strong>' + escape(file.name) + '</strong> (' + (file.type || 'n/a') + ') - ' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a');
	document.getElementById('info').innerHTML = output;
}

function handleDragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

document.addEventListener('DOMContentLoaded', function () { // wrap function when the DOM finished loading
    document.getElementById('imagen').addEventListener('change', handleFileSelect, false);
    
    /*var dropZone = document.getElementById('drop-zone');
	dropZone.addEventListener('dragover', handleDragOver, false);
	dropZone.addEventListener('drop', handleFileSelect, false);*/
});




// Funcionalidad solo para botón de envio:
/*function handleFileSelect(evt) {
	var file = evt.target.files[0]; // FileList object
	var output = '<strong>' + escape(file.name) + '</strong> (' + (file.type || 'n/a') + ') - ' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a');
	document.getElementById('info').innerHTML = output;
}

document.addEventListener('DOMContentLoaded', function () { // wrap function when the DOM finished loading
    document.getElementById('imagen').addEventListener('change', handleFileSelect, false);
});*/

// Funcionalidad solo para drag n drop:
/*function handleFileSelect(evt) {
	evt.stopPropagation();
    evt.preventDefault();
    var file = evt.dataTransfer.files[0]; // FileList object.
	var output = '<strong>' + escape(file.name) + '</strong> (' + (file.type || 'n/a') + ') - ' + file.size + ' bytes, last modified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a');
	document.getElementById('info').innerHTML = output;
}

function handleDragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

document.addEventListener('DOMContentLoaded', function () { // wrap function when the DOM finished loading
    document.getElementById('imagen').addEventListener('change', handleFileSelect, false);
    var dropZone = document.getElementById('drop-zone');
	dropZone.addEventListener('dragover', handleDragOver, false);
	dropZone.addEventListener('drop', handleFileSelect, false);
});*/
window.onload = init;
var context;    // Audio context
var buf;        // Audio buffer

$(document).ready(function() {
 	
    init();
});



function init() {
if (!window.AudioContext) {
    if (!window.webkitAudioContext) {
        alert("Your browser does not support any AudioContext and cannot play back this audio.");
        return;
    }
        window.AudioContext = window.webkitAudioContext;
    }

    context = new AudioContext();
}

function playByteArray(mensaje) {

	//var byteArray = window.crypto.getRandomValues(new Uint8Array(mensaje));
	var byteArray = [];
    while (mensaje.length >= 2) { 
        byteArray.push(parseInt(mensaje.substring(0, 2), 16));
        mensaje = mensaje.substring(2, mensaje.length);
    }

    var arrayBuffer = new ArrayBuffer(byteArray.length);
    var bufferView = new Uint8Array(arrayBuffer);
    for (i = 0; i < byteArray.length; i++) {
      bufferView[i] = byteArray[i];
    }

    context.decodeAudioData(arrayBuffer, function(buffer) {
        buf = buffer;
        play();
    });
}

// Play the loaded file
function play() {
    // Create a source node from the buffer
    var source = context.createBufferSource();
    source.buffer = buf;
    // Connect to the final output node (the speakers)
    source.connect(context.destination);
    // Play immediately
    source.start(0);
}
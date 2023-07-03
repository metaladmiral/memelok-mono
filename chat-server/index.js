
var http = require('http').createServer().listen(3000, 'memelok.me');
const io = require("socket.io")(http, {
	cors: {
		origin: "*"
	  }
});

io.on('connection', function(socket){
	socket.emit('chat-id', socket.id);

	socket.on('private-chat-send', function(data){

		var id = data.chatid;
		socket.broadcast.to(id).emit('private-chat-recv', data);		

	});

});

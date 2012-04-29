
var redis = require('redis');
var client = redis.createClient();
client.on('error', function(err) {
	 console.log("Redis-Error " + err);		
});

var io = require('socket.io').listen(8081);
io.sockets.on('connection', function (socket) {
	socket.emit('news', { hello: 'world' });
	socket.on('getRedisData', function (config) {
		console.log('getRedisData', config);
		if ( !config.pid ) config.pid = 0;
	
		var match = '{nf}{*}{'+config.pid+'}';
		if ( config.id ) { match = '{nf}{'+config.id+'}{*}' } 
		
		client.keys(match, function (err, replies) {
			replies.sort();
			client.mget(replies, function (err, res) {
				if ( !res ) return false;
				
				for(i=0;i<res.length;i++) { res[i] = eval('(' + res[i] + ')'); };
				socket.emit('getRedisDataResponse', res);
			});
			
			console.log('DEBUG:::::' + replies.length + " replies:");
			socket.emit('debug', replies);
		});
	});
  
	socket.on('setRedisData', function(data) {
		console.log('setRedisData', data);
		if ( !data.pid ) data.pid = 0;
		data.id = new Date().getTime() + Math.random();
		data.time = new Date().getTime();
		client.set('{nf}{'+data.id+'}{'+data.pid+'}', JSON.stringify(data), redis.print);
		
		socket.emit('publish', data);
		socket.broadcast.emit('publish', data);
	});
});

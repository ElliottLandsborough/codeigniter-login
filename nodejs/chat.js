var io = require('socket.io').listen(2000);

io.sockets.on('connection', function(socket)
{
    var userName;
    io.sockets.send('Please enter a user name ...');
    socket.on('message', function(message)
    {
        if (!userName)
        {
            userName = message;
            io.sockets.send(message + ' has entered the zone.');
            return;
        }
        else
        {
            var broadcastMessage = userName + ': ' + message;
            io.sockets.send(broadcastMessage);
            return;
        }
    });
    socket.on('disconnect', function()
    {
        var broadcastMessage = userName + ' has left the zone.';
        io.sockets.send(broadcastMessage);
    });
});
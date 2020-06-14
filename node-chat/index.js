const http = require("http");
const server = http.Server();
const socket = require("socket.io");
const Redis = require("ioredis");
const redis = new Redis();
redis.get("foo", function (err, data) {
  console.log(err, data);
});
server.listen(process.env.PORT || 5000);

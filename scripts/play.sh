#/bin/bash
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{ "jsonrpc": "2.0", "method": "Player.Open", "params": { "item": { "movieid": '$1' } }, "id": "1" }' http://a:a@192.168.2.11:80/jsonrpc

echo $1


cd /Users/praky/fabric-dev-servers
./stopfabric.sh
./teardownFabric.sh
./teardownAllDocker.sh
1
./downloadfabric.sh
./startfabric.sh
./createPeerAdminCard.sh 
cd item-auction/
composer archive create -t dir -n .
composer network install --card PeerAdmin@hlfv1 --archiveFile item-auction@0.0.1.bna
composer network start --networkName item-auction --networkVersion 0.0.1 --card PeerAdmin@hlfv1 --networkAdmin admin --networkAdminEnrollSecret adminpw --file networkadmin.card
composer card import -f networkadmin.card
composer network ping --card admin@item-auction
composer-rest-server
cd /Users/praky/fabric-dev-servers/item-auction 
yo hyperledger-composer:angular
cd item-app
npm start

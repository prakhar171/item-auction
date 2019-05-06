Github Link: https://github.com/prakhar171/item-auction

Install Hyperledger Composer prerequisities and other tools as described on https://hyperledger.github.io/composer/latest/installing/installing-index

Then follow the following instructions:

cd /Users/[USER-NAME]/fabric-dev-servers
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

Install a suitable XAMPP/WAMP/MAMP server and switch on Apache.

Place the decent-auction folder in the htdocs folder of your installation.

In the functions/functions.php file, replace base_url with your localhost url and access_token with your REST Server Access Token available at localhost:3000.

Navigate to localhost/[ht-docs-path]/decent-auction

Voila!
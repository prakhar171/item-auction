echo  "GITHUB REPOSITORY http://www.github.com/prakhar171/item-auction"

# How to Set up the network on your local host along with a rest server

echo "Install the prereqs from https://hyperledger.github.io/composer/latest/installing/installing-prereqs"

echo "Perform EVERY step mentioned on https://hyperledger.github.io/composer/latest/installing/development-tools"

git clone https://www.github.com/prakhar171/item-auction

cd item-auction/

composer archive create -t dir -n .

composer network install --card PeerAdmin@hlfv1 --archiveFile tutorial-network@0.0.1.bna

composer network start --networkName tutorial-network --networkVersion 0.0.1 --card PeerAdmin@hlfv1 --networkAdmin admin --networkAdminEnrollSecret adminpw --file networkadmin.card

composer card import -f networkadmin.card

composer network ping --card admin@tutorial-network

composer-rest-server

# Use the server using network admin card: admin@tutorial-network
# Other than web sockets and explorer, choose all options as N

echo 'Install a suitable XAMPP/WAMP/MAMP server and switch on Apache.'

echo 'Place the decent-auction folder in the htdocs folder of your installation.'

echo 'In the functions/functions.php file, replace base_url with your localhost url and access_token with your REST Server Access Token available at localhost:3000.'

echo 'Navigate to localhost/[ht-docs-path]/decent-auction'

/*
CryptoJS v3.1.2
code.google.com/p/crypto-js
(c) 2009-2013 by Jeff Mott. All rights reserved.
code.google.com/p/crypto-js/wiki/License
*/
/*
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* global getAssetRegistry getParticipantRegistry */

/**
 * Close the bidding for a item listing and choose the
 * highest bid that is over the asking price
 * @param {org.example.mynetwork.CloseBidding} closeBidding - the closeBidding transaction
 * @transaction
 */
async function closeBidding(closeBidding) {  // eslint-disable-line no-unused-vars

    const listing = closeBidding.listing;
    if (listing.state !== 'FOR_SALE') {
        throw new Error('Listing is not FOR SALE');
    }

    listing.state = 'BIDDING_CLOSED';

    let id=listing.listingId;

    const itemListingRegistry = await getAssetRegistry('org.example.mynetwork.ItemListing');
    await itemListingRegistry.update(listing);



}

/**
 * End the auction for a item listing and choose the
 * highest bid that is over the asking price
 * @param {org.example.mynetwork.endAuction} endAuction - the endAuction transaction
 * @transaction
 */
async function endAuction(endAuction) {  // eslint-disable-line no-unused-vars
    const listing = endAuction.listing;
    if (listing.state !== 'BIDDING_CLOSED') {
        throw new Error('Listing is not closed for bidding.');
    }
    // by default we mark the listing as RESERVE_NOT_MET
    listing.state = 'RESERVE_NOT_MET';
    
    let highestBid = 0;
      let highestBidder=null;
      let secondBid=0;
    let buyer = null;
    let seller = null;
    if (listing.offers && listing.offers.length > 0) {
          
          for(i=0; i < listing.offers.length ; i++) {
              let offer=listing.offers[i];
            let mem= offer.member;
            let bid= offer.bidPrice;
              let j;
              for(j=0; j < listing.EncBids.length ; j++) {
                let RevBid=listing.EncBids[j];
                  
                if (RevBid.member==mem){
                    
                      
                var key = RevBid.EncKey;
                
                  
                let actualBid1 = CryptoJS.AES.decrypt(bid, key);
                var ac= actualBid1.toString(CryptoJS.enc.Utf8);
                let actualBid= parseFloat(ac);
                
                console.log("Key from RSA: "+key);
                 
                console.log("Bid string from RSA: "+ac);
                  
                if(actualBid>=highestBid){
                  if (highestBidder !=null){
                  highestBidder.balance += highestBid;
                    const userRegistry = await getParticipantRegistry('org.example.mynetwork.Member');
                await userRegistry.update(highestBidder);
                    console.log("Highest bidder"+highestBidder);
                  }
                secondBid = highestBid;
                highestBid=actualBid;
                highestBidder=mem;
                  console.log("Highest bidder outside: "+highestBidder);
                
                }
                else if(actualBid>=secondBid){
                    mem.balance+=actualBid;
                    secondBid=actualBid;
                  const userRegistry = await getParticipantRegistry('org.example.mynetwork.Member');
                await userRegistry.update(mem);
                }

                else{
                    mem.balance+=actualBid
                  const userRegistry = await getParticipantRegistry('org.example.mynetwork.Member');
                await userRegistry.update(mem);
                  
                }
                
                }

            }
       
        }
      
    }
      // mark the listing as SOLD
    listing.state = 'SOLD';
    buyer = highestBidder; //buyer is the member with highest bid
    seller = listing.item.owner;
    // update the balance of the seller to the second highest bid
    console.log('#### seller balance before: ' + seller.balance);
    seller.balance += secondBid;
    console.log('#### seller balance after: ' + seller.balance);

    //refund the difference between highest and second highest bids to the highest bidder
    buyer.balance += (highestBid-secondBid) ;

    // transfer the item to the buyer
    listing.item.owner = buyer;
    // clear the offers



    
   

    if (highestBid) {
        // save the item
        const itemRegistry = await getAssetRegistry('org.example.mynetwork.Item');
        await itemRegistry.update(listing.item);
    }

    // save the item listing
    const itemListingRegistry = await getAssetRegistry('org.example.mynetwork.ItemListing');
    await itemListingRegistry.update(listing);

    if (listing.state === 'SOLD') {
        // save the buyer
        const userRegistry = await getParticipantRegistry('org.example.mynetwork.Member');
        await userRegistry.updateAll([buyer, seller]);
    }
}

/**
 * Add Money
 * @param {org.example.mynetwork.AddMoney} addmoney - the money
 * @transaction
 */
async function AddMoney(addmoney) {  // eslint-disable-line no-unused-vars
  
  console.log('Old Balance:'+addmoney.member.balance);
  addmoney.member.balance += addmoney.amount;
  console.log('New Balance:'+addmoney.member.balance);
  
  const userRegistry = await getParticipantRegistry('org.example.mynetwork.Member');
  await userRegistry.update(addmoney.member);
  

}


/**
 * Make an Offer for a ItemListing
 * @param {org.example.mynetwork.Offer} offer - the offer
 * @transaction
 */
async function makeOffer(offer) {  // eslint-disable-line no-unused-vars
    let listing=offer.listing;
    //let bidder=null;
    //bidder = offer.member; //current bidder
    //let bid=null;
    //bid = offer.bidPrice; //bid price
    let currentdate=new Date();
  
    let bidend= new Date(listing.enddate);
  
    
  
    if(currentdate>bidend){
      throw new Error('Bidding Period is over. Better luck next time!');
        return;
    }
    
    
  
    if (listing.state !== 'FOR_SALE') {
        throw new Error('Listing is not FOR SALE');
    }
    if (!listing.offers) {
        listing.offers = [];
    }

    bid= parseFloat(offer.bidPrice);
  
    

    currentbid=offer.bidPrice;

    listing.offers.push(offer);
  
    const userRegistry = await getParticipantRegistry('org.example.mynetwork.Member');
    await userRegistry.update(offer.member);
    
    // save the item listing
    const itemListingRegistry = await getAssetRegistry('org.example.mynetwork.ItemListing');
    await itemListingRegistry.update(listing);
    
    
}


/**
 * Send encrypted bid for a item listing and add to item listing
 * @param {org.example.mynetwork.RevealBid} RevealBid - the closeBidding transaction
 * @transaction
 */
async function RevealBid(RevealBid) {  // eslint-disable-line no-unused-vars

    const listing = RevealBid.listing;
    if (listing.state !== 'BIDDING_CLOSED') {
        throw new Error('Listing is not closed for bidding.');
    }

    let mem= RevealBid.member;

    let key=mem.key;

    RevealBid.EncKey=key;
    listing.EncBids.push(RevealBid);

    const itemListingRegistry = await getAssetRegistry('org.example.mynetwork.ItemListing');
    await itemListingRegistry.update(listing);

}
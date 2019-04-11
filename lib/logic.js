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

async function closeBidding(closeBidding) {  // eslint-disable-line no-unused-vars
    const listing = closeBidding.listing;
    if (listing.state !== 'FOR_SALE') {
        throw new Error('Listing is not FOR SALE');
    }
    // by default we mark the listing as RESERVE_NOT_MET
    listing.state = 'RESERVE_NOT_MET';
    let highestOffer = null;
    let buyer = null;
    let seller = null;
    if (listing.offers && listing.offers.length > 0) {
        // sort the bids by bidPrice
        listing.offers.sort(function(a, b) {
            return (b.bidPrice - a.bidPrice);
        });
        highestOffer = listing.offers[0];
        if (highestOffer.bidPrice >= listing.reservePrice) {
            // mark the listing as SOLD
            listing.state = 'SOLD';
            buyer = highestOffer.member;
            seller = listing.item.owner;
            // update the balance of the seller
            console.log('#### seller balance before: ' + seller.balance);
            seller.balance += highestOffer.bidPrice;
            console.log('#### seller balance after: ' + seller.balance);
            // transfer the item to the buyer
            listing.item.owner = buyer;
            // clear the offers

        }
        let i;
        for(i=1; i < listing.offers.length ; i++) {
            let offer=listing.offers[i];
            let mem= offer.member;
            let bid= offer.bidPrice;
            mem.balance+=bid;
            const userRegistry = await getParticipantRegistry('org.acme.item.auction.Member');
            await userRegistry.update(offer.member);
        }
        listing.offers = null;
    }

    if (highestOffer) {
        // save the item
        const itemRegistry = await getAssetRegistry('org.acme.item.auction.Item');
        await itemRegistry.update(listing.item);
    }

    // save the item listing
    const itemListingRegistry = await getAssetRegistry('org.acme.item.auction.ItemListing');
    await itemListingRegistry.update(listing);

    if (listing.state === 'SOLD') {
        // save the buyer
        const userRegistry = await getParticipantRegistry('org.acme.item.auction.Member');
        await userRegistry.updateAll([buyer, seller]);
    }
}

/**
 * Add Money
 * @param {org.acme.item.auction.AddMoney} addmoney - the money
 * @transaction
 */
async function AddMoney(addmoney) {  // eslint-disable-line no-unused-vars
  
  console.log('Old Balance:'+addmoney.member.balance);
  addmoney.member.balance += addmoney.amount;
  console.log('New Balance:'+addmoney.member.balance);
  
  const userRegistry = await getParticipantRegistry('org.acme.item.auction.Member');
  await userRegistry.update(addmoney.member);
  

}


/**
 * Make an Offer for a ItemListing
 * @param {org.acme.item.auction.Offer} offer - the offer
 * @transaction
 */
async function makeOffer(offer) {  // eslint-disable-line no-unused-vars
    let listing=offer.listing;
    //let bidder=null;
    //bidder = offer.member; //current bidder
    //let bid=null;
    //bid = offer.bidPrice; //bid price
  
    if (listing.state !== 'FOR_SALE') {
        throw new Error('Listing is not FOR SALE');
    }
    if (!listing.offers) {
        listing.offers = [];
    }
    listing.offers.push(offer);
    console.log('Member:'+ offer.member.balance);
    offer.member.balance -= offer.bidPrice; //new balance after bid. will be refunded if bid fails
    console.log('Member:'+ offer.member.balance);
  
    const userRegistry = await getParticipantRegistry('org.acme.item.auction.Member');
    await userRegistry.update(offer.member);
    
    // save the item listing
    const itemListingRegistry = await getAssetRegistry('org.acme.item.auction.ItemListing');
    await itemListingRegistry.update(listing);
}
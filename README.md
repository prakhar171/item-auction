# Item Auction Network

> This is an interactive, distributed, item auction demo. List assets for sale (setting a reserve price), and watch as assets that have met their reserve price are automatically transferred to the highest bidder at the end of the auction.

**Participants:**
`Harsh Karamchandani` `Prakhar Jain`

This business network defines:

**Participants:**
`Member`

**Assets:**
`Item` `ItemListing`

**Transactions:**
`Offer` `CloseBidding` `AddMoney` 

The `makeOffer` function is called when an `Offer` transaction is submitted. The logic simply checks that the listing for the offer is still for sale, and then adds the offer to the listing, and then updates the offers in the `ItemListing` asset registry.

The `closeBidding` function is called when a `CloseBidding` transaction is submitted for processing. The logic checks that the listing is still for sale, sorts the offers by bid price, and then if the reserve has been met, transfers the ownership of the item associated with the listing to the highest bidder. Money is transferred from the buyer's account to the seller's account, and then all the modified assets are updated in their respective registries.

To test this Business Network Definition in the **Test** tab:


In the `Member` participant registry, create two participants.

```
{
  "$class": "org.acme.item.auction.Member",
  "balance": 5000,
  "email": "memberA@acme.org",
  "firstName": "Amy",
  "lastName": "Williams"
}
```

```
{
  "$class": "org.acme.item.auction.Member",
  "balance": 5000,
  "email": "memberB@acme.org",
  "firstName": "Billy",
  "lastName": "Thompson"
}
```

In the `Item` asset registry, create a new asset of a item owned by `memberA@acme.org`.

```
{
  "$class": "org.acme.item.auction.Item",
  "vin": "vin:1234",
  "owner": "resource:org.acme.item.auction.Member#memberA@acme.org"
}
```

In the `ItemListing` asset registry, create a item listing for car `vin:1234`.

```
{
  "$class": "org.acme.item.auction.ItemListing",
  "listingId": "listingId:ABCD",
  "reservePrice": 3500,
  "description": "TV",
  "state": "FOR_SALE",
  "item": "resource:org.acme.item.auction.Item#vin:1234"
}
```

You've just listed a TV for auction, with a reserve price of 3500!

As soon as a `ItemListing` has been created (and is in the `FOR_SALE` state) participants can submit `Offer` transactions to bid on an item listing.

Submit an `Offer` transaction, by submitting a transaction and selecting `Offer` from the dropdown.

```
{
  "$class": "org.acme.item.auction.Offer",
  "bidPrice": 2000,
  "listing": "resource:org.acme.item.auction.ItemListing#listingId:ABCD",
  "member": "resource:org.acme.item.auction.Member#memberA@acme.org"
}
```

```
{
  "$class": "org.acme.item.auction.Offer",
  "bidPrice": 3500,
  "listing": "resource:org.acme.item.auction.ItemListing#listingId:ABCD",
  "member": "resource:org.acme.item.auction.Member#memberB@acme.org"
}
```

To end the auction submit a `CloseBidding` transaction for the listing.

```
{
  "$class": "org.acme.item.auction.CloseBidding",
  "listing": "resource:org.acme.item.auction.ItemListing#listingId:ABCD"
}
```

To add balance submit a `AddMoney` transaction for the listing.

```
{
  "$class": "org.acme.item.auction.AddMoney",
  "amount": 0,
  "member": "resource:org.acme.item.auction.Member#memberB@acme.org"
}
```

This simply indicates that the auction for `listingId:ABCD` is now closed, triggering the `closeBidding` function that was described above.

To see the Item was sold you need to click on the `Item` asset registry to check the owner of the car. The reserve price was met by owner `memberB@acme.org` so you should see the owner of the vehicle is now `memberB@acme.org`.

If you check the state of the ItemListing with `listingId:ABCD` is should be `SOLD`.

If you click on the `Member` asset registry you can check the balance of each Member. You should see that the balance of the buyer `memberB@acme.org` has been debited by `3500`, whilst the balance of the seller `memberA@acme.org` has been credited with `3500`.

Congratulations!

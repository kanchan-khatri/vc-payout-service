Payout For Sold Items
====
## Entities
1. Item
As described in the problem statement, this entity is the unit to be sold.

2. Seller
This defines the seller of the Item to be sold

3. Payout
For every seller, Sold Items amount is settled to the seller account and a payout record is created.

4. PayoutItems
For every payout, list of payout items are being saved in PayoutItem

5. TransactionConfig
For a given currency, max amount of transaction can be configured.

## APIs
1. POST /api/createPayout
This api expects sold items as input in request body and generate the payout records for every seller and currency.
This will make use of max transaction amount configuration for every currency to create minimum transactions required for every seller and currency.


Sample Request Body:
```json
	{"soldItems":[
		{"item_id":1, "amount": 110, "currency": "us"},
		{"item_id":2, "amount": 100, "currency": "eur", "seller_id": 1},
		{"item_id":3, "amount": 105, "currency": "gbp", "seller_id": 1},
		{"item_id":4, "amount": 110, "currency": "usd", "seller_id": 2},
		{"item_id":5, "amount": 80, "currency": "EUR", "seller_id": 5},
		{"item_id":6, "amount": 20, "currency": "gbp", "seller_id": 2},
		{"item_id":7, "amount": 10, "currency": "usd", "seller_id": 2},
		{"item_id":8, "amount": 50, "currency": "eur", "seller_id": 4},
		{"item_id":9, "amount": 20, "currency": "gbp", "seller_id": 3},
		{"item_id":10, "amount": 70, "currency": "gbp", "seller_id": 9},
		{"item_id":11, "amount": 20, "currency": "gbp", "seller_id": 9},
		{"item_id":12, "amount": 10, "currency": "GBP", "seller_id": 9},
		{"item_id":13, "amount": 120, "currency": "USD", "seller_id": 1},
		{"item_id":14, "amount": 102, "currency": "usd", "seller_id": 1}
	]}	
```

Response Body:

On Failure:
```json
	{"success":false,"error":<error-json-list>}

    {
        "success":false,
        "error":{
            "soldItems.0.currency":
                ["The soldItems.0.currency must be 3 characters.","The selected soldItems.0.currency is invalid."],
            "soldItems.0.seller_id":["The soldItems.0.seller_id field is required."]
         }
     }
```
On Success
```json
	{"success":true,"data":<list-payout-records>}
```

2. GET /api/payouts
Lists all payouts   

## Solution Focus
Main Focus while impletementing this solution is to 
1. solve the problem defined
2. ensure best oop practises are followed.
3. each function is reusable and well defined and returning only one datatype
4. Handle as many exceptions or edge cases
5. Treat this service as a down stream service where data is passed on from say 'payments-service' to communicate sold items records and hence, validations for payouts will be limited to create the payouts
6. Transaction Inserts to avoid data pollution
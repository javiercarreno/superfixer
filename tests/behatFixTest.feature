               Feature: Query for searching orders by some of their fields

Background:
Given store STORE1 is configured
And store STORE2 is configured
And the source WAREHOUSE1 exists
And I have the following customers:
| id | name      | store  | address  |
  | 1  | CUSTOMER1 | STORE1 | address1 |
 | 2  | CUSTOMER2 | STORE2 | address2 |
And I have the following orders:
    | id | customer_id | customer_store_id | order_status | origin_date       | payment_method | sales_channel |
   | 1  | CUSTOMER1   | STORE1            | NEW          | 28-07-16 15:00:00 | CC             | STORE1        |
  | 2  | CUSTOMER2   | STORE2            | LOGISTICS    | 27-07-16 15:00:00 | ZEROPAY        | STORE2        |
And I have the following lines:
  | id | order_id | store_id | sku   | product_name | product_type | source_id  | shipping_address | shipping_person |
   | 1  | 1        | STORE1   | MH-01 | PRODUCT1     | PHYSICAL     | WAREHOUSE1 | address1         | CUSTOMER1       |
    | 2  | 2        | STORE2   | MH-02 | PRODUCT2     | BUNDLE       | WAREHOUSE1 | address2         | CUSTOMER2       |
And I have the following returns:
 | id | order_id | rma  | status    | source_id  | order_store_id |
  | 1  | 1        | RMA1 | REQUESTED | WAREHOUSE1 | STORE1         |
| 2  | 2        | RMA2 | APPROVED  | WAREHOUSE1 | STORE2         |
And I have the following return items:
     | id | post_sale_id | order_id | order_item_id | line | source_id  | order_store_id | reason  |
   | 1  | 1            | 1        | 1             | 1    | WAREHOUSE1 | STORE1         | REASON1 |
 | 2  | 2            | 2        | 1             | 1    | WAREHOUSE1 | STORE2         | REASON2 |

Scenario: I search for orders by sales_channel
When I try to search for returns with:
| field         | value  |
| sales_channel | STORE2 |
Then the query will return a collection with 1 rows
And the returned return is the one with order_id 2

Scenario: I search for orders by rma
When I try to search for returns with:
| field | value |
| rma   | RMA3  |
Then the query will return a collection with 0 rows

Scenario: I search for orders by sku
When I try to search for returns with:
| field | value |
| sku   | MH-01 |
Then the query will return a collection with 1 rows
And the returned return is the one with order_id 1

Scenario: I search for orders by status
When I try to search for returns with:
| field  | value    |
| status | APPROVED |
Then the query will return a collection with 1 rows
And the returned return is the one with order_id 2

Scenario: I search for returns by source_id
When I try to search for returns with:
| field     | value      |
| source_id | WAREHOUSE1 |
Then the query will return a collection with 2 rows

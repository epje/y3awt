
# Year 3 - Advanced Web Technologies

## Project Overview
**AWT Furnishing** is a simple product catalog with features such as client registration & login, product cart and purchases.
It was created using the PHP framework [CodeIgniter4](https://codeigniter.com/) which is based upon the MVC design pattern.

    This code is absolutely NOT production ready, and should not be treated as such.

## The Database
A total of 7 tables are required, and are summarised below:
* **Cart** `(id, client_id, ...)`
* **CartProduct** `(id, cart_id, product_id, quantity, ...)`
* **Client** `(id, first_name, last_name, title, phone, email, password, staff, ...)`
* **Product** `(id, name, description, price, category, img, rating, ...)`
* **ProductPurchase** `(id, purchase_id, product_id, quantity, ...)`
* **Purchase** `(id, client_id, status, grand_total, ...)`

CodeIgniter also uses `created_at`, `updated_at` & `deleted_at`. These are signified by **`...`** above.
> Note: The schema for this database is provided in **awt-schema.sql**.


## Functionality
A client can browse the catalog

## Caveats
A number of issues have been identified - check repository issues for further information.



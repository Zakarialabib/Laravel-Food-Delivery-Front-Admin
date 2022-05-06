# Food Delivery Admin Panel and Apps 

This project is a delivery management platform

Admin : Web App
Customer : Web App and Native app
Restaurant : Web App and Native app
Deliveryman : Native app


## RUN THE PROJECT

in odrer to install the project locally, run the commands below :

Run 'composer install' to install the PHP dependencies

Run 'npm install' to install Node dependecies

cp .env.example .env

php artisan migrate --seed

## Tasks coming 

- Home page search ( Fetch localisation to serve available restarant in client zone )

- Restaurant List Needs Filters : -map localisation in client zone
                                  -food categories
                                  -popular

- Restaurant Page Needs Filters : -price/high low
                                  -food categories
                                  -popular

- Fooditems in restaurant page needs pagination and buy button

- buy button will lead to checkout if users is auth else registration page

- Translation files (40000+ words needs translation)
 
## Tasks Done 

- App layout ( Header - Footer - Styles - Scripts)

- Translation strings are prepared

- Restaurants list and detail page for each one of them 

- Customer Authentification 

- Account page (account details - change password - Orders - Address )


**Application description:**
- Authenticated users to go through a loan application.
- User can create loans (All the loans will be assumed to have a “weekly” repayment frequency)
- After the loan is approved, the user must be able to submit the weekly loan repayments.
  (Don't need to check if the dates are correct but will just set the weekly amount to be repaid.)
----
**Requirement to run application**

Laravel 8 \
PHP >= 7.3 \
MySql >= 5.7 \
Composer
----
**Install Application:** \
Clone source from Git: `git clone https://github.com/quanvanpk/laravel-8-crud.git` \
`cd laravel-8-crud`

Step 1: Run command to install packages\
`composer install`

Step 2: Run command to create .env file\
`cp .env.example .env`

Change configs on .env file: \
Example: (Using MySQL)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3366
DB_DATABASE=laravel-8-crud
DB_USERNAME=root
DB_PASSWORD=deadface
```
Step 3: Generate app key `php artisan key:generate`

Step 4: Migrate database `php artisan migrate`

Step 5: Install passport package `php artisan passport:install`

- Create a personal access client `php artisan passport:client --personal`

Step 6: Create test user `php artisan db:seed` \
User info: `miniaspire@gmail.com` password `123456`

Step 7: Run application `php artisan serve --port=8000`

-----
**Run Test** `php artisan test`

-----
**Set up Postman**  
Option 1: Get collection json file in the source code\
`postman/mini_aspire.postman_collection.json`

Option 2: Import from this link
`https://www.postman.com/collections/a773853fbc726aa67460`

P/s: Please remember to set environment variable for `{{base_url}}`
or you can set manually `http://127.0.0.1:8000`
----
API List:

| Name      | Method | Param Example                                                              | Note |Endpoint |
| ----------- | ----------- |----------------------------------------------------------------------------| ----------- |----------- |
|   Register User    | POST| {"name": "Quan Van","email": "quanvan1995@gmail.com","password": "123456"} | | /api/v1/auth/register|
|   Login    | POST| {"email": "test01@gmail.com","password": "123456","remember_me": 1}        | |/api/v1/auth/login|
|   Logout    | POST|                                                                            | | /api/v1/auth/logout|
|   Create Loan    | POST| {"amount": 2000,"repayment_frequency": "Week"}                             | | /api/v1/loans|
|   Get Loan Detail    | GET |                                                                            | | /api/v1/loans/{loanId}
|   Update Loan    | PUT | {"repayment_frequency": "Week","status": "Cancelled"}                      | Status will be: Open, Approved, Completed, Cancelled  |/api/v1/loans/{loanId}|
|   Delete Loan    | DELETE |                                                                            | Using soft delete | /api/v1/loans/{loanId}|
|   Create Loan Repayment    | POST | {"loan_id": 4,"amount": 200,"note": "Weekly Repayment"}                    |  |  /api/v1/repayments|
|   Get Loan Repayment Detail    | GET |                                                                            | | /api/v1/repayments/{loanRepaymentId}|
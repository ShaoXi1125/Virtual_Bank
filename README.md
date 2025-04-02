🚀 Virtual Bank System

A simple virtual banking system built with Laravel, supporting client management, account operations, card transactions, and online transfers.

📝 Features

Manage clients, accounts, and cards

Deposit, withdraw, and transfer funds

Card-based transactions

Online banking functionality with FPX-like payment gateway simulation

🛠️ Installation

Clone the repository:

git clone https://github.com/your-repo/virtual-bank.git

Navigate to the project directory:

cd virtual-bank

Install dependencies:

composer install
npm install

Create environment file:

cp .env.example .env

Generate application key:

php artisan key:generate

Configure database in .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=virtual_bank
DB_USERNAME=root
DB_PASSWORD=

Run migrations and seed database:

php artisan migrate --seed

Start the server:

php artisan serve

🎮 API Endpoints

Client Routes

GET /api/clients - List all clients

POST /api/clients - Create a client

GET /api/clients/{id} - Get client by ID

Account Routes

POST /api/accounts - Create an account

GET /api/accounts/{id}/balance - Check balance

POST /api/accounts/{id}/deposit - Deposit funds

POST /api/accounts/{id}/withdraw - Withdraw funds

Card Routes

POST /api/clients/{client_id}/cards - Create a card

GET /api/clients/{client_id}/cards - List client’s cards

POST /api/cards/{card_id}/transfer - Transfer using card

Transaction Routes

POST /api/transfer - Account to account transfer

GET /api/transactions/{account_id} - Transaction history

✅ Testing

Run tests using PHPUnit:

php artisan test

📜 License

This project is licensed under the MIT License.


# SmartInventory

A simple and efficient web application for managing the stock of a small store or local business. Built with the Laravel framework, SmartInventory allows you to organize products, suppliers, categories, customers, and orders in one central place, without the complexity of user authentication.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-FF7043?style=for-the-badge&logo=laravel&logoColor=white)

## Features

-   **Product Management**: Full CRUD (Create, Read, Update, Delete) for products, including tracking stock quantity, purchase price, and selling price.
-   **Categorization**: Organize products into categories for better management.
-   **Supplier Tracking**: Keep a record of your suppliers and the products they provide.
-   **Customer Management**: Store information about your customers, including their order history.
-   **Order Processing**: Create and manage customer orders. The system automatically calculates the total and adjusts product stock.
-   **PDF Invoice Generation**: Export orders to professional-looking PDF invoices with a single click.
-   **Data Integrity**: Foreign key constraints and soft deletes are used to maintain data consistency.
-   **Responsive Design**: The user interface is built with Bootstrap, making it accessible on both desktop and mobile devices.

## Technologies Used

-   **Backend**: Laravel 10.x, PHP 8.2+
-   **Frontend**: Blade Templating Engine, Bootstrap 5, Font Awesome
-   **Database**: MySQL 8.0+
-   **PDF Generation**: `barryvdh/laravel-dompdf`

## Installation

Follow these steps to get a copy of the project up and running on your local machine.

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   MySQL or MariaDB
-   A web server like Apache or Nginx (or use `php artisan serve`)

### Setup

1.  **Clone the repository**
    ```bash
    git clone https://github.com/your-username/smart-inventory.git
    cd smart-inventory
    ```

2.  **Install dependencies**
    ```bash
    composer install
    ```

3.  **Environment setup**
    -   Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    -   Generate a new application key:
        ```bash
        php artisan key:generate
        ```

4.  **Configure the database**
    -   Create a new MySQL database for the project (e.g., `smart_inventory_db`).
    -   Open the `.env` file and update the following lines with your database credentials:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=smart_inventory_db
        DB_USERNAME=your_mysql_username
        DB_PASSWORD=your_mysql_password
        ```

5.  **Run the migrations**
    This command will create all the necessary tables in your database.
    ```bash
    php artisan migrate
    ```

6.  **(Optional) Seed the database with fake data**
    If you want to populate your database with sample products, categories, etc., you can run the seeders.
    ```bash
    php artisan db:seed
    ```
    *(Note: You would need to create the Seeder files for this to work).*

7.  **Start the development server**
    ```bash
    php artisan serve
    ```

    Now you can access the application in your browser at `http://127.0.0.1:8000`.

## Usage

Once the application is running, you can start managing your inventory:

1.  **Categories & Suppliers**: It's best to start by creating the categories and suppliers you'll be working with.
2.  **Products**: Add your products, assigning them to a category and a supplier.
3.  **Customers**: Add your customer list.
4.  **Orders**: Create new orders for your customers. Select products, and the system will handle the rest.
5.  **Invoices**: From the order details page, click "Export to PDF" to download an invoice.


## Contributing

This is a portfolio project, but contributions are welcome! If you find a bug or have a suggestion for an improvement, please open an issue or submit a pull request.

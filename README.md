# 🎫 Ticket Management System

A comprehensive Ticket Management System built with PHP, Laravel, and Filament. This system allows users to create,
manage, and track tickets for various issues and departments.

## ✨ Features

- 🔐 User authentication and authorization
- 📝 Ticket creation and management
- 📍 Location and user association with tickets
- 🚦 Priority and status tracking
- 🗂️ Detailed ticket descriptions and categories
- 🔄 Automatic assignment of created_by and updated_by fields
- 🆔 Unique display ID generation for tickets and locations

## 🛠️ Technologies Used

- PHP
- Laravel
- Filament
- MySQL
- JavaScript
- NPM
- Composer

## 🚀 Installation

1. **Clone the repository:**
    ```sh
    git clone https://github.com/evanh1393/ticket-management-system.git
    cd ticket-management-system
    ```

2. **Install dependencies:**
    ```sh
    composer install
    npm install
    ```

3. **Set up the environment variables:**
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure the `.env` file** with your database and other settings.

5. **Run the migrations and seeders:**
    ```sh
    php artisan migrate --seed
    ```

6. **Start the development server:**
    ```sh
    php artisan serve
    ```

## 📖 Usage

- Access the application at `http://localhost:8000`.
- Log in with the seeded user credentials or register a new account.
- Create and manage tickets through the user interface.

## 🏷️ Models

### Location

- `title`: The name of the location.
- `address`: The street address of the location.
- `city`: The city where the location is situated.
- `state`: The state where the location is situated.
- `zip`: The postal code of the location.
- `brand`: The brand associated with the location.
- `display_id`: A unique identifier for the location.
- `phone`: The contact phone number for the location.

### Ticket

- `title`: The title of the ticket.
- `description`: A detailed description of the issue.
- `priority`: The priority level of the ticket (High, Medium, Low).
- `department`: The department responsible for handling the ticket.
- `location_id`: The ID of the location associated with the ticket.
- `display_id`: A unique identifier for the ticket.
- `category`: The category of the issue (e.g., Point of Sale, Internet).
- `sub_category`: A more specific sub-category of the issue.
- `assigned_to`: The ID of the user assigned to the ticket.
- `status`: The current status of the ticket (e.g., Open, Closed).
- `created_by`: The ID of the user who created the ticket.
- `updated_by`: The ID of the user who last updated the ticket.

## 🔗 Relationships

- A `Location` has many `Tickets`.
- A `Ticket` belongs to a `Location`.
- A `Ticket` has many `Actions`.
- A `Ticket` belongs to a `User` (creator and updater).

## 📜 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

Contributions are welcome! Please open an issue or submit a pull request for any changes.

## 📧 Contact

For any inquiries, please contact [evanh1393@gmail.com](mailto:yourname@example.com).

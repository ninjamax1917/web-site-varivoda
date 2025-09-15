# Laravel Application

This is a Laravel application designed to manage and display tools on a dedicated tools page.

## Project Structure

The project consists of the following main directories and files:

- **app/**: Contains the application logic.
  - **Http/**: Contains the HTTP-related classes.
    - **Controllers/**: Contains the controllers for handling requests.
      - **ToolsPageController.php**: Controller for the tools page.
      - **Controller.php**: Base controller class.
    - **Middleware/**: Contains middleware for request handling.

- **routes/**: Contains the route definitions for the application.
  - **web.php**: Defines the web routes.

- **resources/**: Contains the views and assets.
  - **views/**: Contains the Blade templates.
    - **tools_page/**: Contains the Blade template for the tools page.
      - **index.blade.php**: The view for the tools page.

- **composer.json**: The configuration file for Composer, listing the dependencies required for the application.

## Installation

1. Clone the repository.
2. Run `composer install` to install the dependencies.
3. Set up your environment variables in the `.env` file.
4. Run `php artisan migrate` to set up the database.
5. Start the server using `php artisan serve`.

## Usage

Access the tools page by navigating to `/tools` in your web browser after starting the server. The tools page will display the relevant information as defined in the `index.blade.php` view.
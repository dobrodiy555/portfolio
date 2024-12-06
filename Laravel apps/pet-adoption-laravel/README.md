This is my Laravel project - website for registering and viewing pets for adoption.

To run it, make sure you have Git and Composer installed on your system before proceeding:

Clone the Git Repository: Navigate to the directory where you want to store your Laravel project and run the following command to clone the Git repository:

_git clone <repository_url>_

Replace <repository_url> with the URL of the Git repository.

Change Directory: Change your working directory to the newly cloned project:

_cd <project_directory>_

Replace <project_directory> with the name of your project folder.

Install Dependencies: Laravel projects require various dependencies. Use Composer to install them:

_composer install_

If your project uses any packages that uses the npm libraries (like Laravel Breeze for authentication) then you should also run:

_npm install_

then:

_npm run dev_

or

_npm run build_

Create a .env File: Laravel uses a .env file to store environment-specific configurations. Copy the example .env file:

_cp .env.example .env_

or

manually rename your _.env.example_ to _.env_

then change the db name and configurations in .env file or create a database in your phpmyadmin according to this name:

_DB_DATABASE=mydbname_

Then, generate an application key:

_php artisan key:generate_

Configure the Database: Open the .env file and configure your database connection settings, including DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD. Save the changes.

Run Migrations : If the project uses a database, run migrations to create the necessary database tables:

_php artisan migrate_

(if needed) Seeders: You can also seed the database with initial data (if there are seeders defined):

_php artisan db:seed_

Start the Development Server: Run the built-in Laravel development server:

_php artisan serve_

By default, the server will run on http://localhost:8000.

Access Your Laravel Application: Open a web browser and navigate to the URL where your Laravel application is running (e.g., http://localhost:8000). You should see your Laravel project up and running.

Good Luck!

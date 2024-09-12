# Reel Project

### Installation

1. Clone the repository:

    ```bash
    https://github.com/virubhavsar/reel-project.git
    cd reel-project
    ```

2. Install project dependencies:

    ```bash
    composer install
    ```

### Database Setup

1. Create a new database:

    ```sql
    CREATE DATABASE reel_project;
    ```

2. Run migrations to set up the database tables:

    ```bash
    php artisan migrate
    ```

3. Seed the database with initial data (optional):

    ```bash
    php artisan db:seed
    ```

### Configuration

1. Copy the example environment file and create a new `.env` file:

    ```bash
    cp .env.example .env
    ```

2. Update the `.env` file with your database credentials:

    ```bash
    DB_DATABASE=reel_project
    DB_USERNAME=root
    DB_PASSWORD=
    ```

3. Generate an application key:

    ```bash
    php artisan key:generate
    ```

4. Install Passport and configure it:

    ```bash
    composer require laravel/passport
    php artisan passport:install
    ```

### Running the Application

1. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

2. Access the application in your browser:

    ```
    http://localhost:8000
    ```

### API Endpoints

#### User Authentication

##### Login

- **Method**: `POST`
- **URL**: `/api/login`
- **Body**:
  - `email`: (string) The email address of the user.
  - `password`: (string) The password of the user.
  - `remember_me`: (optional) Boolean to extend the token expiration.
- **Response**: JSON object containing `access_token`, `token_type`, and `expires_at`.

**User Info for Login:**
- **Email**: `john.doe@example.com`
- **Password**: `password`

#### Upload Reel

- **Method**: `POST`
- **URL**: `/api/reels`
- **Body**:
  - `title`: (string) The title of the reel.
  - `reel`: (file) The video file (MP4 format).
  - `thumbnail`: (optional) The thumbnail image for the reel.
- **Authentication**: Bearer token required.

#### Get Reels

- **Method**: `GET`
- **URL**: `/api/reels`
- **Response**: List of reels with URLs for video and thumbnail playback.
- **Authentication**: Bearer token required.



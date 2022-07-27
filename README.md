# Video service for YouTube and Vimeo 
# An easy-to-use REST API that provides you with information about your video


## Technologies
- Programing language: PHP
- Framework: Laravel 8.75

## Server Requirements

```
● PHP >= 7.3
● JSON PHP Extension

```


## Installation

 Install Composer Dependencies

```bash
composer install
```


##Configuration of the database  // SKIP THIS STEP - for now, this project does not need a database
Create a copy of your .env file

```bash
cp .env.example .env

*insert your database information (DB_PORT; DB_DATABASE; DB_USERNAME;DB_PASSWORD)
```
*insert your database information (DB_PORT; DB_DATABASE; DB_USERNAME;DB_PASSWORD)


Generate an app encryption key

```bash
php artisan key:generate
```
Run database migrations

```bash
php artisan migrate
```


## Usage
Get video info from a video URL

REST API

**POST** Get information about your video (YouTube | Vimeo)
```bash
URL: {{url}}/api/video/info
Content-Type: application/json
BODY raw: 
{
	"video_url":"string"

}
```


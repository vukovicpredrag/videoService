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


##Configuration of the database  // <b>SKIP THIS STEP</b> - for now, this project does not need a database
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

Response - example:
{
    "success": true,
    "message": "Video information.",
    "data": {
        "author": "Chris Luno",
        "title": "berlin rooftop melodic house mix",
        "thumbnail_url": "https://i.ytimg.com/vi/SioOoI7YQtI/hqdefault.jpg"
    }
}

```

## What else could be done

● Expand respnse, add more information. <br />
● Provide support for other video platforms. <br />
● For a more user-friendly testing environment, create a fornted part (input for video URL with API response)<br />
● Crate DB and store API respnse; <br />
● Platform for data handling (Search by title, author, etc...);


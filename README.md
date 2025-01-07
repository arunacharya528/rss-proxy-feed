# RSS Proxy Feed
This implementation retrieves feeds from various news sources and presents them in RSS format. At present, the news is exclusively sourced from the [Guardian API](https://open-platform.theguardian.com/documentation/)

### What it does
1. Fetch news from provided API.
2. Store them in cache for specified amount of time(default is 10 minutes).
3. Return the stored news in [RSS](https://cyber.harvard.edu/rss/rss.html) format.
4. Log all the request and response using Laravel's in built logger.

### Technologies Used
- PHP 8.2
- Composer 2.8.2
- Laravel 11.3
- Docker 27.4.0
- Docker compose 2.31
- Redis

## Instructions to setup
Run the following code

```
git clone https://github.com/arunacharya528/rss-proxy-feed

cd rss-proxy-feed

composer i

cat .env.example > .env

php artisan key:generate

docker-compose up

```

### Environment Variables

To use [Guardian's API](https://open-platform.theguardian.com/access/), register and get access key. Paste the key in `.env`

```
GUARDIAN_API_KEY=<key>
```

To update cache invalidation period set this in `.env`
```
NEWS_CACHE_INVALIDATION_IN_MINUTES=<desired duration in minutes>
```
### How to use
- Visit http://localhost:8000/api/v1/{your-preferred-section} example http://localhost:8000/api/v1/movie. 8000 being the port the application is currently served.
- Visit http://localhost:8000/log-viewer to view all the logged request and response.
- Run `./vendor/bin/sail artisan test` to run all the written test cases.

## Todo
- Mock cache testing

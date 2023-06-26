## News Aggregator API

GraphQL API for News aggregation from multiple sources with option for user preferences

## Requirements
- [The Guardian](https://open-platform.theguardian.com/documentation/) API Key
- [NewsAPI.org](https://newsapi.org/) API Key
- [NYTimes ](https://developer.nytimes.com/docs/timeswire-product/1/routes/content/section-list.json/get) API Key
- Docker desktop

## Installation

- Clone repository - `git clone git@github.com:richienabuk/news-aggregator-api.git`
- Run this command to setup project `docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  composer install --ignore-platform-reqs \`
- Add env values for `NYTIMES_API_KEY`, `NEWS_API_KEY`, `THE_GUARDIAN_API_KEY`
- Run command `make up` or `make sl` to run docker with logs
- To load the news articles from different APIs, run command `make cron` or call this route once: `/news/load`
- Visit route `/graphiql` on domain for documentation and playground
- Connect frontend app - [codebase](https://github.com/richienabuk/news-aggregator-reactjs-fe)

### Built by
- **[Imo-owo Nabuk](https://github.com/richienabuk)**

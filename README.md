# Test-app

A sample test repo.

## How to use
<ol>
  <li>Clone the repo to local</li>
  <li>Run <code>composer install</code></li>
  <li><code>Cp .env.example .env</code></li>
    <li>Set APP_URL to <code>APP_URL=http://test-app.test/</code></li>
  <li>Run <code>php artisan key:generate</code></li>
  <li><code>./vendor/bin/phpunit</code> to run tests</li>
</ol>

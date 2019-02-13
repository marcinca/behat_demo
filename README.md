# behat_demo

###There are a few sample features tested here:

1. ls.feature that - checks composer files exists
2. version.feature - tests API like version response is matching v1.0
3. pages.feature - HTTP Goutte based check for page content checks

###Usage:

1. Clone the repo into behat_demo direcotry and run `composer install` 
2. From `/behat_demo/public` directory run php standalone server: 
`/behat_demo/public $ sudo php -S localhost:80`
3. In order to test features with behat run `/vendor/behat/bin/behat`

You should see:
```
4 scenarios (4 passed)
11 steps (11 passed)
```
WIP

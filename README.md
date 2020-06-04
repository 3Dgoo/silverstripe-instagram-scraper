# Silverstripe Instagram scraper module

[![Build Status](https://travis-ci.org/3dgoo/silverstripe-instagram-scraper.svg?branch=master)](https://travis-ci.org/3dgoo/silverstripe-instagram-scraper)
[![codecov.io](https://codecov.io/github/3dgoo/silverstripe-instagram-scraper/coverage.svg?branch=master)](https://codecov.io/gh/3dgoo/silverstripe-instagram-scraper?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/3dgoo/silverstripe-instagram-scraper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/3dgoo/silverstripe-instagram-scraper/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/3dgoo/silverstripe-instagram-scraper/v/stable)](https://packagist.org/packages/3dgoo/silverstripe-instagram-scraper)
[![Total Downloads](https://poser.pugx.org/3dgoo/silverstripe-instagram-scraper/downloads)](https://packagist.org/packages/3dgoo/silverstripe-instagram-scraper)
[![Latest Unstable Version](https://poser.pugx.org/3dgoo/silverstripe-instagram-scraper/v/unstable)](https://packagist.org/packages/3dgoo/silverstripe-instagram-scraper)
[![License](https://poser.pugx.org/3dgoo/silverstripe-instagram-scraper/license)](LICENSE)

An Instagram scraper module for Silverstripe.

## Requirements

* [Silverstripe Framework 4.x](https://github.com/silverstripe/silverstripe-framework)
* [Instagram PHP Scraper 0.9](https://github.com/postaddictme/instagram-php-scraper)
* [phpfastcache 7.1](https://github.com/PHPSocialNetwork/phpfastcache)

## Installation (with composer)

    $ composer require 3dgoo/silverstripe-instagram-scraper

## Usage

Import Instagram posts of a certain handle through running the following dev task:

    php vendor/silverstripe/framework/cli-script.php dev/tasks/import-instagram-posts handle=<handle>


Sometimes Instagram may require us to log in to fetch this data. This can be done by adding the following to our
`.env` file:

    INSTAGRAM_USERNAME="<username>"
    INSTAGRAM_PASSWORD="<password>"

Once our Instagram posts are imported we can display them with the following code:

**PageController.php**

    use X3dgoo\InstagramScraper\Model\InstagramPost;

    class PageController extends ContentController
    {
        public function InstagramPosts($limit = 10)
        {
            return InstagramPost::get()
                ->filter([
                    'Show' => true,
                ])
                ->limit($limit);
        }
    }

**Page.ss**

    <% if $InstagramPosts %>
    <div class="instagram-posts">
        <% loop $InstagramPosts %>
        <div class="instagram-post">
            <a href="{$Link}" target="_blank">
                <img src="{$ImageThumbnailURL}" alt="{$Caption.LimitWordCount(20).XML}" />
                <div class="caption">
                    $Caption.LimitWordCount(20)
                </div>
            </a>
        </div>
        <% end_loop %>
    </div>
    <% end_if %>

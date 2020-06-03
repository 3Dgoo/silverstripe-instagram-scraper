<?php

namespace X3dgoo\InstagramScraper\Admin;

use SilverStripe\Admin\ModelAdmin;
use X3dgoo\InstagramScraper\Model\InstagramPost;

class InstagramAdmin extends ModelAdmin
{
    private static $managed_models = [
        InstagramPost::class,
    ];

    private static $url_segment = 'instagram';
    private static $menu_title = 'Instagram';
    private static $menu_icon = '3dgoo/silverstripe-instagram-scraper:images/cms/instagram-admin.png';
}

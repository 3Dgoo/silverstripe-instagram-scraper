<?php

namespace X3dgoo\InstagramScraper\Model;

use SilverStripe\ORM\DataObject;

class InstagramPost extends DataObject
{
    private static $db = [
        'InstagramID' => 'Varchar(100)',
        'ShortCode' => 'Varchar(100)',
        'Title' => 'Text',
        'ImageURL' => 'Varchar(1024)',
        'ImageThumbnailURL' => 'Varchar(1024)',
        'Posted' => 'Datetime',
        'Active' => 'Boolean',
    ];

    private static $defaults = [
        'Active' => true,
    ];

    private static $singular_name = 'Instagram Post';
    private static $plural_name = 'Instagram Posts';
    private static $default_sort = 'Posted DESC';
    private static $table_name = 'InstagramPost';

    private static $summary_fields = [
        'ShortCode',
        'Title',
        'Posted',
    ];
}

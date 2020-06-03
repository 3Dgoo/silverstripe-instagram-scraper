<?php

namespace X3dgoo\InstagramScraper\Model;

use SilverStripe\ORM\DataObject;

class InstagramPost extends DataObject
{
    private static $db = [
        'InstagramID' => 'Varchar(100)',
        'ShortCode' => 'Varchar(100)',
        'Handle' => 'Varchar(100)',
        'Caption' => 'Text',
        'Link' => 'Text',
        'Type' => 'Varchar(100)',
        'ImageLowResolutionUrl' => 'Text',
        'ImageStandardResolutionUrl' => 'Text',
        'ImageHighResolutionUrl' => 'Text',
        'ImageThumbnailURL' => 'Text',
        'Posted' => 'Datetime',
        'LikesCount' => 'Int',
        'CommentsCount' => 'Int',
        'Show' => 'Boolean',
    ];

    private static $defaults = [
        'Show' => true,
    ];

    private static $singular_name = 'Instagram Post';
    private static $plural_name = 'Instagram Posts';
    private static $default_sort = 'Posted DESC';
    private static $table_name = 'InstagramPost';

    private static $summary_fields = [
        'ShortCode',
        'Handle',
        'Caption',
        'Posted',
    ];
}

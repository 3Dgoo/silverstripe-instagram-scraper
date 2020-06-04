<?php

namespace X3dgoo\InstagramScraper\Model;

use SilverStripe\ORM\DataObject;

/**
 * @property string $InstagramID
 * @property string $ShortCode
 * @property string $Handle
 * @property string $Caption
 * @property string $Link
 * @property string $Type
 * @property string $ImageLowResolutionUrl
 * @property string $ImageStandardResolutionUrl
 * @property string $ImageHighResolutionUrl
 * @property string $ImageThumbnailURL
 * @property mixed $Posted
 * @property int $LikesCount
 * @property int $CommentsCount
 * @property bool $Show
 */
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
        'ImageThumbnailURL',
        'ShortCode',
        'Handle',
        'Caption',
        'Posted',
        'Show.Nice',
    ];

    private static $field_labels = [
        'ImageThumbnailURL' => 'Image',
        'Show.Nice' => 'Show',
    ];
}

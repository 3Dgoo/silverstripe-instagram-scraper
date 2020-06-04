<?php

namespace X3dgoo\InstagramScraper\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\LiteralField;

/**
 * @property bool $Show
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
 */
class InstagramPost extends DataObject
{
    private static $db = [
        'Show' => 'Boolean',
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
        'Handle',
        'Caption.Summary',
        'Posted',
        'Show.Nice',
    ];

    private static $field_labels = [
        'ImageThumbnailURL' => 'Image',
        'Caption.Summary' => 'Caption',
        'Show.Nice' => 'Show',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($this->ImageThumbnailURL) {
            $fields->addFieldToTab(
                'Root.Main',
                LiteralField::create(
                    'ImagePreview',
                    '<div class="form-group field text">' .
                        '<label class="form__field-label">Image</label>' .
                        '<div class="form__field-holder">' .
                        '<img src="' . $this->ImageThumbnailURL . '" style="max-width: 200px;" />' .
                        '</div>' .
                        '</div>'
                ),
                'Show'
            );
        }

        return $fields;
    }
}

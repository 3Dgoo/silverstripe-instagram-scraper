<?php

namespace X3dgoo\InstagramScraper\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use X3dgoo\InstagramScraper\Model\InstagramPost;

class InstagramAdmin extends ModelAdmin
{
    private static $managed_models = [
        InstagramPost::class,
    ];

    private static $url_segment = 'instagram';
    private static $menu_title = 'Instagram';
    private static $menu_icon = '3dgoo/silverstripe-instagram-scraper:images/cms/instagram-admin.png';

    public function getEditForm($ID = null, $Fields = null)
    {
        $form = parent::getEditForm($ID, $Fields);
        $fields = $form->Fields();

        if ($this->modelClass == InstagramPost::class) {
            $gridField = $fields->fieldByName($this->sanitiseClassName(InstagramPost::class));

            if ($gridField) {
                $gridFieldConfig = $gridField->getConfig();

                $gridFieldConfig->getComponentByType(GridFieldDataColumns::class)->setFieldFormatting([
                    'ImageThumbnailURL' => function ($value, $item) {
                        if ($value) {
                            return '<img src="' . $value . '" style="width: 100px;" />';
                        }
                    },
                ]);
            }
        }

        return $form;
    }
}

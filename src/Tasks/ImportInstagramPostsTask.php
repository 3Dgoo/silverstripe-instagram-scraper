<?php

namespace X3dgoo\InstagramScraper\Tasks;

use Phpfastcache\Helper\Psr16Adapter;
use SilverStripe\Core\Environment;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;
use SilverStripe\SiteConfig\SiteConfig;
use X3dgoo\InstagramScraper\Model\InstagramPost;

class ImportInstagramPostsTask extends BuildTask
{
    private static $segment = 'import-instagram-posts';

    protected $title = 'Import Instagram feed';

    protected $description = '';

    public function run($request)
    {
        $siteConfig = SiteConfig::current_site_config();
        $username = Environment::getEnv('INSTAGRAM_USERNAME');
        $password = Environment::getEnv('INSTAGRAM_PASSWORD');

        if (!$siteConfig || !$siteConfig->exists() || !$siteConfig->InstagramID) {
            return;
        }

        $instagram = null;

        if ($username && $password) {
            $instagram = \InstagramScraper\Instagram::withCredentials($username, $password, new Psr16Adapter('Files'));
            $instagram->login();
            $instagram->saveSession();
        } else {
            $instagram = new \InstagramScraper\Instagram();
        }

        $instagramMedias = $instagram->getMedias($siteConfig->InstagramID);

        if (!$instagramMedias) {
            return;
        }

        foreach ($instagramMedias as $instagramMedia) {
            $instagramID = $instagramMedia->getId();
            $shortCode = $instagramMedia->getShortCode();
            $title = $instagramMedia->getCaption();
            $imageURL = $instagramMedia->getImageHighResolutionUrl();
            $imageThumbnailURL = $instagramMedia->getImageThumbnailUrl();
            $posted = $instagramMedia->getCreatedTime();

            $instagramPost = InstagramPost::get()->filter(['ShortCode' => $shortCode])->first();

            if (!$instagramPost || !$instagramPost->exists()) {
                $instagramPost = InstagramPost::create();
                $instagramPost->ShortCode = $shortCode;
            }

            $instagramPost->InstagramID = $instagramID;
            $instagramPost->Title = $title;
            $instagramPost->ImageURL = $imageURL;
            $instagramPost->ImageThumbnailURL = $imageThumbnailURL;
            $instagramPost->Posted = $posted;
            $instagramPost->write();

            DB::alteration_message('Imported instagram post ' . $shortCode);
        }
    }
}

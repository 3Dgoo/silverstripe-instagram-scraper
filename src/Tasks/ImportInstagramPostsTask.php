<?php

namespace X3dgoo\InstagramScraper\Tasks;

use InstagramScraper\Instagram;
use Phpfastcache\Helper\Psr16Adapter;
use SilverStripe\Core\Environment;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;
use X3dgoo\InstagramScraper\Model\InstagramPost;

class ImportInstagramPostsTask extends BuildTask
{
    private static $segment = 'import-instagram-posts';

    protected $title = 'Import Instagram feed';

    protected $description = '';

    public function run($request)
    {
        $subject = $request->getVar('subject');
        $username = Environment::getEnv('INSTAGRAM_USERNAME');
        $password = Environment::getEnv('INSTAGRAM_PASSWORD');

        if (!$subject) {
            return;
        }

        $instagram = null;

        if ($username && $password) {
            $instagram = Instagram::withCredentials($username, $password, new Psr16Adapter('Files'));
            $instagram->login();
            $instagram->saveSession();
        } else {
            $instagram = new Instagram();
        }

        $instagramMedias = $instagram->getMedias($subject);

        if (empty($instagramMedias)) {
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

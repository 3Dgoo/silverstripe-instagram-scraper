<?php

namespace X3dgoo\InstagramScraper\Tasks;

use InstagramScraper\Instagram;
use InstagramScraper\Model\Media;
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
        $handle = $request->getVar('handle');
        $loginUsername = Environment::getEnv('INSTAGRAM_USERNAME');
        $loginPassword = Environment::getEnv('INSTAGRAM_PASSWORD');

        if (!$handle) {
            return;
        }

        $instagram = null;

        if ($loginUsername && $loginPassword) {
            $instagram = Instagram::withCredentials(new \GuzzleHttp\Client(), $loginUsername, $loginPassword, new Psr16Adapter('Files'));
            $instagram->login();
            $instagram->saveSession();
        } else {
            $instagram = new Instagram(new \GuzzleHttp\Client());
        }

        $instagramMedias = $instagram->getMedias($handle);

        foreach ($instagramMedias as $instagramMedia) {
            $this->importInstagramPost($instagramMedia);
        }
    }

    /**
     * @param Media $instagramMedia
     */
    public function importInstagramPost($instagramMedia)
    {
        $shortCode = $instagramMedia->getShortCode();

        $instagramPost = InstagramPost::get()->filter(['ShortCode' => $shortCode])->first();

        if (!$instagramPost || !$instagramPost->exists()) {
            $instagramPost = InstagramPost::create();
            $instagramPost->ShortCode = $shortCode;
        }

        $instagramPost->InstagramID = $instagramMedia->getId();
        $instagramPost->Caption = $instagramMedia->getCaption();
        $instagramPost->Handle = $instagramMedia->getOwner()->getUsername();
        $instagramPost->Link = $instagramMedia->getLink();
        $instagramPost->Type = $instagramMedia->getType();
        $instagramPost->ImageLowResolutionUrl = $instagramMedia->getImageLowResolutionUrl();
        $instagramPost->ImageThumbnailURL = $instagramMedia->getImageThumbnailUrl();
        $instagramPost->ImageStandardResolutionUrl = $instagramMedia->getImageStandardResolutionUrl();
        $instagramPost->ImageHighResolutionUrl = $instagramMedia->getImageHighResolutionUrl();
        $instagramPost->Posted = $instagramMedia->getCreatedTime();
        $instagramPost->LikesCount = $instagramMedia->getLikesCount();
        $instagramPost->CommentsCount = $instagramMedia->getCommentsCount();
        $instagramPost->write();

        DB::alteration_message('Imported instagram post ' . $shortCode);
    }
}

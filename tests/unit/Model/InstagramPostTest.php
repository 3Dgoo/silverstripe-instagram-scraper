<?php

namespace X3dgoo\InstagramScraper\Tests;

use SilverStripe\Dev\SapphireTest;
use X3dgoo\InstagramScraper\Model\InstagramPost;

class InstagramPostTest extends SapphireTest
{
    protected $usesDatabase = true;

    public function testCreateInstagramPost()
    {
        $instagramPost = InstagramPost::create();
        $instagramPost->write();

        $this->assertNotNull($instagramPost);
    }
}

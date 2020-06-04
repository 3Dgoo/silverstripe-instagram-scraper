<?php

namespace X3dgoo\InstagramScraper\Tests;

use SilverStripe\Dev\FunctionalTest;
use X3dgoo\InstagramScraper\Admin\InstagramAdmin;
use X3dgoo\InstagramScraper\Model\InstagramPost;

class InstagramAdminTest extends FunctionalTest
{
    protected $usesDatabase = true;

    public function testInstagramAdmin()
    {
        $this->logInWithPermission('ADMIN');

        $instagramAdmin = InstagramAdmin::singleton();
        $response = $this->get($instagramAdmin->Link());

        $instagramPost1 = InstagramPost::create();
        $instagramPost1->ImageThumbnailURL = 'https://www.google.com/image.png';
        $instagramPost1->write();

        $instagramPost2 = InstagramPost::create();
        $instagramPost2->write();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertPartialMatchBySelector(
            '.breadcrumbs-wrapper .crumb.last',
            ['Instagram']
        );
    }
}

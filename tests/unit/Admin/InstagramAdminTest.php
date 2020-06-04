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

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertPartialMatchBySelector(
            '.breadcrumbs-wrapper .crumb.last',
            ['Instagram']
        );

        $instagramPost1 = InstagramPost::create();
        $instagramPost1->ImageThumbnailURL = 'https://via.placeholder.com/300/000/000.png';
        $instagramPost1->write();

        $response = $this->get($instagramAdmin->Link());
    }
}

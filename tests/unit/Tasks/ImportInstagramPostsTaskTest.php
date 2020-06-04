<?php

namespace X3dgoo\InstagramScraper\Tests;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;
use X3dgoo\InstagramScraper\Model\InstagramPost;
use X3dgoo\InstagramScraper\Tasks\ImportInstagramPostsTask;

class ImportInstagramPostsTaskTest extends SapphireTest
{
    protected $usesDatabase = true;

    public function testImportInstagramPostsTask()
    {
        $importInstagramPostsTask = ImportInstagramPostsTask::singleton();
        $this->assertNotNull($importInstagramPostsTask);

        $request = new HTTPRequest(
            'GET',
            'dev/tasks/import-instagram-posts',
            []
        );

        $importInstagramPostsTask->run($request);

        $this->assertEquals(0, InstagramPost::get()->count());

        $request = new HTTPRequest(
            'GET',
            'dev/tasks/import-instagram-posts',
            [
                'handle' => 'instagram',
            ]
        );

        $importInstagramPostsTask->run($request);

        $this->assertEquals(20, InstagramPost::get()->count());
    }
}

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

        $response = $importInstagramPostsTask->run($request);

        $this->assertNull($response);
        $this->assertEquals(0, InstagramPost::get()->count());

        $request = new HTTPRequest(
            'GET',
            'dev/tasks/import-instagram-posts',
            [
                'handle' => 'instagram'
            ]
        );

        $response = $importInstagramPostsTask->run($request);

        $this->assertNotNull($response);
        $this->assertEquals(8, InstagramPost::get()->count());
    }
}

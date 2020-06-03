<?php

namespace X3dgoo\InstagramScraper\Tests;

use SilverStripe\Dev\SapphireTest;
use X3dgoo\InstagramScraper\Tasks\ImportInstagramPostsTask;

class ImportInstagramPostsTaskTest extends SapphireTest
{
    protected $usesDatabase = true;

    public function testImportInstagramPostsTask()
    {
        $importInstagramPostsTask = ImportInstagramPostsTask::singleton();
        $this->assertNotNull($importInstagramPostsTask);

        $response = $importInstagramPostsTask->run(null);

        $this->assertNull($response);
    }
}

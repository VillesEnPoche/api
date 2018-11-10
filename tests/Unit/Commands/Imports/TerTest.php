<?php

namespace Tests\Unit\Commands\Imports;

use Tests\TestCase;

class TerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_ter_import_command()
    {
        $this->artisan('import:ter')->assertExitCode(0);
    }
}

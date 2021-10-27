<?php

use BloomCU\Tags\TagsServiceProvider;

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        // Pull in our package
        return [TagsServiceProvider::class];
    }

    // Before every test run, setup test environment
    public function setUp(): void
    {
        parent::setUp();

        // Ignore mass assignment exceptions
        Eloquent::unguard();

        // Migrate database
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__ . '/../migrations')
        ]);
    }

    // After each test is run, teardown the test environment
    public function tearDown(): void
    {
        // Drop lessons in database
        \Schema::drop('lessons');
    }

    protected function getEnvironmentSetup($app)
    {
        // Setup a database for our tests
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);

        // Create a lessons migration for testing tags on
        \Schema::create('lessons', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }
}

<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Faker\Factory;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sebastienheyd\Boilerplate\BoilerplateServiceProvider;
use Thomaswelton\LaravelGravatar\Gravatar;
use Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @var Factory $faker
     */
    protected $faker;

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->artisan('migrate', ['--database' => 'testbench'])->run();

        $this->faker = Factory::create();
        $this->email = $this->faker->email;
        $this->password = $this->faker->password;
    }

    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            BoilerplateServiceProvider::class,
            LaravelGravatarServiceProvider::class
        ];
    }
}

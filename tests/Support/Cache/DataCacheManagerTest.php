<?php

namespace Spatie\LaravelData\Tests\Support\Cache;

use ReflectionClass;
use Spatie\LaravelAutoDiscoverer\Discover;
use Spatie\LaravelAutoDiscoverer\ValueObjects\DiscoverProfile;
use Spatie\LaravelAutoDiscoverer\ValueObjects\DiscoverProfileConfig;
use Spatie\LaravelData\Support\DataClass;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Tests\Fakes\SimpleData;
use Spatie\LaravelData\Tests\TestCase;

class DataCacheManagerTest extends TestCase
{
    /** @test */
    public function it_can_cache_classes()
    {
        Discover::update('laravel-data', function (DiscoverProfileConfig $profile) {
            $profile
                ->basePath(__DIR__ . '/../../Fakes')
                ->rootNamespace('Spatie\LaravelData\Tests\Fakes');

            $profile->directories = [__DIR__ . '/../../Fakes/'];
        });

        Discover::run();

        $dataClasses = app(DataConfig::class)->getDataClasses();

        $this->assertNotEmpty($dataClasses);
        $this->assertEquals(DataClass::create(new ReflectionClass(SimpleData::class)), $dataClasses[SimpleData::class]);
    }
}
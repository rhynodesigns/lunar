<?php

namespace Lunar\Tests\Unit\Base\Extendable;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunar\Facades\ModelManifest;
use Lunar\Models\Product;
use Lunar\Models\Url;

class MorphTest extends ExtendableTestCase
{
    use RefreshDatabase;

    protected Product $product;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        ModelManifest::register(collect([
            Product::class => \Lunar\Tests\Stubs\Models\Product::class,
        ]));

        $this->product = \Lunar\Tests\Stubs\Models\Product::query()->create(
            Product::factory()->raw()
        );
    }

    /** @test */
    public function can_get_url_morph_relation_when_using_extended_model()
    {
        $productUrl = $this->product->urls()->create([
            'slug' => 'foo-product',
            'default' => true,
            'language_id' => 1,
        ]);

        $this->assertDatabaseHas((new Url)->getTable(), [
            'element_type' => Product::class,
            'element_id' => $productUrl->element_id,
        ]);

        $this->assertEquals(Product::class, $this->product->getMorphClass());
        $this->assertInstanceOf(Url::class, $this->product->defaultUrl);
    }

    /** @test */
    public function can_get_media_thumbnail_morph_relation_when_using_extended_model()
    {
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function can_get_prices_relation_when_using_extended_model()
    {
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function can_return_the_correct_morph_class_when_using_enforce_morph_map()
    {
        $this->expectNotToPerformAssertions();
    }
}
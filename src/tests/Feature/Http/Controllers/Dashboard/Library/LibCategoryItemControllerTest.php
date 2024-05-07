<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Library;

use App\LibCategory;
use App\LibCategoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Library\LibCategoryItemController
 */
class LibCategoryItemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $libCategoryItems = LibCategoryItem::factory()->count(3)->create();

        $response = $this->get(route('lib-category-item.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryItemController::class,
            'store',
            \App\Http\Requests\Dashboard\Library\LibCategoryItemStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $lib_category = LibCategory::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('lib-category-item.store'), [
            'lib_category_id' => $lib_category->id,
            'status' => $status,
            'order' => $order,
        ]);

        $libCategoryItems = LibCategoryItem::query()
            ->where('lib_category_id', $lib_category->id)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $libCategoryItems);
        $libCategoryItem = $libCategoryItems->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $libCategoryItem = LibCategoryItem::factory()->create();

        $response = $this->get(route('lib-category-item.show', $libCategoryItem));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryItemController::class,
            'update',
            \App\Http\Requests\Dashboard\Library\LibCategoryItemUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $libCategoryItem = LibCategoryItem::factory()->create();
        $lib_category = LibCategory::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('lib-category-item.update', $libCategoryItem), [
            'lib_category_id' => $lib_category->id,
            'status' => $status,
            'order' => $order,
        ]);

        $libCategoryItem->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($lib_category->id, $libCategoryItem->lib_category_id);
        $this->assertEquals($status, $libCategoryItem->status);
        $this->assertEquals($order, $libCategoryItem->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $libCategoryItem = LibCategoryItem::factory()->create();

        $response = $this->delete(route('lib-category-item.destroy', $libCategoryItem));

        $response->assertNoContent();

        $this->assertModelMissing($libCategoryItem);
    }
}

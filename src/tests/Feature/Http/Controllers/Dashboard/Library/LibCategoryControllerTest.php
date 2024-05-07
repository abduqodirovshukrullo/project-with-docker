<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Library;

use App\CoreLibraryTag;
use App\LibCategory;
use App\LibCategoryGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Library\LibCategoryController
 */
class LibCategoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $libCategories = LibCategory::factory()->count(3)->create();

        $response = $this->get(route('lib-category.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryController::class,
            'store',
            \App\Http\Requests\Dashboard\Library\LibCategoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $lib_category_group = LibCategoryGroup::factory()->create();
        $core_library_tag = CoreLibraryTag::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('lib-category.store'), [
            'lib_category_group_id' => $lib_category_group->id,
            'core_library_tag_id' => $core_library_tag->id,
            'status' => $status,
            'order' => $order,
        ]);

        $libCategories = LibCategory::query()
            ->where('lib_category_group_id', $lib_category_group->id)
            ->where('core_library_tag_id', $core_library_tag->id)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $libCategories);
        $libCategory = $libCategories->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $libCategory = LibCategory::factory()->create();

        $response = $this->get(route('lib-category.show', $libCategory));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryController::class,
            'update',
            \App\Http\Requests\Dashboard\Library\LibCategoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $libCategory = LibCategory::factory()->create();
        $lib_category_group = LibCategoryGroup::factory()->create();
        $core_library_tag = CoreLibraryTag::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('lib-category.update', $libCategory), [
            'lib_category_group_id' => $lib_category_group->id,
            'core_library_tag_id' => $core_library_tag->id,
            'status' => $status,
            'order' => $order,
        ]);

        $libCategory->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($lib_category_group->id, $libCategory->lib_category_group_id);
        $this->assertEquals($core_library_tag->id, $libCategory->core_library_tag_id);
        $this->assertEquals($status, $libCategory->status);
        $this->assertEquals($order, $libCategory->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $libCategory = LibCategory::factory()->create();

        $response = $this->delete(route('lib-category.destroy', $libCategory));

        $response->assertNoContent();

        $this->assertModelMissing($libCategory);
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Library;

use App\LibCategoryGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Library\LibCategoryGroupController
 */
class LibCategoryGroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $libCategoryGroups = LibCategoryGroup::factory()->count(3)->create();

        $response = $this->get(route('lib-category-group.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryGroupController::class,
            'store',
            \App\Http\Requests\Dashboard\Library\LibCategoryGroupStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('lib-category-group.store'), [
            'status' => $status,
            'order' => $order,
        ]);

        $libCategoryGroups = LibCategoryGroup::query()
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $libCategoryGroups);
        $libCategoryGroup = $libCategoryGroups->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $libCategoryGroup = LibCategoryGroup::factory()->create();

        $response = $this->get(route('lib-category-group.show', $libCategoryGroup));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryGroupController::class,
            'update',
            \App\Http\Requests\Dashboard\Library\LibCategoryGroupUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $libCategoryGroup = LibCategoryGroup::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('lib-category-group.update', $libCategoryGroup), [
            'status' => $status,
            'order' => $order,
        ]);

        $libCategoryGroup->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($status, $libCategoryGroup->status);
        $this->assertEquals($order, $libCategoryGroup->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $libCategoryGroup = LibCategoryGroup::factory()->create();

        $response = $this->delete(route('lib-category-group.destroy', $libCategoryGroup));

        $response->assertNoContent();

        $this->assertModelMissing($libCategoryGroup);
    }
}

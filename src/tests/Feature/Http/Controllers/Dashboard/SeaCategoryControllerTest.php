<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\SeaCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\SeaCategoryController
 */
class SeaCategoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $seaCategories = SeaCategory::factory()->count(3)->create();

        $response = $this->get(route('sea-category.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaCategoryController::class,
            'store',
            \App\Http\Requests\Dashboard\SeaCategoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('sea-category.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(seaCategories, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $seaCategory = SeaCategory::factory()->create();

        $response = $this->get(route('sea-category.show', $seaCategory));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaCategoryController::class,
            'update',
            \App\Http\Requests\Dashboard\SeaCategoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $seaCategory = SeaCategory::factory()->create();

        $response = $this->put(route('sea-category.update', $seaCategory));

        $seaCategory->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $seaCategory = SeaCategory::factory()->create();

        $response = $this->delete(route('sea-category.destroy', $seaCategory));

        $response->assertNoContent();

        $this->assertModelMissing($seaCategory);
    }
}

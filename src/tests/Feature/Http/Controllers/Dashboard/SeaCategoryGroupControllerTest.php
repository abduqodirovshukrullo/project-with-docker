<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\SeaCategoryGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\SeaCategoryGroupController
 */
class SeaCategoryGroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $seaCategoryGroups = SeaCategoryGroup::factory()->count(3)->create();

        $response = $this->get(route('sea-category-group.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaCategoryGroupController::class,
            'store',
            \App\Http\Requests\Dashboard\SeaCategoryGroupStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('sea-category-group.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(seaCategoryGroups, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $seaCategoryGroup = SeaCategoryGroup::factory()->create();

        $response = $this->get(route('sea-category-group.show', $seaCategoryGroup));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaCategoryGroupController::class,
            'update',
            \App\Http\Requests\Dashboard\SeaCategoryGroupUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $seaCategoryGroup = SeaCategoryGroup::factory()->create();

        $response = $this->put(route('sea-category-group.update', $seaCategoryGroup));

        $seaCategoryGroup->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $seaCategoryGroup = SeaCategoryGroup::factory()->create();

        $response = $this->delete(route('sea-category-group.destroy', $seaCategoryGroup));

        $response->assertNoContent();

        $this->assertModelMissing($seaCategoryGroup);
    }
}

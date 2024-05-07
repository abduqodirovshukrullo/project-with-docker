<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Library;

use App\LibCategoryItemValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Library\LibCategoryItemValueController
 */
class LibCategoryItemValueControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $libCategoryItemValues = LibCategoryItemValue::factory()->count(3)->create();

        $response = $this->get(route('lib-category-item-value.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryItemValueController::class,
            'store',
            \App\Http\Requests\Dashboard\Library\LibCategoryItemValueStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('lib-category-item-value.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(libCategoryItemValues, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $libCategoryItemValue = LibCategoryItemValue::factory()->create();

        $response = $this->get(route('lib-category-item-value.show', $libCategoryItemValue));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Library\LibCategoryItemValueController::class,
            'update',
            \App\Http\Requests\Dashboard\Library\LibCategoryItemValueUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $libCategoryItemValue = LibCategoryItemValue::factory()->create();

        $response = $this->put(route('lib-category-item-value.update', $libCategoryItemValue));

        $libCategoryItemValue->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $libCategoryItemValue = LibCategoryItemValue::factory()->create();

        $response = $this->delete(route('lib-category-item-value.destroy', $libCategoryItemValue));

        $response->assertNoContent();

        $this->assertModelMissing($libCategoryItemValue);
    }
}

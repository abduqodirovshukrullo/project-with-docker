<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Core;

use App\CoreLibraryTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Core\CoreLibraryTagController
 */
class CoreLibraryTagControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $coreLibraryTags = CoreLibraryTag::factory()->count(3)->create();

        $response = $this->get(route('core-library-tag.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Core\CoreLibraryTagController::class,
            'store',
            \App\Http\Requests\Dashboard\Core\CoreLibraryTagStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title_uz = $this->faker->word;
        $title_en = $this->faker->word;
        $title_ru = $this->faker->word;
        $type_of_use = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('core-library-tag.store'), [
            'title_uz' => $title_uz,
            'title_en' => $title_en,
            'title_ru' => $title_ru,
            'type_of_use' => $type_of_use,
            'status' => $status,
            'order' => $order,
        ]);

        $coreLibraryTags = CoreLibraryTag::query()
            ->where('title_uz', $title_uz)
            ->where('title_en', $title_en)
            ->where('title_ru', $title_ru)
            ->where('type_of_use', $type_of_use)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $coreLibraryTags);
        $coreLibraryTag = $coreLibraryTags->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $coreLibraryTag = CoreLibraryTag::factory()->create();

        $response = $this->get(route('core-library-tag.show', $coreLibraryTag));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Core\CoreLibraryTagController::class,
            'update',
            \App\Http\Requests\Dashboard\Core\CoreLibraryTagUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $coreLibraryTag = CoreLibraryTag::factory()->create();
        $title_uz = $this->faker->word;
        $title_en = $this->faker->word;
        $title_ru = $this->faker->word;
        $type_of_use = $this->faker->randomElement(/** enum_attributes **/);
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('core-library-tag.update', $coreLibraryTag), [
            'title_uz' => $title_uz,
            'title_en' => $title_en,
            'title_ru' => $title_ru,
            'type_of_use' => $type_of_use,
            'status' => $status,
            'order' => $order,
        ]);

        $coreLibraryTag->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title_uz, $coreLibraryTag->title_uz);
        $this->assertEquals($title_en, $coreLibraryTag->title_en);
        $this->assertEquals($title_ru, $coreLibraryTag->title_ru);
        $this->assertEquals($type_of_use, $coreLibraryTag->type_of_use);
        $this->assertEquals($status, $coreLibraryTag->status);
        $this->assertEquals($order, $coreLibraryTag->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $coreLibraryTag = CoreLibraryTag::factory()->create();

        $response = $this->delete(route('core-library-tag.destroy', $coreLibraryTag));

        $response->assertNoContent();

        $this->assertModelMissing($coreLibraryTag);
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\SeaQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\SeaQuestionController
 */
class SeaQuestionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $seaQuestions = SeaQuestion::factory()->count(3)->create();

        $response = $this->get(route('sea-question.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaQuestionController::class,
            'store',
            \App\Http\Requests\Dashboard\SeaQuestionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('sea-question.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(seaQuestions, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $seaQuestion = SeaQuestion::factory()->create();

        $response = $this->get(route('sea-question.show', $seaQuestion));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaQuestionController::class,
            'update',
            \App\Http\Requests\Dashboard\SeaQuestionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $seaQuestion = SeaQuestion::factory()->create();

        $response = $this->put(route('sea-question.update', $seaQuestion));

        $seaQuestion->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $seaQuestion = SeaQuestion::factory()->create();

        $response = $this->delete(route('sea-question.destroy', $seaQuestion));

        $response->assertNoContent();

        $this->assertModelMissing($seaQuestion);
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\SeaQuestionAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\SeaQuestionAnswerController
 */
class SeaQuestionAnswerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $seaQuestionAnswers = SeaQuestionAnswer::factory()->count(3)->create();

        $response = $this->get(route('sea-question-answer.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaQuestionAnswerController::class,
            'store',
            \App\Http\Requests\Dashboard\SeaQuestionAnswerStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('sea-question-answer.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(seaQuestionAnswers, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $seaQuestionAnswer = SeaQuestionAnswer::factory()->create();

        $response = $this->get(route('sea-question-answer.show', $seaQuestionAnswer));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaQuestionAnswerController::class,
            'update',
            \App\Http\Requests\Dashboard\SeaQuestionAnswerUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $seaQuestionAnswer = SeaQuestionAnswer::factory()->create();

        $response = $this->put(route('sea-question-answer.update', $seaQuestionAnswer));

        $seaQuestionAnswer->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $seaQuestionAnswer = SeaQuestionAnswer::factory()->create();

        $response = $this->delete(route('sea-question-answer.destroy', $seaQuestionAnswer));

        $response->assertNoContent();

        $this->assertModelMissing($seaQuestionAnswer);
    }
}

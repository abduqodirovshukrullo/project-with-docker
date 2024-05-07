<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\Question;
use App\Scenario;
use App\SeaScenarioStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\SeaScenarioStepController
 */
class SeaScenarioStepControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $seaScenarioSteps = SeaScenarioStep::factory()->count(3)->create();

        $response = $this->get(route('sea-scenario-step.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaScenarioStepController::class,
            'store',
            \App\Http\Requests\Dashboard\SeaScenarioStepStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $scenario = Scenario::factory()->create();
        $scenario_index = $this->faker->word;
        $question = Question::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('sea-scenario-step.store'), [
            'name' => $name,
            'scenario_id' => $scenario->id,
            'scenario_index' => $scenario_index,
            'question_id' => $question->id,
            'status' => $status,
            'order' => $order,
        ]);

        $seaScenarioSteps = SeaScenarioStep::query()
            ->where('name', $name)
            ->where('scenario_id', $scenario->id)
            ->where('scenario_index', $scenario_index)
            ->where('question_id', $question->id)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $seaScenarioSteps);
        $seaScenarioStep = $seaScenarioSteps->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $seaScenarioStep = SeaScenarioStep::factory()->create();

        $response = $this->get(route('sea-scenario-step.show', $seaScenarioStep));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaScenarioStepController::class,
            'update',
            \App\Http\Requests\Dashboard\SeaScenarioStepUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $seaScenarioStep = SeaScenarioStep::factory()->create();
        $name = $this->faker->name;
        $scenario = Scenario::factory()->create();
        $scenario_index = $this->faker->word;
        $question = Question::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('sea-scenario-step.update', $seaScenarioStep), [
            'name' => $name,
            'scenario_id' => $scenario->id,
            'scenario_index' => $scenario_index,
            'question_id' => $question->id,
            'status' => $status,
            'order' => $order,
        ]);

        $seaScenarioStep->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $seaScenarioStep->name);
        $this->assertEquals($scenario->id, $seaScenarioStep->scenario_id);
        $this->assertEquals($scenario_index, $seaScenarioStep->scenario_index);
        $this->assertEquals($question->id, $seaScenarioStep->question_id);
        $this->assertEquals($status, $seaScenarioStep->status);
        $this->assertEquals($order, $seaScenarioStep->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $seaScenarioStep = SeaScenarioStep::factory()->create();

        $response = $this->delete(route('sea-scenario-step.destroy', $seaScenarioStep));

        $response->assertNoContent();

        $this->assertModelMissing($seaScenarioStep);
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\Group;
use App\SeaScenario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\SeaScenarioController
 */
class SeaScenarioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $seaScenarios = SeaScenario::factory()->count(3)->create();

        $response = $this->get(route('sea-scenario.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaScenarioController::class,
            'store',
            \App\Http\Requests\Dashboard\SeaScenarioStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $group = Group::factory()->create();

        $response = $this->post(route('sea-scenario.store'), [
            'group_id' => $group->id,
        ]);

        $seaScenarios = SeaScenario::query()
            ->where('group_id', $group->id)
            ->get();
        $this->assertCount(1, $seaScenarios);
        $seaScenario = $seaScenarios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $seaScenario = SeaScenario::factory()->create();

        $response = $this->get(route('sea-scenario.show', $seaScenario));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\SeaScenarioController::class,
            'update',
            \App\Http\Requests\Dashboard\SeaScenarioUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $seaScenario = SeaScenario::factory()->create();
        $group = Group::factory()->create();

        $response = $this->put(route('sea-scenario.update', $seaScenario), [
            'group_id' => $group->id,
        ]);

        $seaScenario->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($group->id, $seaScenario->group_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $seaScenario = SeaScenario::factory()->create();

        $response = $this->delete(route('sea-scenario.destroy', $seaScenario));

        $response->assertNoContent();

        $this->assertModelMissing($seaScenario);
    }
}

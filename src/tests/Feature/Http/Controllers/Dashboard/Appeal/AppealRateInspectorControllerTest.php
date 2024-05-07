<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Appeal;

use App\AppealRateInspector;
use App\Inspector;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Appeal\AppealRateInspectorController
 */
class AppealRateInspectorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $appealRateInspectors = AppealRateInspector::factory()->count(3)->create();

        $response = $this->get(route('appeal-rate-inspector.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Appeal\AppealRateInspectorController::class,
            'store',
            \App\Http\Requests\Dashboard\Appeal\AppealRateInspectorStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $user = User::factory()->create();
        $inspector = Inspector::factory()->create();
        $comment_text = $this->faker->text;
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('appeal-rate-inspector.store'), [
            'user_id' => $user->id,
            'inspector_id' => $inspector->id,
            'comment_text' => $comment_text,
            'status' => $status,
            'order' => $order,
        ]);

        $appealRateInspectors = AppealRateInspector::query()
            ->where('user_id', $user->id)
            ->where('inspector_id', $inspector->id)
            ->where('comment_text', $comment_text)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $appealRateInspectors);
        $appealRateInspector = $appealRateInspectors->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $appealRateInspector = AppealRateInspector::factory()->create();

        $response = $this->get(route('appeal-rate-inspector.show', $appealRateInspector));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Appeal\AppealRateInspectorController::class,
            'update',
            \App\Http\Requests\Dashboard\Appeal\AppealRateInspectorUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $appealRateInspector = AppealRateInspector::factory()->create();
        $user = User::factory()->create();
        $inspector = Inspector::factory()->create();
        $comment_text = $this->faker->text;
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('appeal-rate-inspector.update', $appealRateInspector), [
            'user_id' => $user->id,
            'inspector_id' => $inspector->id,
            'comment_text' => $comment_text,
            'status' => $status,
            'order' => $order,
        ]);

        $appealRateInspector->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $appealRateInspector->user_id);
        $this->assertEquals($inspector->id, $appealRateInspector->inspector_id);
        $this->assertEquals($comment_text, $appealRateInspector->comment_text);
        $this->assertEquals($status, $appealRateInspector->status);
        $this->assertEquals($order, $appealRateInspector->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $appealRateInspector = AppealRateInspector::factory()->create();

        $response = $this->delete(route('appeal-rate-inspector.destroy', $appealRateInspector));

        $response->assertNoContent();

        $this->assertModelMissing($appealRateInspector);
    }
}

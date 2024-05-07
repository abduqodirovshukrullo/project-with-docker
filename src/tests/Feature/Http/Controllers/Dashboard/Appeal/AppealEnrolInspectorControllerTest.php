<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Appeal;

use App\AppealEnrolInspector;
use App\Inspection;
use App\Problem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Appeal\AppealEnrolInspectorController
 */
class AppealEnrolInspectorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $appealEnrolInspectors = AppealEnrolInspector::factory()->count(3)->create();

        $response = $this->get(route('appeal-enrol-inspector.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Appeal\AppealEnrolInspectorController::class,
            'store',
            \App\Http\Requests\Dashboard\Appeal\AppealEnrolInspectorStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $patronimic = $this->faker->text;
        $address = $this->faker->text;
        $passport_serial = $this->faker->text;
        $pin = $this->faker->text;
        $phone = $this->faker->phoneNumber;
        $inspection = Inspection::factory()->create();
        $problem = Problem::factory()->create();
        $appeal_text = $this->faker->text;
        $document_url = $this->faker->word;
        $planned_date = $this->faker->dateTime();
        $planned_time = $this->faker->numberBetween(-10000, 10000);
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('appeal-enrol-inspector.store'), [
            'type' => $type,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'patronimic' => $patronimic,
            'address' => $address,
            'passport_serial' => $passport_serial,
            'pin' => $pin,
            'phone' => $phone,
            'inspection_id' => $inspection->id,
            'problem_id' => $problem->id,
            'appeal_text' => $appeal_text,
            'document_url' => $document_url,
            'planned_date' => $planned_date,
            'planned_time' => $planned_time,
            'status' => $status,
            'order' => $order,
        ]);

        $appealEnrolInspectors = AppealEnrolInspector::query()
            ->where('type', $type)
            ->where('first_name', $first_name)
            ->where('last_name', $last_name)
            ->where('patronimic', $patronimic)
            ->where('address', $address)
            ->where('passport_serial', $passport_serial)
            ->where('pin', $pin)
            ->where('phone', $phone)
            ->where('inspection_id', $inspection->id)
            ->where('problem_id', $problem->id)
            ->where('appeal_text', $appeal_text)
            ->where('document_url', $document_url)
            ->where('planned_date', $planned_date)
            ->where('planned_time', $planned_time)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $appealEnrolInspectors);
        $appealEnrolInspector = $appealEnrolInspectors->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $appealEnrolInspector = AppealEnrolInspector::factory()->create();

        $response = $this->get(route('appeal-enrol-inspector.show', $appealEnrolInspector));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Appeal\AppealEnrolInspectorController::class,
            'update',
            \App\Http\Requests\Dashboard\Appeal\AppealEnrolInspectorUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $appealEnrolInspector = AppealEnrolInspector::factory()->create();
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $patronimic = $this->faker->text;
        $address = $this->faker->text;
        $passport_serial = $this->faker->text;
        $pin = $this->faker->text;
        $phone = $this->faker->phoneNumber;
        $inspection = Inspection::factory()->create();
        $problem = Problem::factory()->create();
        $appeal_text = $this->faker->text;
        $document_url = $this->faker->word;
        $planned_date = $this->faker->dateTime();
        $planned_time = $this->faker->numberBetween(-10000, 10000);
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('appeal-enrol-inspector.update', $appealEnrolInspector), [
            'type' => $type,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'patronimic' => $patronimic,
            'address' => $address,
            'passport_serial' => $passport_serial,
            'pin' => $pin,
            'phone' => $phone,
            'inspection_id' => $inspection->id,
            'problem_id' => $problem->id,
            'appeal_text' => $appeal_text,
            'document_url' => $document_url,
            'planned_date' => $planned_date,
            'planned_time' => $planned_time,
            'status' => $status,
            'order' => $order,
        ]);

        $appealEnrolInspector->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($type, $appealEnrolInspector->type);
        $this->assertEquals($first_name, $appealEnrolInspector->first_name);
        $this->assertEquals($last_name, $appealEnrolInspector->last_name);
        $this->assertEquals($patronimic, $appealEnrolInspector->patronimic);
        $this->assertEquals($address, $appealEnrolInspector->address);
        $this->assertEquals($passport_serial, $appealEnrolInspector->passport_serial);
        $this->assertEquals($pin, $appealEnrolInspector->pin);
        $this->assertEquals($phone, $appealEnrolInspector->phone);
        $this->assertEquals($inspection->id, $appealEnrolInspector->inspection_id);
        $this->assertEquals($problem->id, $appealEnrolInspector->problem_id);
        $this->assertEquals($appeal_text, $appealEnrolInspector->appeal_text);
        $this->assertEquals($document_url, $appealEnrolInspector->document_url);
        $this->assertEquals($planned_date, $appealEnrolInspector->planned_date);
        $this->assertEquals($planned_time, $appealEnrolInspector->planned_time);
        $this->assertEquals($status, $appealEnrolInspector->status);
        $this->assertEquals($order, $appealEnrolInspector->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $appealEnrolInspector = AppealEnrolInspector::factory()->create();

        $response = $this->delete(route('appeal-enrol-inspector.destroy', $appealEnrolInspector));

        $response->assertNoContent();

        $this->assertModelMissing($appealEnrolInspector);
    }
}

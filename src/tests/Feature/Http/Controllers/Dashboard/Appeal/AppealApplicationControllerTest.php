<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Appeal;

use App\AppealApplication;
use App\Inspection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Appeal\AppealApplicationController
 */
class AppealApplicationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $appealApplications = AppealApplication::factory()->count(3)->create();

        $response = $this->get(route('appeal-application.php.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Appeal\AppealApplicationController::class,
            'store',
            \App\Http\Requests\Dashboard\Appeal\AppealApplicationStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $passport_serial = $this->faker->text;
        $pin = $this->faker->text;
        $phone = $this->faker->phoneNumber;
        $inspection = Inspection::factory()->create();
        $appeal_text = $this->faker->text;
        $document_url = $this->faker->word;
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('appeal-application.php.store'), [
            'type' => $type,
            'passport_serial' => $passport_serial,
            'pin' => $pin,
            'phone' => $phone,
            'inspection_id' => $inspection->id,
            'appeal_text' => $appeal_text,
            'document_url' => $document_url,
            'status' => $status,
            'order' => $order,
        ]);

        $appealApplications = AppealApplication::query()
            ->where('type', $type)
            ->where('passport_serial', $passport_serial)
            ->where('pin', $pin)
            ->where('phone', $phone)
            ->where('inspection_id', $inspection->id)
            ->where('appeal_text', $appeal_text)
            ->where('document_url', $document_url)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $appealApplications);
        $appealApplication = $appealApplications->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $appealApplication = AppealApplication::factory()->create();

        $response = $this->get(route('appeal-application.php.show', $appealApplication));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Appeal\AppealApplicationController::class,
            'update',
            \App\Http\Requests\Dashboard\Appeal\AppealApplicationUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $appealApplication = AppealApplication::factory()->create();
        $type = $this->faker->randomElement(/** enum_attributes **/);
        $passport_serial = $this->faker->text;
        $pin = $this->faker->text;
        $phone = $this->faker->phoneNumber;
        $inspection = Inspection::factory()->create();
        $appeal_text = $this->faker->text;
        $document_url = $this->faker->word;
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('appeal-application.php.update', $appealApplication), [
            'type' => $type,
            'passport_serial' => $passport_serial,
            'pin' => $pin,
            'phone' => $phone,
            'inspection_id' => $inspection->id,
            'appeal_text' => $appeal_text,
            'document_url' => $document_url,
            'status' => $status,
            'order' => $order,
        ]);

        $appealApplication->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($type, $appealApplication->type);
        $this->assertEquals($passport_serial, $appealApplication->passport_serial);
        $this->assertEquals($pin, $appealApplication->pin);
        $this->assertEquals($phone, $appealApplication->phone);
        $this->assertEquals($inspection->id, $appealApplication->inspection_id);
        $this->assertEquals($appeal_text, $appealApplication->appeal_text);
        $this->assertEquals($document_url, $appealApplication->document_url);
        $this->assertEquals($status, $appealApplication->status);
        $this->assertEquals($order, $appealApplication->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $appealApplication = AppealApplication::factory()->create();

        $response = $this->delete(route('appeal-application.php.destroy', $appealApplication));

        $response->assertNoContent();

        $this->assertModelMissing($appealApplication);
    }
}

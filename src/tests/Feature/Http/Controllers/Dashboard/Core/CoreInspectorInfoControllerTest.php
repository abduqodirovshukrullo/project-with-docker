<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Core;

use App\CoreInspectorInfo;
use App\Inspection;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Core\CoreInspectorInfoController
 */
class CoreInspectorInfoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $coreInspectorInfos = CoreInspectorInfo::factory()->count(3)->create();

        $response = $this->get(route('core-inspector-info.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Core\CoreInspectorInfoController::class,
            'store',
            \App\Http\Requests\Dashboard\Core\CoreInspectorInfoStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $image_url = $this->faker->word;
        $fullname_uz = $this->faker->word;
        $fullname_ru = $this->faker->word;
        $fullname_en = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $admission_days_uz = $this->faker->text;
        $admission_days_ru = $this->faker->text;
        $admission_days_en = $this->faker->text;
        $user = User::factory()->create();
        $inspection = Inspection::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('core-inspector-info.store'), [
            'image_url' => $image_url,
            'fullname_uz' => $fullname_uz,
            'fullname_ru' => $fullname_ru,
            'fullname_en' => $fullname_en,
            'phone' => $phone,
            'admission_days_uz' => $admission_days_uz,
            'admission_days_ru' => $admission_days_ru,
            'admission_days_en' => $admission_days_en,
            'user_id' => $user->id,
            'inspection_id' => $inspection->id,
            'status' => $status,
            'order' => $order,
        ]);

        $coreInspectorInfos = CoreInspectorInfo::query()
            ->where('image_url', $image_url)
            ->where('fullname_uz', $fullname_uz)
            ->where('fullname_ru', $fullname_ru)
            ->where('fullname_en', $fullname_en)
            ->where('phone', $phone)
            ->where('admission_days_uz', $admission_days_uz)
            ->where('admission_days_ru', $admission_days_ru)
            ->where('admission_days_en', $admission_days_en)
            ->where('user_id', $user->id)
            ->where('inspection_id', $inspection->id)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $coreInspectorInfos);
        $coreInspectorInfo = $coreInspectorInfos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $coreInspectorInfo = CoreInspectorInfo::factory()->create();

        $response = $this->get(route('core-inspector-info.show', $coreInspectorInfo));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Core\CoreInspectorInfoController::class,
            'update',
            \App\Http\Requests\Dashboard\Core\CoreInspectorInfoUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $coreInspectorInfo = CoreInspectorInfo::factory()->create();
        $image_url = $this->faker->word;
        $fullname_uz = $this->faker->word;
        $fullname_ru = $this->faker->word;
        $fullname_en = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $admission_days_uz = $this->faker->text;
        $admission_days_ru = $this->faker->text;
        $admission_days_en = $this->faker->text;
        $user = User::factory()->create();
        $inspection = Inspection::factory()->create();
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('core-inspector-info.update', $coreInspectorInfo), [
            'image_url' => $image_url,
            'fullname_uz' => $fullname_uz,
            'fullname_ru' => $fullname_ru,
            'fullname_en' => $fullname_en,
            'phone' => $phone,
            'admission_days_uz' => $admission_days_uz,
            'admission_days_ru' => $admission_days_ru,
            'admission_days_en' => $admission_days_en,
            'user_id' => $user->id,
            'inspection_id' => $inspection->id,
            'status' => $status,
            'order' => $order,
        ]);

        $coreInspectorInfo->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($image_url, $coreInspectorInfo->image_url);
        $this->assertEquals($fullname_uz, $coreInspectorInfo->fullname_uz);
        $this->assertEquals($fullname_ru, $coreInspectorInfo->fullname_ru);
        $this->assertEquals($fullname_en, $coreInspectorInfo->fullname_en);
        $this->assertEquals($phone, $coreInspectorInfo->phone);
        $this->assertEquals($admission_days_uz, $coreInspectorInfo->admission_days_uz);
        $this->assertEquals($admission_days_ru, $coreInspectorInfo->admission_days_ru);
        $this->assertEquals($admission_days_en, $coreInspectorInfo->admission_days_en);
        $this->assertEquals($user->id, $coreInspectorInfo->user_id);
        $this->assertEquals($inspection->id, $coreInspectorInfo->inspection_id);
        $this->assertEquals($status, $coreInspectorInfo->status);
        $this->assertEquals($order, $coreInspectorInfo->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $coreInspectorInfo = CoreInspectorInfo::factory()->create();

        $response = $this->delete(route('core-inspector-info.destroy', $coreInspectorInfo));

        $response->assertNoContent();

        $this->assertModelMissing($coreInspectorInfo);
    }
}

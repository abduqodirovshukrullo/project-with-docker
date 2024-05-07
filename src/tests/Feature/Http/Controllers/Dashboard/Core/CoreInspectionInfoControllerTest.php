<?php

namespace Tests\Feature\Http\Controllers\Dashboard\Core;

use App\City;
use App\CoreInspectionInfo;
use App\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Dashboard\Core\CoreInspectionInfoController
 */
class CoreInspectionInfoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $coreInspectionInfos = CoreInspectionInfo::factory()->count(3)->create();

        $response = $this->get(route('core-inspection-info.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Core\CoreInspectionInfoController::class,
            'store',
            \App\Http\Requests\Dashboard\Core\CoreInspectionInfoStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $region = Region::factory()->create();
        $city = City::factory()->create();
        $address = $this->faker->word;
        $name_legal = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $lat = $this->faker->latitude;
        $long = $this->faker->randomFloat(/** double_attributes **/);
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('core-inspection-info.store'), [
            'region_id' => $region->id,
            'city_id' => $city->id,
            'address' => $address,
            'name_legal' => $name_legal,
            'phone' => $phone,
            'lat' => $lat,
            'long' => $long,
            'status' => $status,
            'order' => $order,
        ]);

        $coreInspectionInfos = CoreInspectionInfo::query()
            ->where('region_id', $region->id)
            ->where('city_id', $city->id)
            ->where('address', $address)
            ->where('name_legal', $name_legal)
            ->where('phone', $phone)
            ->where('lat', $lat)
            ->where('long', $long)
            ->where('status', $status)
            ->where('order', $order)
            ->get();
        $this->assertCount(1, $coreInspectionInfos);
        $coreInspectionInfo = $coreInspectionInfos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $coreInspectionInfo = CoreInspectionInfo::factory()->create();

        $response = $this->get(route('core-inspection-info.show', $coreInspectionInfo));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Dashboard\Core\CoreInspectionInfoController::class,
            'update',
            \App\Http\Requests\Dashboard\Core\CoreInspectionInfoUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $coreInspectionInfo = CoreInspectionInfo::factory()->create();
        $region = Region::factory()->create();
        $city = City::factory()->create();
        $address = $this->faker->word;
        $name_legal = $this->faker->word;
        $phone = $this->faker->phoneNumber;
        $lat = $this->faker->latitude;
        $long = $this->faker->randomFloat(/** double_attributes **/);
        $status = $this->faker->boolean;
        $order = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('core-inspection-info.update', $coreInspectionInfo), [
            'region_id' => $region->id,
            'city_id' => $city->id,
            'address' => $address,
            'name_legal' => $name_legal,
            'phone' => $phone,
            'lat' => $lat,
            'long' => $long,
            'status' => $status,
            'order' => $order,
        ]);

        $coreInspectionInfo->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($region->id, $coreInspectionInfo->region_id);
        $this->assertEquals($city->id, $coreInspectionInfo->city_id);
        $this->assertEquals($address, $coreInspectionInfo->address);
        $this->assertEquals($name_legal, $coreInspectionInfo->name_legal);
        $this->assertEquals($phone, $coreInspectionInfo->phone);
        $this->assertEquals($lat, $coreInspectionInfo->lat);
        $this->assertEquals($long, $coreInspectionInfo->long);
        $this->assertEquals($status, $coreInspectionInfo->status);
        $this->assertEquals($order, $coreInspectionInfo->order);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $coreInspectionInfo = CoreInspectionInfo::factory()->create();

        $response = $this->delete(route('core-inspection-info.destroy', $coreInspectionInfo));

        $response->assertNoContent();

        $this->assertModelMissing($coreInspectionInfo);
    }
}

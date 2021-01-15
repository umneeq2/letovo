<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pupil as PupilModel;
use App\Http\Resources\Pupil as PupilResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PupilsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pupils = PupilModel::select(['id', 'fullname', 'email', 'mobile_phone', 'address', 'address_normalized', 'geo_lat', 'geo_lon'])
            ->orderBy('id', 'asc');

        return PupilResource::collection($pupils->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pupil = PupilModel::find($id);

        if (!$pupil) {
            throw new NotFoundHttpException("Ученик не найден.");
        }

        return new PupilResource($pupil);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Делает запрос сайту dadata.ru и обновляет поля 
     * "address_normalized", "geo_lat", "get_lon" у ученика
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function normalize(Request $request, $id)
    {
        $pupil = PupilModel::find($id);
        if (!$pupil) {
            throw new \Exception("Ученик не найден.");
        }

        $dadata = new \Dadata\DadataClient(env('DADATA_TOKEN'), env('DADATA_SECRET'));
        // $dadata_response =  [
        //     "source" => "пр-т Калинина, д. 8, г. Барнаул",
        //     "result" => "г Барнаул, пр-кт Калинина, д 8",
        //     "postal_code" => "656002",
        //     "country" => "Россия",
        //     "country_iso_code" => "RU",
        //     "federal_district" => "Сибирский",
        //     "region_fias_id" => "8276c6a1-1a86-4f0d-8920-aba34d4cc34a",
        //     "region_kladr_id" => "2200000000000",
        //     "region_iso_code" => "RU-ALT",
        //     "region_with_type" => "Алтайский край",
        //     "region_type" => "край",
        //     "region_type_full" => "край",
        //     "region" => "Алтайский",
        //     "area_fias_id" => null,
        //     "area_kladr_id" => null,
        //     "area_with_type" => null,
        //     "area_type" => null,
        //     "area_type_full" => null,
        //     "area" => null,
        //     "city_fias_id" => "d13945a8-7017-46ab-b1e6-ede1e89317ad",
        //     "city_kladr_id" => "2200000100000",
        //     "city_with_type" => "г Барнаул",
        //     "city_type" => "г",
        //     "city_type_full" => "город",
        //     "city" => "Барнаул",
        //     "city_area" => null,
        //     "city_district_fias_id" => null,
        //     "city_district_kladr_id" => null,
        //     "city_district_with_type" => "р-н Октябрьский",
        //     "city_district_type" => "р-н",
        //     "city_district_type_full" => "район",
        //     "city_district" => "Октябрьский",
        //     "settlement_fias_id" => null,
        //     "settlement_kladr_id" => null,
        //     "settlement_with_type" => null,
        //     "settlement_type" => null,
        //     "settlement_type_full" => null,
        //     "settlement" => null,
        //     "street_fias_id" => "ccf14c41-7074-409e-b3e3-e10cd3ad924f",
        //     "street_kladr_id" => "22000001000027800",
        //     "street_with_type" => "пр-кт Калинина",
        //     "street_type" => "пр-кт",
        //     "street_type_full" => "проспект",
        //     "street" => "Калинина",
        //     "house_fias_id" => "94c2455c-249d-48a5-850a-c18cc1d1298f",
        //     "house_kladr_id" => "2200000100002780025",
        //     "house_type" => "д",
        //     "house_type_full" => "дом",
        //     "house" => "8",
        //     "block_type" => null,
        //     "block_type_full" => null,
        //     "block" => null,
        //     "flat_type" => null,
        //     "flat_type_full" => null,
        //     "flat" => null,
        //     "flat_area" => null,
        //     "square_meter_price" => null,
        //     "flat_price" => null,
        //     "postal_box" => null,
        //     "fias_id" => "94c2455c-249d-48a5-850a-c18cc1d1298f",
        //     "fias_code" => "22000001000000002780025",
        //     "fias_level" => "8",
        //     "fias_actuality_state" => "0",
        //     "kladr_id" => "2200000100002780025",
        //     "capital_marker" => "2",
        //     "okato" => "01401367000",
        //     "oktmo" => "01701000001",
        //     "tax_office" => "2224",
        //     "tax_office_legal" => "2224",
        //     "timezone" => "UTC+7",
        //     "geo_lat" => "53.3571077",
        //     "geo_lon" => "83.7715479",
        //     "beltway_hit" => null,
        //     "beltway_distance" => null,
        //     "qc_geo" => 1,
        //     "qc_complete" => 5,
        //     "qc_house" => 2,
        //     "qc" => 0,
        //     "unparsed_parts" => null,
        //     "metro" => null,
        // ];
        $dadata_response = $dadata->clean("address", $pupil->address);

        if (isset($dadata_response["result"]) && $dadata_response["result"] !== null) {

            $pupil->address_normalized = $dadata_response["result"];
            $pupil->geo_lat = $dadata_response["geo_lat"];
            $pupil->geo_lon = $dadata_response["geo_lon"];

            if (!$pupil->save()) {
                throw new \Exception("Не могу сохранить данные ученика.");
            }

            return response([
                'address_normalized' => $pupil->address_normalized,
                'geo_lat' => $pupil->geo_lat,
                'geo_lon' => $pupil->geo_lon,
            ]);
        }

        return response('', Response::HTTP_EXPECTATION_FAILED);
    }
}

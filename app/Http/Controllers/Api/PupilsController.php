<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PupilCreateUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Pupil as PupilModel;
use App\Http\Resources\Pupil as PupilResource;
use Symfony\Component\HttpFoundation\Response;

class PupilsController extends Controller
{
    /**
     * Выводит постранично список учеников
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pupils = PupilModel::orderBy('id', 'asc');

        return PupilResource::collection($pupils->paginate(20));
    }

    /**
     * Сохраняет нового ученика в хранилище
     *
     * @param  App\Http\Requests\PupilCreateUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PupilCreateUpdateRequest $request)
    {
        $data = $request->input();

        $pupil = new PupilModel($data);
        $pupil->save();

        if ($pupil) {
            return response(['id' => $pupil->id]);
        } else {
            return response('Ошибка сохранения ученика.', Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * Выводит ученика по ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pupil = PupilModel::find($id);

        if (!$pupil) {
            return response('Ученик не найден.', Response::HTTP_NOT_FOUND);
        }

        return new PupilResource($pupil);
    }

    /**
     * Принимает запрос на редактирование ученика
     *
     * @param  App\Http\Requests\PupilCreateUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PupilCreateUpdateRequest $request, int $id)
    {
        $pupil = PupilModel::find($id);
        if (!$pupil) {
            return response('Ученик не найден', Response::HTTP_NOT_FOUND);
        }
        if ($pupil->update($request->all())) {
            return response(['id' => $pupil->id]);
        } else {
            return response('Ошибка сохранения ученика.', Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * Удаляет выбранного ученика
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $pupil = PupilModel::find($id);
        if (!$pupil) {
            return response('Ученик не найден', Response::HTTP_NOT_FOUND);
        }
        if ($pupil->delete()) {
            return response(['id' => $pupil->id]);
        } else {
            return response('Ошибка удаления ученика.', Response::HTTP_NOT_ACCEPTABLE);
        }
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
            return response('Ученик не найден.', Response::HTTP_NOT_FOUND);
        }

        $dadata = new \Dadata\DadataClient(env('DADATA_TOKEN'), env('DADATA_SECRET'));
        $dadata_response = $dadata->clean("address", $pupil->address);

        if (isset($dadata_response["result"]) && $dadata_response["result"] !== null) {

            $pupil->address_normalized = $dadata_response["result"];
            $pupil->geo_lat = $dadata_response["geo_lat"];
            $pupil->geo_lon = $dadata_response["geo_lon"];

            if (!$pupil->save()) {
                return response('Не могу сохранить данные ученика.', Response::HTTP_NOT_ACCEPTABLE);
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

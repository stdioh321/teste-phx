<?php

namespace App\Http\Controllers;


use App\Models\Carro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Carro::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->only(["marca", "modelo", "ano"]);
        $validate = Validator::make($params, [
            "marca" => "required|max:255|string",
            "modelo" => "required|max:255|string",
            "ano" => "required|date",
        ]);
        if ($validate->fails()) {
            return $this->responseJson($validate->errors(), 422);
        }


        // $params["ano"] = Carbon::parse($params["ano"]);
        $novoCarro =  new Carro;
        $novoCarro->fill($params);
        $novoCarro->save();
        return $this->responseJson($novoCarro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = Carro::where("id", "=", "$id")->first();
        if (empty($carro))
            return $this->responseJson(null, 404);
        return $this->responseJson($carro);
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
        $oldCarro = Carro::where("id", "=", $id)->first();

        if (empty($oldCarro))
            return $this->responseJson(null, 404);

        $params = $request->only(["marca", "modelo", "ano"]);
        $validate = Validator::make($params, [
            "marca" => "required|max:255|string|sometimes",
            "modelo" => "required|max:255|string|sometimes",
            "ano" => "required|date|sometimes",
        ]);
        if ($validate->fails()) {
            return $this->responseJson($validate->errors(), 422);
        }
        $oldCarro->update($params);
        return $this->responseJson($oldCarro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldCarro = Carro::where("id", "=", $id)->first();
        if (empty($oldCarro))
            return $this->responseJson(null, 404);
        $oldCarro->delete();
        return $this->responseJson($oldCarro);
    }
}

<?php

namespace App\Controller;

use App\Domain\PhoneNumber\Model\PhoneNumber;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class PhoneNumberController extends Controller
{
    protected $model;

    public function __construct(PhoneNumber $model){
      $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::all();

        return response()->json(['data'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json('Rota sem uso!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' =>  'required',
            'phone' =>  'required',
            'status' =>  'nullable'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'msg'=>$validator->errors()]);
        }

        try {
            $model = new $this->model;
            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->status = $request->status;

            $model->save();

            $response = 'Telefone Cadastrado com Sucesso!';

            return response()->json(['status'=>true,'msg'=>$response]);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            return response()->json(['status'=>false,'msg'=>$response]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhoneNumber  $model
     * @return \Illuminate\Http\Response
     */
    public function show(PhoneNumber $telefone)
    {
      try {

          return response()->json(['data'=>$telefone]);

      } catch (\Exception $e) {//errors exceptions

          $response = null;

          switch (get_class($e)) {
            case QueryException::class:$response = $e->getMessage();
            case Exception::class:$response = $e->getMessage();
            default: $response = get_class($e);
          }

          $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

          return response()->json(['status'=>false,'msg'=>$response]);

      }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhoneNumber  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(PhoneNumber $telefone)
    {
        return response()->json('Rota sem uso!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhoneNumber  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhoneNumber $telefone)
    {

      try {
          $model = $telefone;

          $request->has('name')?$model->name = $request->name:'';
          $request->has('phone')?$model->phone = $request->phone:'';
          $request->has('status')?$model->status = $request->status:'';

          $model->save();

          $response = 'Telefone Editado com Sucesso!';

          return response()->json(['status'=>true,'msg'=>$response]);

      } catch (\Exception $e) {//errors exceptions

          $response = null;

          switch (get_class($e)) {
            case QueryException::class:$response = $e->getMessage();
            case Exception::class:$response = $e->getMessage();
            case ValidationException::class:$response = $e;
            default: $response = get_class($e);
          }

          $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

          return response()->json(['status'=>false,'msg'=>$response]);

      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhoneNumber  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhoneNumber $telefone)
    {
        try {

            $telefone->delete();

            $response = 'Telefone Deletado com Sucesso!';

            return response()->json(['status'=>true,'msg'=>$response]);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            return redirect($this->link)->withErrors($response);

        }
    }
}

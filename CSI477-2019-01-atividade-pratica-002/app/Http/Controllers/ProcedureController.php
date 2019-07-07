<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Procedure;
use App\Http\Requests\ProcedureRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProcedureController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(Gate::denies('manage-procedures')){
                abort(403,__('Unauthorized action'));
            }

            return $next($request);
        });
    }
    public function index(Procedure $model)
    {
        return view('procedures.index',['procedures'=>$model->paginate(10)]);
    }

    public function create()
    {
        return view('procedures.create');
    }

    public function store(ProcedureRequest $request, Procedure $model)
    {
        $model->create($request->merge(['user_id'=>Auth::user()->id])->all());

        return redirect()->route('procedures.index')->withStatus(__('Procedure successfully created.'));
    }

    public function edit(Procedure $procedure)
    {
        return view('procedures.edit', compact('procedure'));
    }

    public function update(ProcedureRequest $request, Procedure $procedure)
    {
        $procedure->update($request->all());
        return redirect()->route('procedures.index')->withStatus(__('Procedure successfully updated.'));
    }

    public function destroy(Procedure $procedure)
    {
        try{
            $procedure->delete();
        }catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == 23000){
                return redirect()->route('procedures.index')->withStatusError(__('This procedure has active tests. Delete the tests first in order to delete the procedure.'));
            }

            throw $e;
        }
        return redirect()->route('procedures.index')->withStatus(__('Procedure successfully deleted.'));
    }
}

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
        if(!Gate::allows('manage-procedures'))
            abort(403,__('Unauthorized action'));
    }
    public function index(Procedure $model)
    {
        return view('procedures.index',['procedures'=>$model->all()]);
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
        $procedure->delete();
        return redirect()->route('procedures.index')->withStatus(__('Procedure successfully deleted.'));
    }
}

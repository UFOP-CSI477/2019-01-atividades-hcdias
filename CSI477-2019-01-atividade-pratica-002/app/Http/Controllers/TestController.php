<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;
use App\Procedure;
use App\Http\Requests\TestRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TestController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(Gate::denies('manage-tests')){
                abort(403,__('Unauthorized action'));
            }

            return $next($request);
        });
    }
    
    public function index(Test $model)
    {
        if(Gate::allows('manage-my-tests')){
            $procedures = Procedure::whereHas('tests',function($query){
                $query->where('user_id',Auth::user()->id);
            })
            ->orderby('name','asc')
            ->get();
            //filtra os testes do usuario. Deveria ser join, mas sem tempo irmão
            foreach($procedures as &$procedure){
                $procedure->tests = $procedure->tests->filter(function($test){
                    return $test->user_id == Auth::user()->id;
                });
            }
        }else{
            $procedures = Procedure::all();
            $procedures->sortBy('name');
        }

        $totalTests = 0;
        $totalPrice = 0;
        foreach($procedures as &$procedure){
            $procedure->tests = $procedure->tests->sortByDesc('date');
            $count = $procedure->tests->count();
            $totalTests += $count;
            $totalPrice += $procedure->price * $count;
        }

        return view('tests.index',[
            'procedures'=>$procedures,
            'totalTests'=>$totalTests,
            'totalPrice'=>number_format($totalPrice,2,',','.')
        ]);    
    }

    public function create()
    {
        return view('tests.create');
    }

    public function store(TestRequest $request, Test $model)
    {
        $proceduresDate = (new \ArrayObject($request->input('date')))->getIterator();
        $procedures = (new \ArrayObject($request->input('test')))->getIterator();
        $dbData = [];
        while( ($procData = $proceduresDate->current()) && ($proc = $procedures->current()) ){
            $dbData[] = [
                'procedure_id'=>$proc,
                'date'=> (\DateTime::createFromFormat('d/m/Y H:i',$procData))->format('Y-m-d H:i:s'),
                'user_id'=>Auth::user()->id,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ];

            $proceduresDate->next();
            $procedures->next();
        }
        
        $result = $model->insert($dbData);
        
        return json_encode(['status'=>$result]);
    }

    public function edit(Test $test)
    {
        return view('tests.edit', compact('test'));
    }

    public function update(TestRequest $request, Test $test)
    {
        $test->update($request->merge([
            'date'=>(\DateTime::createFromFormat('d/m/Y H:i',$request->input('date')))->format('Y-m-d H:i:s')
        ])->all());

        return redirect()->route('tests.index')->withStatus(__('Test successfully updated.'));
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('tests.index')->withStatus(__('Test successfully deleted.'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class FirstController extends Controller
{
//    public function tt($args=[]){
//        $args = func_get_args();
//        dump($args);
//    }
    //
    public function test(InterfaceTest $interfaceTest,Request $request){
        return 222;
//        return 22343243232;
//        $select = DB::table('first')->where([
//            ['id','>',1],
//            ['name','=',1]
//        ])->get();
//        dump($select);
//        $this->fdsfds();
//        throw new \PDOException('fsdfdsfds');
//        $A = new fsdfsdfsdfsddfs();

        //过滤函数
//        $a = [
//          'tst','dds','','learn','test',''
//        ];
//        $b = array_filter($a,function($value){
//            return false;
//        });
//        dump($b);
//        echo __FUNCTION__;
//        $function = 2;
//        $columns = 333;
//        dump(compact('function', 'columns','ddfdf'));
//        dump(clone $this);
//        $this->tt(['a','b','c']);
//        $a = $_ENV;
//        dump($a);
//        $result = $interfaceTest->all();
//        dump($result);
//        dump($request->input());
//        dump(config('test'));
//        dump(basename('/config/app.php','.php'));
//        $request = DB::table('first')->first();
//        var_dump($request[0]);
//        dump($request[0]);

//       $first = DB::table('first')->get();
//       dump($first);
//       $line = DB::table('first')->where('id','=',1)->first();
//       $value = DB::table('first')->where('id','=',1)->value('name');
//       dump($line);
//       dump($value);
//       $pluck = DB::table('first')->pluck('name');
//       dump($pluck);
//       dump($pluck[0]);
//       $chunk = DB::table('first')->orderBy('id','asc')->chunk(2,function($group){
//            foreach ($group as &$value) {
//                if($value->id>2){
//                    return false;
//                }
//                DB::table('first')->where('id', '=', $value->id)->update(['name' => $value->name . '--']);
//            }
//       });
//       dump($chunk);
//       $result = DB::table('first')->select(['id','name'])->get();
//       $result = DB::table('first')->select('id','name')->get();
//       $result = DB::table('first')->selectRaw('id,inter')->get();
//       $result = DB::table('first')->selectRaw('id,inter as mylike')->get();
//       $result = DB::table('first')->selectRaw('id,inter mylike')->get();
//       $result = DB::table('first')->select('id','inter as mylike')->get();
//       $result = DB::table('first')->select(['id','name as mylike'])->get();
//       $result = DB::table('first')->select(DB::raw('id,name as mylike,inter as intertwo'))->get();
//       dump($result);
//        $count = DB::table('first')->count('id');
//        $max = DB::table('first')->max('id');
//        $min = DB::table('first')->min('id');
//        $avg = DB::table('first')->avg('id');
//        $sum = DB::table('first')->sum('id');
//        dump($count);
//        dump($max);
//        dump($min);
//        dump($avg);
//        dump($sum);
//        $join = DB::table('first')->where('first.id','=',1)
//                ->select(DB::raw('first.*,first_extend.*,first_extend.id as iid'))
//                ->join('first_extend','first_extend.first_id','=','first.id')
//                ->first();
//        $join = DB::table('first as f')->where('f.id','=',1)
//            ->select(DB::raw('f.*,fe.*,fe.id as iid'))
//            ->join('first_extend as fe','fe.first_id','=','f.id')
//            ->first();
//        $join = DB::table('first as f')->where('f.id','=',1)
//            ->select(DB::raw('f.*,fe.*,fe.id as iid'))
//            ->leftjoin('first_extend as fe','fe.first_id','=','f.id')
//            ->first();
//        $join = DB::table('first as f')->where('f.id','=',1)
//                ->select(DB::raw('f.*,fe.*,fe.id as iid'))
//                ->join('first_extend as fe',function($join){
//                    $join->on('fe.first_id','=','f.id');
//                })->first();
//        dump($join);
//        $first = DB::table('first')->where('id','>',3)->where('id','<',1)->get();
//        dump($first);
//        $pluck = DB::table('first')->pluck('id');
//        dump($pluck);
//        $extend = DB::table('first_extend')->whereIn('id',$pluck)->get();
//        dump($extend);
//        $exist = DB::table('first')
//                ->whereExists(function($query){
//                    $query->from('first_extend')->where('id','>=',1);
//                })->get();
//        dump($exist);
//        $first = DB::table('first')->orderBy('id','desc')->get();
//        $first = DB::table('first')->inRandomOrder()->get();
//        $first = DB::table('first')->skip(1)->take(2)->get();
//        dump($first);
        //条件子句
//        $id = '';
//        $first = DB::table('first')->when($id,function($query)use($id){
//            return $query->where('id','=',$id);
//        },function($query){
//            return $query->where('id','>',2);
//        })->get();
//        dump($first);
//        $insert = DB::table('first')->insert([
//            ['name'=>'insert1','inter'=>'fsdf'],
//            ['name'=>'insert2','inter'=>'fsdf'],
//            ['name'=>'insert3','inter'=>'fsdf'],
//            ['name'=>'insert4','inter'=>'fsdf'],
//        ]);
//        $insert = DB::table('first')->insertGetId(
//            ['name'=>'insert1','inter'=>'fsdf']);
//        dump($insert);
//        $update = DB::table('first')->where('id','=',1)->update(['name'=>'修改了']);
//        dump($update);
//        dump(__LINE__);
//        dump(__FILE__);
//        dump(__DIR__);
//        dump(__FUNCTION__);
//        dump(__CLASS__);
//        dump(__METHOD__);
//        dump(__NAMESPACE__);
//       if (is_null($a = null)){
//           echo 'null';
//       }else{
//           echo 'not null';
//       }
//        dump($this);

//        dump(1111);





    }
}

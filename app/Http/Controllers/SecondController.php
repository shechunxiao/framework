<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class SecondController extends Controller{
    public function index(){
//        $result = DB::table('first')->selectRaw('id,name,inter')->where('id','>',10)->pluck('id','name');
//        dump($result);
//        $result2 = DB::table('first')->where('id','>',10000)->first();
//        dump($result2);
//        if ($result2){
//            echo '不为空';
//        }else{
//            echo '空';
//        }
//        $result = DB::table('first as f')->selectRaw('f.*,fe.*,fe.id as feid')->leftJoin('first_extend as fe','f.id','=','fe.first_id')->first();
//        $result = DB::table('first as f')->select(DB::raw('f.*,fe.*,fe.id as feid'))->leftJoin('first_extend as fe','f.id','=','fe.first_id')->first();
//        dump($result);
//        $result = DB::table('first as f')->where(function($query){
//            $query->where('id','=',13)->orWhere('id','=',14);
//        })->get();
//        dump($result);
//        $result = DB::table('first as f')->where(function($query){
//            $query->where('name','=','zhangsan')->orWhere('name','=','lisi');
//        })->orderBy('id','asc')->get();
//        dump($result);
//        $result = DB::table('first as f')->whereIn('id',[3,13,14])->get();
//        $result = DB::table('first as f')->whereNotIn('id',[3,13,14])->get();
//        $result = DB::table('first as f')->whereNotBetween('id',[1,10])->get();
//        $result = DB::table('first as f')->wheretBetween('id',[1,10])->get();
//        $result = DB::table('first as f')->whereNull('test')->get();
//        $result = DB::table('first as f')->whereNotNull('test')->get();
//        $result = DB::table('first as f')->whereNotNull('DateOfBirth')->whereDate('DateOfBirth','2020-03-14')->get();
//        $result = DB::table('first as f')->whereNotNull('test')->whereColumn('DateOfBirth','<','test')->get();
//        $result = DB::table('first as f')->whereNotNull('test')->whereColumn('inter','<','test')->get();
//        $result = DB::table('first as f')->whereColumn('inter','<','test')->get();
//        $result = DB::table('first as f')->whereExists(function($query){
//            $query->from('first_extend as fe')->where('fe.id','<',10);
//        })->get();
//        $role = null;
//        $result = DB::table('first as f')->when($role,function($query) use ($role){
//            return $query->where('id','>',$role);
//        },function($query){
//            return $query->where('id','=',3);
//        })->get();
//        $result = DB::table('first')->where('id','>',15)->pluck('name','id');
//        $result = DB::table('first')->count('*');
//        $model = DB::table('first');
//        $result = $model->get();
//        $count = $model->count();
//        dump($result);
//        dump($count);
//        $result = DB::table('first')->select('name')->distinct()->get();
//        $result = DB::table('first')->whereNotNull('DateOfBirth')->whereDay('DateOfBirth','17')->get();
//        $result = DB::table('first')->whereColumn('inter','!=','test')->get();
//        $result = DB::table('first')->offset(10)->limit(3)->get();
//        dump($result);
//        DB::table('first')->insert(['name'=>'导入','inter'=>100]);
//        $result = DB::table('first')->insertGetId(['name'=>'导入并获取ID','inter'=>100]);
//      $result = DB::table('first')->where('id','=',30)->increment('inter',5);
//      $result = DB::table('first')->where('id','=',30)->decrement('inter',5,['name'=>'更新字段并且更新其他的','test'=>1]);
//        $result = DB::table('first')->where('id','>',1)->get();
//        $re = $result->filter(function($value,$key){
//            if (empty($value->test)){
//                return false;
//            }else{
//                return true;
//            }
//        })->last();
//        $re = $result->toJson();
//        dump($re);
//        return $re;
//        $basename = basename('D://dd/test.txt');
//        dump($basename);
        $result = bcdiv(1.98,10.1,10);
        dump($result);
    }



}
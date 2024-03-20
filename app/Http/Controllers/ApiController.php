<?php

namespace App\Http\Controllers;

use App\Library\Res;
use App\Models\Shaver;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ServiceCategory;

class ApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
     public function shaver(Request $req)
     {
         try {
             $data = Shaver::where('active', '1')
                            ->orderBy('shaver_name', 'ASC') 
                            ->get();
             return Res::success($data, 'Data Shaver');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function service_category(Request $req)
     {
         try {
             $data = ServiceCategory::where('active', '1')->get();
             return Res::success($data, 'Data Category Shaver');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function service(Request $req)
     {
         try {
             $category = $req->category;
             $data = null;
             if ($category == 'all'){
                $data = Service::where('active', '1')->get();
             } else {
                $data = Service::where('active', '1')
                                    ->where('category_id',$category)                   
                                    ->get();
             }
             return Res::success($data, 'Data Category Shaver');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function booking(Request $request)
     {
         try {
             $data = Booking::join('service_categories as b', 'bookings.category_id', '=', 'b.id')
                                     ->join('general_settings as c', 'bookings.status', '=', 'c.value')
                                     ->join('general_settings as d', 'bookings.status', '=', 'c.value')                                    
                                     ->where('user_id',auth()->user()->id)
                                     ->where('b.code','STS')
                                     ->where('c.code', 'PAYMENT')
                                     ->orderBy('bookings.id', 'DESC') 
                                     ->whereDate('bookings.created_at', '>', Carbon::now()->subDays(30)) 
                                     ->get(['bookings.id','bookings.note','bookings.category_id','bookings.price','b.description as category','bookings.created_at', 'd.description as status']);
             return Res::success($data, 'Data Booking');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
    //  public function booking(Request $request)
    //  {
    //      try {
    //          $data = Shaver::join('general_settings as b', 'bookings.category', '=', 'b.value')
    //                                  ->join('general_settings as d', 'bookings.status', '=', 'd.value')                                    
    //                                  ->where('user_id',auth()->user()->id)
    //                                  ->where('b.code','CATEGORYWALLET')
    //                                  ->where('d.code', 'STATUSTRANS')
    //                                  ->orderBy('bookings.id', 'DESC') 
    //                                  ->whereDate('bookings.created_at', '>', Carbon::now()->subDays(30)) 
    //                                  ->get(['bookings.id','bookings.description','bookings.inv_id','bookings.amount','b.description as category','bookings.created_at', 'd.description as status']);
    //          return Res::success($data, 'Data transaksi wallet');
    //      } catch (\Throwable $th) {
    //          return Res::error('Internal Server', 'Server Error');
    //      } 
    //  }
}

<?php

namespace App\Http\Controllers;

use App\Library\Res;
use App\Models\Shaver;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ServiceCategory;
use App\Models\User;

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
     public function history(Request $req)
     {
         try {
             $data = Booking::join('service_categories as b', 'bookings.category_id', '=', 'b.id')
                                     ->join('general_settings as c', 'bookings.status', '=', 'c.value')                                     
                                     ->join('services as d', 'bookings.service_id', '=', 'd.id')
                                     ->join('shavers as e', 'bookings.shaver_id', '=', 'e.id')
                                     ->where('user_id',auth()->user()->id)
                                     ->where('c.code','STS')
                                     ->orderBy('bookings.id', 'DESC') 
                                     ->whereDate('bookings.created_at', '>', Carbon::now()->subDays(30)) 
                                     ->get(['bookings.id',   
                                            'b.category_name as category',
                                            'd.service_name as service',
                                            'e.shaver_name as shaver',
                                            'bookings.price',
                                            'bookings.date',                                            
                                            'bookings.time',
                                            'bookings.payment_methode',
                                            'bookings.note',
                                            'c.description as status',
                                            'bookings.created_at'
                                        ]);
             return Res::success($data, 'Data Booking');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function profile(Request $req)
     {
         try {
             //* CEK USER ACTIVE
            $user = User::whereId(auth()->user()->id)->where('active', '1')->first();
            if(is_null($user)){
                return Res::error(null, "User Not Found");
            }
             return Res::success($user, 'Data Profile');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
}

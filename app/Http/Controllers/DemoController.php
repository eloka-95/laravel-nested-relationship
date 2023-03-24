<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemoController extends Controller
{
    public function countries() {
        // $countries = DB::table('countries')
        //                 ->leftJoin(
        //                     'continents',
        //                     'continents.id',
        //                     '=',
        //                     'countries.continent_id'
        //                 )
        //                 ->select(
        //                     'countries.id',
        //                     'countries.name',
        //                     'countries.continent_id',
        //                     'continents.name as continent_name',
        //                 )
        //                 ->orderBy('countries.name', 'asc')
        //                 ->take(100)
        //                 ->get();
        $countries = Country::with('continent:id,name')
                            ->select(
                                'id',
                                'name',
                                'continent_id',
                            )
                            ->orderBy('name', 'asc')
                            ->take(100)
        ->get();

        return response()->json($countries);
    }

    public function continents() {
        $continents = Continent::with('countries')->get();

        return response()->json($continents);
    }

    public function profiles() {
        $profiles = Profile::with([
            'country:id,name as country_name,continent_id',
            'user:id,name as user_name',
            'country.continent:id,name as continent_name'
        ])
        ->select(
            'bio',
            'user_id',
            'country_id',
        )
        ->take(100)
        ->get();

        return response()->json($profiles);
    }
}

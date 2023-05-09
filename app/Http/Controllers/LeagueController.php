<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League;
use App\Models\admLeague;
use App\Models\TeamStats;
use Illuminate\Support\Facades\Request as Requests;

class LeagueController extends Controller
{
    public function index()
    {
        if(Requests::Input('filter') != null)
        {
            $data = League::where('type',Requests::Input('filter'))->orwhere('country',Requests::Input('filter'))->get();
        }
        else
        {
            $data = League::get();
        }
        $all = League::get(); //for filters
        return view('USER/league', compact('data', 'all'));
    }

    public function GetLeague()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/leagues?id=143&season=2022",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: api-football-v1.p.rapidapi.com",
                "X-RapidAPI-Key: 8518472a42msh40177d2a572eebdp12aa97jsn1fa3bf97846c"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


        $data = json_decode($response,true);
        $LeagueInfo = $data['response'];

        foreach($LeagueInfo as $info)
        {
            $league = new League;
            $league->name = $info['league']['name'];
            $league->type = $info['league']['type'];
            $league->country = $info['country']['name'];

            $seasons = $info['seasons'];
            foreach($seasons as $season)
            {
                $league->season = $season['year'];
                $league->start = $season['start'];
                $league->end = $season['end'];
            }

            $league->save();
        }
    }

    public function standings($name)
    {
        $data = TeamStats::where('league', $name)->get();
        foreach($data as $d)
        {
            $points = 3 * $d['wins'] + $d['ties'];
            $results[] = ['team' => $d['team'], 'points' => $points];
        }

        return view('USER/standings', compact('data', 'results', 'name'));
    }
}

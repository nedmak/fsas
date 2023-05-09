<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamStats;
use App\Models\admTeam;
use App\Models\admLeague;
use App\Models\admPlayerStas;
use Illuminate\Support\Facades\Request as Requests;

class TeamController extends Controller
{

    public function index()
    {
        if(Requests::Input('filter') != null)
        {
            $data = Team::where('country',Requests::Input('filter'))->get();
        }
        else
        {
            $data = Team::get();
        }
        $all = Team::get();
        return view('USER/team', compact('data', 'all'));
    }

    public function GetTeam()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/teams?league=140&season=2022",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: api-football-v1.p.rapidapi.com",
                "X-RapidAPI-Key: 8518472a42msh40177d2a572eebdp12aa97jsn1fa3bf97846c",
                "content-type: application/octet-stream"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $data = json_decode($response,true);
        $TeamInfo = $data['response'];

        foreach($TeamInfo as $info)
        {
            $team = new Team;
            $team->name = $info['team']['name'];
            $team->code = $info['team']['code'];
            $team->country = $info['team']['country'];
            $team->founded = $info['team']['founded'];
            $team->save();
        }
    }

    public function GetStats()
    {
        // Bundesliga #78
        // $team = array(157, 159, 160, 161, 162, 163, 164, 165, 167, 168, 169, 170, 172, 173, 174, 176, 182, 192);

        // Ligue 1 #61
        // $team = array(77, 79, 80, 81, 82, 83, 84, 85, 91, 93, 94, 95, 96, 97, 98, 99, 106, 108, 110, 116);

        // Serie A #135
        // $team = array(487, 488, 489, 492, 494, 496, 497, 498, 499, 500, 502, 503, 504, 505, 511, 514, 515, 520, 867, 1579);

        // La Liga #140
        // $team = array(529, 530, 531, 532, 533, 536, 538, 540, 541, 543, 546, 547, 548, 720, 723, 724, 727, 728, 797, 798);
        for($i = 0; $i < count($team); $i++)
        {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/teams/statistics?league=140&season=2022&team=" . $team[$i],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: api-football-v1.p.rapidapi.com",
                    "X-RapidAPI-Key: 8518472a42msh40177d2a572eebdp12aa97jsn1fa3bf97846c",
                    "content-type: application/octet-stream"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $data = json_decode($response,true);

            $stats = new TeamStats;
            $stats->league = $data['response']['league']['name'];
            $stats->season = $data['response']['league']['season'];
            $stats->team = $data['response']['team']['name'];
            $stats->form = substr($data['response']['form'], -5);
            $stats->played = $data['response']['fixtures']['played']['total'];
            $stats->wins = $data['response']['fixtures']['wins']['total'];
            $stats->ties = $data['response']['fixtures']['draws']['total'];
            $stats->loses = $data['response']['fixtures']['loses']['total'];
            $stats->goals = $data['response']['goals']['for']['total']['total'];
            $stats->goals_against = $data['response']['goals']['against']['total']['total'];
            $stats->clean_sheets = $data['response']['clean_sheet']['total'];

            $yellow = 0;
            $yellow = $yellow + $data['response']['cards']['yellow']['0-15']['total'];
            $yellow = $yellow + $data['response']['cards']['yellow']['16-30']['total'];
            $yellow = $yellow + $data['response']['cards']['yellow']['31-45']['total'];
            $yellow = $yellow + $data['response']['cards']['yellow']['46-60']['total'];
            $yellow = $yellow + $data['response']['cards']['yellow']['61-75']['total'];
            $yellow = $yellow + $data['response']['cards']['yellow']['76-90']['total'];
            $yellow = $yellow + $data['response']['cards']['yellow']['91-105']['total'];
            $yellow = $yellow + $data['response']['cards']['yellow']['106-120']['total'];
            $stats->yellow_cards = $yellow;

            $red = 0;
            $red = $red + $data['response']['cards']['red']['0-15']['total'];
            $red = $red + $data['response']['cards']['red']['16-30']['total'];
            $red = $red + $data['response']['cards']['red']['31-45']['total'];
            $red = $red + $data['response']['cards']['red']['46-60']['total'];
            $red = $red + $data['response']['cards']['red']['61-75']['total'];
            $red = $red + $data['response']['cards']['red']['76-90']['total'];
            $red = $red + $data['response']['cards']['red']['91-105']['total'];
            $red = $red + $data['response']['cards']['red']['106-120']['total'];
            $stats->red_cards = $red;

            $stats->save();
        }
    }

    public function indexStats($name)
    {
        $data = TeamStats::where('team', $name)->get();
        foreach($data as $d)
        {
            $league = $d['league'];
        }
        $all = TeamStats::where('league', $league)->get();

        $number = TeamStats::where('league', $league)->count('id');
        return view('USER/teamStats', compact('data', 'name', 'all', 'number'));
    }

    //------------------------------------------ ADMIN --------------------------------------------------

    public function indexADM(Request $req)
    {
        if(session()->has('id') == null)
        {
            return redirect('login');
        }
        else
        {
            $data = admTeam::where('userID', $req->session()->get('email'))->get();
            return view('ADMIN/admTeam', compact('data'));
        }
    }

    public function addTeam()
    {
        return view('ADMIN/addTeam');
    }

    public function saveTeam(Request $req)
    {
        $team = new admTeam;
        $team->name = $req->name;
        $team->userID = session()->get('email');
        $team->save();
        return redirect('admTeam');
    }

    public function editTeam($id)
    {
        $data = admTeam::where('id', $id)->get();
        return view('ADMIN/editTeam', compact('data'));
    }

    public function updateTeam(Request $req)
    {
        admTeam::where('id', $req->id)->update([
            'name'=>$req->name,
        ]);
        return redirect('admTeam');
    }

    public function deleteTeam($id)
    {
        admTeam::where('id', $id)->delete();
        return redirect('admTeam');
    }

    public function admTeamStats($id)
    {
        $data = admPlayerStas::where('teamID', $id)->get();
        $team = admTeam::select('name')->where('id', $id)->get();
        $number = admPlayerStas::where('teamID', $id)->distinct('fixtureID')->count('fixtureID');

        foreach($team as $t)
        {
            $name = $t->name;
        }

        return view('ADMIN/admTeamStats', compact('data', 'name', 'number'));
    }
}

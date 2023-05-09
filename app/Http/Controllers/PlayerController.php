<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\admPlayer;
use App\Models\admTeam;
use App\Models\PlayerStats;
use Illuminate\Support\Facades\Request as Requests;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeamExport;
use App\Imports\TeamImport;

class PlayerController extends Controller
{
    public function index()
    {
        if(Requests::Input('filter') != null)
        {
            $data = Player::where('position',Requests::Input('filter'))->orwhere('team',Requests::Input('filter'))->get();
        }
        else
        {
            $data = Player::get();
        }
        $all = Player::get();
        return view('USER/player', compact('data', 'all'));
    }

    public function GetPlayer()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/players/squads?team=66",
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
        $PlayerInfo = $data['response'];

        foreach($PlayerInfo as $info)
        {
            $team = $info['team']['name'];

            $Members = $info['players'];
            foreach($Members as $member)
            {
                $player = new Player;
                $player->name = $member['name'];
                $player->age = $member['age'];
                $player->number = $member['number'];
                $player->position = $member['position'];
                $player->team = $team;
                $player->save();
            }
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

        // Premier #39
        // $team = array(33, 34, 35, 36, 39, 40, 41, 42, 45, 46, 47, 48, 49, 50, 51, 52, 55, 63, 65, 66);

        for($i = 0; $i < count($team); $i++)
        {
            set_time_limit(240);

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/players?team=". $team[$i] ."&season=2022&page=3",
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

            $players = $data['response'];

            foreach ($players as $player) {
                $statsInfo = $player['statistics'];
                foreach ($statsInfo as $info) {
                    $stats = new PlayerStats;
                    $stats->name = $player['player']['name'];
                    $stats->league = $info['league']['name'];
                    $stats->season = $info['league']['season'];
                    $stats->app = $info['games']['appearences'] ?? 0;
                    $stats->min = $info['games']['minutes'] ?? 0;
                    $stats->rating = $info['games']['rating'] ?? 0;
                    $stats->sh_total = $info['shots']['total'] ?? 0;
                    $stats->sh_on_goal = $info['shots']['on'] ?? 0;
                    $stats->goals = $info['goals']['total'] ?? 0;
                    $stats->assists = $info['goals']['assists'] ?? 0;
                    $stats->passes = $info['passes']['total'] ?? 0;
                    $stats->key = $info['passes']['key'] ?? 0;
                    $stats->drb_a = $info['dribbles']['attempts'] ?? 0;
                    $stats->drb_succ = $info['dribbles']['success'] ?? 0;
                    $stats->yellow = $info['cards']['yellow'] ?? 0;
                    $stats->red = $info['cards']['red'] ?? 0;
                    $stats->save();
                }
            }
        }
    }

    public function indexStats($id)
    {
        $data = PlayerStats::where('name', $id)->first();
        $all = PlayerStats::where('league', $data->league)->get();
        $number = PlayerStats::where('league', $data->league)->count('id');
        return view('USER/playerStats', compact('data', 'all', 'number', 'id'));
    }

    public function teamPlayer($name)
    {
        if(Requests::Input('filter') != null)
        {
            $data = Player::where('team', $name)->where('position',Requests::Input('filter'))->get();
        }
        else
        {
            $data = Player::where('team', $name)->get();
        }
        return view('USER/teamPlayer', compact('data', 'name'));
    }

    // ----------------------ADMIN--------------------------

    public function indexADM()
    {
        if(session()->has('id') == null)
        {
            return redirect('login');
        }
        else
        {
            $data = admPlayer::where('userID', session()->get('email'))->get();
            $team = admTeam::get();
            return view('ADMIN/admPlayer', compact('data', 'team'));
        }
    }

    public function addPlayer()
    {
        $data = admTeam::where('userID', session()->get('email'))->get();
        return view('ADMIN/addPlayer', compact('data'));
    }

    public function savePlayer(Request $req)
    {
        $player = new admPlayer;
        $player->name = $req->name;
        $player->lastname = $req->lastname;
        $player->age = $req->age;
        $player->number = $req->number;
        $player->position = $req->position;
        $player->teamID = $req->team;
        $player->email = $req->email;
        $player->userID = session()->get('email');
        $player->save();
        return redirect('admPlayer');
    }

    public function editPlayer($id)
    {
        $data = admPlayer::where('id', $id)->get();
        $team = admTeam::where('userID', session()->get('email'))->get();
        return view('ADMIN/editPlayer', compact('data', 'team'));
    }

    public function updatePlayer(Request $req)
    {
        admPlayer::where('id', $req->id)->update([
            'name'=>$req->name,
            'lastname'=>$req->lastname,
            'age'=>$req->age,
            'number'=>$req->number,
            'position'=>$req->position,
            'teamID'=>$req->team,
            'email'=>$req->email,
        ]);
        return redirect('admPlayer');
    }

    public function deletePlayer($id)
    {
        admPlayer::where('id', $id)->delete();
        return redirect('admPlayer');
    }

    public function importPlayer(Request $req)
    {
        $path = $req->file('file')->getRealPath();
        Excel::import(new TeamImport(), $path);
        return redirect('admPlayer');
    }

    public function export()
    {
        return Excel::download(new TeamExport(), 'Players.xlsx');
    }

    public function teamPlayers($id)
    {
        $data = admPlayer::where('teamID', $id)->get();
        $team = admTeam::where('id',$id)->get();
        return view('ADMIN/admTeamPlayer', compact('data', 'team'));
    }
}

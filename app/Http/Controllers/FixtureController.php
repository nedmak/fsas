<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//-------------------------- Models ----------------------------
use App\Models\Fixture;
use App\Models\admFixture;
use App\Models\admTeam;
use App\Models\admPlayer;
use App\Models\FixtureStats;
use App\Models\admPlayerStas;

//-------------------------- Excel -----------------------------
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FixtureExport;
use App\Imports\StatsImport;

use App\Mail\StatsMail;
use Illuminate\Support\Facades\Mail;

class FixtureController extends Controller
{
    public function index()
    {
        $data = Fixture::get();
        return view('USER/fixture', compact('data'));
    }

    public function GetFixture()
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

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/fixtures?league=78&season=2022&from=2023-04-24&to=2023-05-01",
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
        $FixtureInfo = $data['response'];

        foreach($FixtureInfo as $info)
        {
            $fixture = new Fixture;
            $fixture->id = $info['fixture']['id'];
            $fixture->ref = $info['fixture']['referee'];
            $fixture->league = $info['league']['name'];
            $fixture->h_team = $info['teams']['home']['name'];
            $fixture->a_team = $info['teams']['away']['name'];
            $fixture->h_goals = $info['goals']['home'];
            $fixture->a_goals = $info['goals']['away'];
            $fixture->save();
        }
    }

    public function GetStats()
    {
        $data = Fixture::select('id')->where('league', 'Bundesliga')->get();
        foreach($data as $d)
        {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/fixtures/statistics?fixture=". $d['id'],
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
            $StatsInfo = $data['response'];

            $fk = $data['parameters']['fixture'];

            foreach($StatsInfo as $info)
            {
                $stats = new FixtureStats;
                $stats->team = $info['team']['name'];

                $all = $info['statistics'];
                foreach($all as $a)
                {
                    if($a['type'] == 'Shots on Goal')
                    {
                        $stats->sh_on_goal = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Shots off Goal')
                    {
                        $stats->sh_off_goal = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Total Shots')
                    {
                        $stats->sh_total = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Blocked Shots')
                    {
                        $stats->sh_bloked = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Shots insidebox')
                    {
                        $stats->sh_in_box = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Shots outsidebox')
                    {
                        $stats->sh_out_box = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Fouls')
                    {
                        $stats->fouls = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Corner Kicks')
                    {
                        $stats->corners = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Offsides')
                    {
                        $stats->offsides = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Ball Possession')
                    {
                        $stats->ball_possession = substr($a['value'], 0, 2) ?? 0;
                    }
                    if($a['type'] == 'Yellow Cards')
                    {
                        $stats->yellow = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Red Cards')
                    {
                        $stats->red = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Goalkeeper Saves')
                    {
                        $stats->saves = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Total passes')
                    {
                        $stats->passes = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Passes accurate')
                    {
                        $stats->acc_passes = $a['value'] ?? 0;
                    }
                    if($a['type'] == 'Passes %')
                    {
                        $stats->pass_proc = substr($a['value'], 0, 2) ?? 0;
                    }
                }
                $stats->fk = $fk;
                $stats->save();
            }
        }
    }

    public function indexStats($id)
    {
        $data = FixtureStats::where('fk','=',$id)->get();
        return view('USER/fixtureStats', compact('data'));
    }

    // -------------------------------------- ADMIN ---------------------------------------------

    public function indexADM()
    {
        if(session()->has('id') == null)
        {
            return redirect('login');
        }
        else
        {
            $data = admFixture::where('userID', session()->get('email'))->get();
            $team = admTeam::get();
            return view('ADMIN/admFixture', compact('data', 'team'));
        }
    }

    public function addFixture()
    {
        $data = admTeam::where('userID', session()->get('email'))->get();
        return view('ADMIN/addFixture', compact('data'));
    }

    public function saveFixture(Request $req)
    {
        $fixture = new admFixture;
        $fixture->h_team = $req->h_team;
        $fixture->a_team = $req->a_team;
        $fixture->date = $req->date;
        $fixture->userID = session()->get('email');
        $fixture->save();
        return redirect('admFixture');
    }

    public function editFixture($id)
    {
        $data = admFixture::where('id', $id)->get();
        $team = admTeam::get();
        return view('ADMIN/editFixture', compact('data', 'team'));
    }

    public function updateFixture(Request $req)
    {
        admFixture::where('id', $req->id)->update([
            'h_team'=>$req->h_team,
            'a_team'=>$req->a_team,
            'date'=>$req->date,
        ]);
        return redirect ('admFixture');
    }

    public function deleteFixture($id)
    {
        admFixture::where('id', $id)->delete();
        return redirect ('admFixture');
    }

    public function exportFixture($id)
    {
        session()->put('fixture', $id);
        return Excel::download(new FixtureExport(), 'Fixture.xlsx');
        session()->forget('fixture');
    }

    public function importFixture(Request $req)
    {
        session()->put('fixture', $req->fixture);
        $path = $req->file('file')->getRealPath();
        Excel::import(new StatsImport, $path);
        session()->forget('fixture');
        return redirect('admFixture');
    }

    public function admFixtureStats($id)
    {
        $fixture = admFixture::where('id', $id)->get();
        $stats = admPlayerStas::where('fixtureID', $id)->get();
        $team = admTeam::get();
        return view('ADMIN/admFixtureStats', compact('fixture', 'stats', 'team'));
    }

    public function email($id)
    {
        session()->put('fix', $id);
        $fixture = admFixture::where('id', $id)->get();
        $stats = admPlayerStas::where('fixtureID', $id)->get();
        $players = admPlayer::get();
        foreach($stats as $s)
        {
            foreach($players as $p)
            {
                if($s->name == $p->name && $s->lastname == $p->lastname)
                {
                    Mail::to($p->email)->send(new StatsMail());
                }
            }
        }
        session()->forget('fix');
        return redirect('admFixture');
    }

    public function emailStats($id)
    {
        $fixture = admFixture::where('id', $id)->get();
        $stats = admPlayerStas::where('fixtureID', $id)->get();
        $team = admTeam::get();
        return view('emails/emailStats', compact('fixture', 'stats', 'team'));
    }
}

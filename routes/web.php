<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\FixtureController;

// BLADES
Route::get('/', function () { return view('USER/main'); });
Route::get('/login', function () { return view('USER/login'); });
Route::get('/admin', function () { return view('ADMIN/admin'); });
Route::get('/back', function () { return back()->withInput(); });


// GOOGLE
Route::get('/auth/google/redirect', [GoogleController::class, 'handleGoogleRedirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/logout', [GoogleController::class, 'LogOut']);

// Teams
Route::get('/getTeams',[TeamController::class, 'GetTeam']);
Route::get('/teams',[TeamController::class, 'index']);
Route::get('/teamsF',[TeamController::class, 'filter']);
Route::get('/getTeamStats',[TeamController::class, 'GetStats']);
Route::get('/teamStats/{id}',[TeamController::class, 'indexStats']);

// Leagues
Route::get('/getLeagues',[LeagueController::class, 'GetLeague']);
Route::get('/leagues',[LeagueController::class, 'index']);
Route::get('/leaguesf',[LeagueController::class, 'filter']);
Route::get('/standings/{id}',[LeagueController::class, 'standings']);
Route::get('/leagueStats',function () { return view('USER/leagueStats');});

// Players
Route::get('/getPlayers',[PlayerController::class, 'GetPlayer']);
Route::get('/players',[PlayerController::class, 'index']);
Route::get('/teamPlayer/{id}',[PlayerController::class, 'teamPlayer']);
Route::get('/playersf',[PlayerController::class, 'filter']);
Route::get('/getPlayerStats',[PlayerController::class, 'GetStats']);
Route::get('/playerStats/{id}',[PlayerController::class, 'indexStats']);

// Fixtures
Route::get('/getFixtures',[FixtureController::class, 'GetFixture']);
Route::get('/fixtures',[FixtureController::class, 'index']);
Route::get('/getFixtureStats',[FixtureController::class, 'GetStats']);
Route::get('/fixtureStats/{id}',[FixtureController::class, 'indexStats']);

// USERS
Route::get('/Users',[UsersController::class, 'index']);
Route::get('/delete-user/{id}',[UsersController::class, 'delete']);

//---------------------------ADMIN-----------------------------

// Team
Route::get('/admTeam',[TeamController::class, 'indexADM']);
Route::get('/addTeam',[TeamController::class, 'addTeam']);
Route::post('/saveTeam',[TeamController::class, 'saveTeam']);
Route::get('/editTeam/{id}',[TeamController::class, 'editTeam']);
Route::post('/updateTeam',[TeamController::class, 'updateTeam']);
Route::get('/deleteTeam/{id}',[TeamController::class, 'deleteTeam']);
Route::get('/admTeamStats/{id}',[TeamController::class, 'admTeamStats']);

// Player
Route::get('/admPlayer',[PlayerController::class, 'indexADM']);
Route::get('/addPlayer',[PlayerController::class, 'addPlayer']);
Route::post('/savePlayer',[PlayerController::class, 'savePlayer']);
Route::get('/editPlayer/{id}',[PlayerController::class, 'editPlayer']);
Route::post('/updatePlayer',[PlayerController::class, 'updatePlayer']);
Route::get('/deletePlayer/{id}',[PlayerController::class, 'deletePlayer']);
Route::post('/importPlayer',[PlayerController::class, 'importPlayer']);
Route::get('/teamPlayers/{id}',[PlayerController::class, 'teamPlayers']);
Route::get('/export',[PlayerController::class, 'export']);

// Fixture
Route::get('/admFixture',[FixtureController::class, 'indexADM']);
Route::get('/addFixture',[FixtureController::class, 'addFixture']);
Route::post('/saveFixture',[FixtureController::class, 'saveFixture']);
Route::get('/exportFixture/{id}',[FixtureController::class, 'exportFixture']);
Route::post('/importFixture',[FixtureController::class, 'importFixture']);
Route::get('/admFixtureStats/{id}',[FixtureController::class, 'admFixtureStats']);
Route::get('/editFixture/{id}',[FixtureController::class, 'editFixture']);
Route::post('/updateFixture',[FixtureController::class, 'updateFixture']);
Route::get('/deleteFixture/{id}',[FixtureController::class, 'deleteFixture']);

// Mailing
Route::get('/email/{id}',[FixtureController::class, 'email']);
Route::get('/emailStats/{id}',[FixtureController::class, 'emailStats']);

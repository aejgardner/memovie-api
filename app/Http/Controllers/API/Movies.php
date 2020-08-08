<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\MovieRequest;
use App\Http\Resources\API\MovieResource;
use App\Movie;

class Movies extends Controller
{

    // protected $movie;

    public function __construct()
    {
        $this->middleware('auth:users');
    }
    /**
     * Display a listing of the movies.
     
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth("users")->authenticate($request->token);
        $user_id = $user->id;

        $movies = Movie::where("user_id", $user_id)->get();

        return response()->json([
            "success" => true,
            "data" => $movies,
        ], 200);
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {
        $movie = new Movie;

        $user_token = $request->token;
        $user = auth("users")->authenticate($user_token);
        $user_id = $user->id;

        $movie->user_id = $user_id;
        $movie->movieTitle = $request->movieTitle;
        $movie->movieDirector = $request->movieDirector;
        $movie->movieGenre = $request->movieGenre;
        $movie->movieCast = $request->movieCast;
        $movie->save();

        return new MovieResource($movie);
    }

    /**
     * Display the specified movie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MovieRequest $request, $movie)
    {
        $findData = Movie::find($movie);

        $findData->movieTitle = $request->movieTitle;
        $findData->movieDirector = $request->movieDirector;
        $findData->movieGenre = $request->movieGenre;
        $findData->movieCast = $request->movieCast;
        $findData->movieWatched = $request->movieWatched;
        $findData->save();

        return response()->json([
            "success" => true,
            "message" => "movie updated successfully",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        // use a 204 code as there is no content in the response
        return response(null, 204);
    }
}

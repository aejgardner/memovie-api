<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\MovieRequest;
use App\Http\Resources\API\MovieResource;
use App\Movie;
use App\User;

class Movies extends Controller
{
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
        $user = auth("users")->authenticate($request->bearerToken());
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

        $user = auth("users")->authenticate($request->bearerToken());
        $user_id = $user->id;

        $movie->user_id = $user_id;
        $movie->movieTitle = $request->movieTitle;
        $movie->movieDirector = $request->movieDirector;
        $movie->movieGenre = $request->movieGenre;
        $movie->movieCast = $request->movieCast;
        $movie->movieWatched = $request->movieWatched;
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
     * Delete all movies in the database
     */
    // passed through an id, id is of a user ,route model binding will look for id
    public function clear(Request $request)
    {
        $user = auth("users")->authenticate($request->bearerToken());
        $user_id = $user->id;

        Movie::where("user_id", $user_id)->delete();

        return response(null, 204);
    }

    /**
     * Update the specified movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MovieRequest $request, Movie $movie)
    {
        $data = $request->only([
            "movieTitle",
            "movieDirector",
            "movieGenre",
            "movieCast",
            "movieWatched",
            "user_id"
        ]);

        // update the movie
        $movie->fill($data)->save();

        return new MovieResource($movie);
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

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Request\API\MovieRequest;
use App\Http\Resources\API\MovieResource;
use App\Movie;

class Movies extends Controller
{

    protected $movie;

    public function __construct()
    {
        $this->middleware('auth:users');
        $this->movie = new Movie;
    }
    /**
     * Display a listing of the movies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_token = $request->token;
        $user = auth("users")->authenticate($user_token);
        $user_id = $user->id;

        $this->movie->user_id = $user_id;
        $this->movie->movieTitle = $request->movieTitle;
        $this->movie->movieDirector = $request->movieDirector;
        $this->movie->movieGenre = $request->movieGenre;
        $this->movie->movieCast = $request->movieCast;
        $this->movie->save();

        return response()->json([
            "success" => true,
            "message" => "movie saved successfully"
        ], 200);
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
    public function update(Request $request, $movie)
    {
        // get the request data
        $data = $request->all();

        // update the player
        $movie->fill($data)->save();

        // return the updated movie in the resource format
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

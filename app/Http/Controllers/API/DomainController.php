<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Domain;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : Response
    {
        // CODE CHALLENGE: Search Filter
        $domains = Domain::all();
        // Create HTTP response, 200 ok.
        $response = new Response($domains, Response::HTTP_OK);
        // Return HTTP response.
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) : Response
    {
        // CODE CHALLENGE: Add Domains
        $validatedData = $request->validate([
        'domains' => 'required'
        ]);
        $domains = $request->domains;
        foreach ($domains as $domain) {
        $domain = Domain::create(['domain_name' => $domain]);
        }
        return response(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) : Response
    {
        // CODE CHALLENGE: Toggle Imprint
        $validatedData = $request->validate([
        'is_imprinted' => 'required|boolean'
        ]);
        $domain = Domain::find($id);
        $domain->is_imprinted = $request->is_imprinted;
        $domain->save();
        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) : Response
    {
        // CODE CHALLENGE: Delete Domains
        $domain = Domain::find($id);
        $domain->delete();
        return response(200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFederationRequest;
use App\Http\Requests\UpdateFederationRequest;
use App\Models\Country;
use App\Models\Federation;

class FederationController extends Controller
{
    /**
     * Display a listing of --
     */
    public function index()
    {
        ds('Controller ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' called');
        $federationSet = Federation::countryIdSorted();
        ds('Controller ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' federationList:' . json_encode($federationSet));
        return view('livewire.federation.listed', ['federationSet' => $federationSet]);
    }

    /**
     * Show the form for creating a new --
     */
    public function create()
    {
        ds('Controller ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' called');
        $countries = Country::countriesSorted();
        return view('livewire.federation.add', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFederationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Federation $federation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Federation $federation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFederationRequest $request, Federation $federation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Federation $federation)
    {
        //
    }
}

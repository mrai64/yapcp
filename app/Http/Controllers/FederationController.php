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
        return view('federations.listed', ['federationSet' => $federationSet]);
    }

    /**
     * Show the form for creating a new --
     */
    public function create()
    {
        ds('Controller ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' called');
        $federationName = '';
        $federationId = '';
        $website = '';
        $countryId = 'ITA';
        $contactInfo = '';
        $countries = Country::countriesSorted();
        return view('federations.add', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFederationRequest $request)
    {
        ds('Controller ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        ds($request->all());
        // already checked in \StoreFederationController
        $validated = $request->validated();

        ds('Controller ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' validated:' . json_encode($validated));
        $created = Federation::create([
            'name_en' => $validated['federationName'],
            'id' => $validated['federationId'],
            'website' => $validated['website'],
            'country_id' => $validated['countryId'],
            'contact_info' => $validated['contactInfo'],
            'timezone_id' => 'Europe/Rome', // default - TODO add to form referred to HQ
        ]);

        ds('Controller ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' created:' . json_encode($created));
        // then add yourself as federation member? no, you are admin

        return redirect()
            ->route('federation.list')
            ->with(
                key: 'success',
                value: __('New Federation added to list. Now add other info about new federation')
            );
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

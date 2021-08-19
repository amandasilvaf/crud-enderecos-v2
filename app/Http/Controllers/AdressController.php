<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Enums\TipoEndereco;
use App\Models\Adress;
use App\Models\TipoEndereco;

class AdressController extends Controller
{
    
    public function getType()
    {
        // $tipos = TipoEndereco::getValues();
        $tipos = TipoEndereco::all();
        return json_encode($tipos);

    }

    public function getAdresses()
    {
        $adresses = Adress::all();
        return json_encode($adresses);

    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

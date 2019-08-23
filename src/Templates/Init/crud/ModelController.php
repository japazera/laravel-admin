<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\[MODEL];

class [MODEL]Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.[MODEL_LOWER].index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		return view('admin.[MODEL_LOWER].create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate($request, [
[FIELDS_VALIDATION]
		]);

        $[MODEL_LOWER] = new [MODEL]($request->all());

        $[MODEL_LOWER]->save();

        return redirect()->route('[MODEL_LOWER].index')->with('success', '[MODEL] created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit([MODEL] $[MODEL_LOWER])
    {
        return view('admin.[MODEL_LOWER].edit', compact('[MODEL_LOWER]'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, [MODEL] $[MODEL_LOWER])
    {
        $this->validate($request, [
[FIELDS_VALIDATION]
		]);

        $[MODEL_LOWER]->update($request->all());

        return redirect()->route('[MODEL_LOWER].index')->with('success', '[MODEL] updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy([MODEL] $[MODEL_LOWER])
    {
        $[MODEL_LOWER]->delete();

        return redirect()->route('[MODEL_LOWER].index')->with('success', '[MODEL] destroyed.');
    }
}

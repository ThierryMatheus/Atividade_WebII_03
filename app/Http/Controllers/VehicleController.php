<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Contracts\Validation\Rule as ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(3);

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'board' => 'required|unique:vehicles|max:8|min:8|',
            'model' => 'required|max:255',
            'color' => 'required|max:255',
            'year' => 'required|max:4'
        ]);
        $vehicle = new Vehicle($validatedData);

        $vehicle->user_id = Auth::id();

        $vehicle->save();

        return redirect('vehicles')->with('sucess', 'Vehicle created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        if ($vehicle->user_id === Auth::id()) {
            return view('vehicles.edit', compact('vehicle'));
        } else {
            redirect()->route('vehicles.index')
                ->with('error', "You can't edit this post because are not author")->withInput();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validatedData = $request->validate([
            'board' => ['required', Rule::unique('vehicles')->ignore($vehicle), 'max:8', 'min:8'],
            'model' => ['required', Rule::unique('vehicles')->ignore($vehicle), 'max:255'],
            'color' => ['required', Rule::unique('vehicles')->ignore($vehicle), 'max:255'],
            'year' => ['required', Rule::unique('vehicles')->ignore($vehicle), 'size:4', 'integer', 'max:2020'],
        ]);

        if ($vehicle->user_id === Auth::id()) {
            $vehicle->update($validatedData);
            return redirect()->route('vehicles.index')->with('sucess', 'Vehicle successfully updated');
        } else {
            redirect()->route('vehicles.index')
                ->with('error', "You can't edit this post because are not author")->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->user_id === Auth::id()) {
            $vehicle->delete();
            return redirect()->route('vehicles.index')->with('sucess', 'Vehicle successfully deleted');
        } else {
            redirect()->route('vehicles.index')->with('error', "You can't delete this post because are not author")->withInput();
        }
    }
}

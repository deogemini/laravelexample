<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Rules\Uppercase;
use App\Http\Requests\CreateValidationRequest;
class CarsController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       // SELECT* FROM CARS

       //but in eloquent

    $cars = Car::all();
       // select * from

       //select specific
// $cars = Car::where('name', '=', 'Audi')->get();
//$cars = Car::where('name', '=', 'Audi')->firstOrFail();

//when want to count one matches
//print_r(Car::where('name', 'Audi')->count());

//when want to count all connections we have
//print_r(Car::all()->count());

// when want sum
//print_r(Car::sum('founded'));

//when want to get an average




//wehen want to chunck
// $cars= Car::chunk(2, function($cars){
// foreach($cars as $car){

//     print_r($car);

// }
// });

////////json

// $cars = Car::all()->toJson();
// $cars = json_decode($cars);
// var_dump($cars);
//////////




return view('cars.index',
[
    'cars' => $cars
]);

    }

    //     return view('cars.index', [
    //         'cars' => $cars
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //methods we can use on $request
        //1. guessextension()
        //2.getMimeType()

        //there is some of store methods
        //store()
        //asStore()
        //storePublicly()
        //move()
        //getClientOriginialName()
        //getSize() helps to get size of an image
        //to validate  we will use  getError()


      //  $test= $request->file('image')->guessExtension();
     // $test= $request->file('image')->getMimeType();
   //  $test = $request->file('image')->getClientOriginalName();



        $request->validate([
            'name' => 'required',
            'founded' => 'required|integer|min:0|max:2021',
            'description' => 'required',
            'image' => 'required||mimes:jpg,jpeg, png|max:5048'


        ]);

        $newImageName  = time(). '-'.$request->name.'.'.
        $request->image->extension();


    $request->image->move(public_path('images'), $newImageName);

        //to validate request through our controllers
        // $request->validate([
        //     'name' => new Uppercase,
        //     'founded' => 'required||integer|min:0|max:2021',
        //     'descrpition' => 'required'
        // ]);
        //if it is valid, it will proceed
        //if it's not valid, through a ValidationException

  ////////////      //first way to save data in database   //////////
        //  $car = new Car;
        //  $car->name = $request->input('name');
        //  $car->founded= $request->input('founded');
        //  $car->description= $request->input('description');
        //  $car->image_path = $newImageName;
        //  $car->user_id=>auth()->user()->id;

        //  $car->save();

        $car = Car::create([
            'name' => $request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request->input('description'),
            'image_path' => $newImageName,
            'user_id' => auth()->user()->id
        ]);
         return redirect('cars');
// ------------------------------------------------------------------------------

        ///// //second way to serve data into database   ////
        //  $car= Car::make([
        //     'name' =>$request->input('name'),
        //     'founded' => $request->input('founded'),
        //     'decription' => $request-> input('description')
        // ]);
        // $car->save();
        // return redirect('cars');

        // // dd('OK');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);

        return view('cars.show') ->with('car', $car);
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
$car = Car::find($id);
return view('cars.edit')->with('car', $car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateValidationRequest $request, $id)
    {

        $request->validate();
            $car= Car::where('id', $id)->update([
            'name' =>$request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request-> input('description')
        ]);
        return redirect('cars');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {

        $car->delete();
        return redirect('/cars');
    }
}

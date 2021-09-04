<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models';

    protected $primaryKey = 'id';


    //A car model belong to a car
    public function car(){
        return $this->belongsTo(Car::class);

    }

    public function headquarter(){
        return $this->hasOne(Headquarter::class);
    }

    // //Define a has many through relationship
    // public function engines(){
    //     return $this-> hasManyThrough(Engine::class, CarModel::class,
    //     'car_id',//foreign key ob CarModel table
    //     'model_id'//Foreign key on Engine table
    // );
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $table = 'cars';

    protected $primaryKey = 'id';

    //to save data by second way
    protected $fillable = ['name', 'founded', 'description', 'image_path', 'user_id'];

  //  protected $date Format = 'h:m:s';

  //json to hide attribute
  protected $hidden = ['update_at'];

  //json to show atribute
  protected $visible = ['name', 'founded', 'description'];

  public function carmodels(){
      return $this->hasMany(CarModel::class);

  }

  public function engines(){
      return $this->hasManyThrough(
          Engine::class,
          CarModel::class,
        'car_id', //eign key on CarModel TABLE
        'model_id'  //foreign key on engine table

    );
  }

  //Define a has one through relatioship
  public function productionDate(){
      return $this->hasOneThrough(
          CarProductionDate::class,
          CarModel::class,
          'car_id',
          'model_id'
      );
  }

  public function products(){
      return $this->belongsToMany(Product::class);
  }

}

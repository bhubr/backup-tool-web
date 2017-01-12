<?php
namespace bhubr\HashBack\Model;
use Illuminate\Database\Eloquent\Model;

class Host extends Model {
  protected $fillable = ['name', 'ip'];


  /**
   * The volumes it has
   */
  public function volumes()
  {
      return $this->hasMany('App\Model\Volume');
  }
}
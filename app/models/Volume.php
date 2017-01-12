<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model {
  protected $fillable = ['name', 'mount_point', 'uuid'];

  /**
   * The volumes it has
   */
  public function host()
  {
      return $this->belongsTo('App\Model\Host');
  }
}
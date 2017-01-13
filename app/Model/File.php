<?php
namespace bhubr\HashBack\Model;
use Illuminate\Database\Eloquent\Model;

class File extends Model {
  protected $fillable = ['parent_id', 'name', 'type', 'md5', 'mp3_md5', 'volume_id'];

   /**
    * The volumes it has
    */
    public function parent()
    {
        return self::find($this->parent_id);
    }
}
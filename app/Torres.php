<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Torres extends Model
{
  protected $primaryKey = 'wt_id';
    public $timestamps = false;
    protected $table= 'wisp_tower';
    protected $fillable=["wt_nombre","wt_altura"];
    protected $geometry = ['wt_point'];

       /**
        * Select geometrical attributes as text from database.
        *
        * @var bool
        */
       protected $geometryAsText = true;

       /**
        * Get a new query builder for the model's table.
        * Manipulate in case we need to convert geometrical fields to text.
        *
        * @param  bool $excludeDeleted
        *
        * @return \Illuminate\Database\Eloquent\Builder
        */
    public function newQuery($excludeDeleted = true)
       {
           if (!empty($this->geometry) && $this->geometryAsText === true)
           {
               $raw = '';
               foreach ($this->geometry as $column)
               {
                   $raw .= 'ST_X(`'. $column . '`) as `wt_lat`, ST_Y(`'. $column . '`) as `wt_lng`';
               }


               return parent::newQuery($excludeDeleted)->addSelect('wt_id','wt_nombre','wt_altura', DB::raw($raw));
           }

           return parent::newQuery($excludeDeleted);
       }

}

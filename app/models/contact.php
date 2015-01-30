<?php
/**
 * Created by PhpStorm.
 * User: Mwaa
 * Date: 1/29/2015
 * Time: 8:00 PM
 */

use Illuminate\Database\Eloquent\SoftDeletingTrait;


class contact extends \Eloquent
{

    use SoftDeletingTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    protected $dates = ['deleted_at'];

    protected $fillable = ['owner_id', 'first_name', 'last_name', 'email', 'address', 'twitter'];


    protected function owner()
    {
        return $this->belongsTo('User');
    }


} 
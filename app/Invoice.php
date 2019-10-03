<?php
/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * @access protected 
     * @var array $fillable
     */
    protected $fillable = ['title', 'price', 'paid'];

    /**
     * @access public   
     * @desc Make relation with items.
     * @return \Illuminate\Http\Response
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'invoice_id');
    }
}

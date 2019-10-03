<?php
/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * @access public   
     * @desc Make relation with invoice.
     * @return \Illuminate\Http\Response
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

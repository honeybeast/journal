<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use Storage;

class FileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * @access public   
     * @desc Get file path.
     * @return \Illuminate\Http\Response
     */
    function getFile($filename)
    {
        $file_parts = explode('-', $filename);
        $user_id = $file_parts[0];
        $filename = implode('-', $file_parts);
        return Storage::download('uploads/articles/users/' . $user_id . '/' . $filename);

    }

}

<?php

namespace App\Http\Controllers\Api;


use App\Models\Position;

class PositionController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->jsonResponse(
            Position::all()
        );
    }
}

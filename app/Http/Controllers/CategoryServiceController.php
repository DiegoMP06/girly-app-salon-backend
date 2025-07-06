<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryServiceCollection;
use App\Models\CategoryService;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return new CategoryServiceCollection(CategoryService::all());
    }
}

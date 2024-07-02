<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use LDAP\Result;

class ProjectController extends Controller
{
  public function index()  {
    $projects = Project::with(['category', 'technologies'])->get();
    $data = [
        'result' => $projects,
        'success' => 'true',
    ];
    return response()->json($data);
  }

  public function show(string $slug) {
    $projects = Project::with(['category', 'technologies'])->where('slug', $slug)->first();
    if (!$projects) {
      return response()->json([
        'result' => false
      ], 404);
    }
    $data = [
      'result' => $projects,
    ];
    return response()->json($data);
  }
}

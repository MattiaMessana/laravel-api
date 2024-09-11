<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ? $request->per_page : 5;
        $user = Auth::id();
        // utilizzare la virgola serve per confrontare i due valori ->(potremmo fare anche cosi)->('user_id' , '=' , $user)
        $projectArray = Project::where('user_id', $user)->paginate($perPage)->appends(['per_page' => $perPage]);
        // dd($projectArray);
        return view('admin.project.index', compact('projectArray'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $categories = Category::all();
        $technologies = Technology::all();
        return view('admin.project.create', compact('categories', 'technologies', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // $data = $request->all();
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        //controlliamo se esiste il file cover_img nel request
        if ($request->hasFile('cover_img')) {
            //salvo file nella cartella storage
            $image_path = Storage::put('project_img', $request->cover_img);
            //salvo path del file da inserire nel databade
            $data['cover_img'] = $image_path;
        }

        $project = new Project();
        $project->fill($data);
        $project->slug = Str::slug($request->title);
        // dd($request->all(), $data, $project);
        $project->save();

        //aggiungo le tech se sono state selezionate
        if ($request->has('technologies')) {
            $project->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.project.show', ['project' => $project->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(404);
        }
        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(404);
        }

        $categories = Category::all();
        $technologies = Technology::all();

        return view('admin.project.edit', compact('project', 'categories', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        
        if ($project->user_id !== Auth::id()) {
            abort(404);
        }
        // dd($request['removeImage']);
        // $data = $request->all();
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        //controllo se nel request c'è il file dell'imaggine
        if ($request->hasFile('cover_img')) {
            //controllo se il projects aveva un immagine
            if ($project->cover_img) {
                //cancello vecchia immagine
                Storage::delete($project->cover_img);
            }

            //salvo nuova immagine
            $image_path = Storage::put('project_img', $request->cover_img);
            //salvo il nuvo path nel database
            $data['cover_img'] = $image_path;
        }


        // remove image without add other
        if ($request['removeImage'] != NULL && $project->cover_img != NULL) {
            // dd($request->all());
            Storage::delete($project->cover_img);
            $project->cover_img = NULL;
        }
        // /remove image without add other


        // dd($request['removeImage']);

        $project->update($data);

        $project->technologies()->sync($request->technologies);

        return redirect()->route('admin.project.show', ['project' => $project->slug])->with('message', 'Proggetto ' . $project->title . ' è stato modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(404);
        }

        //se il project ha immagine la cancelliamo dallo storage
        if ($project->cover_img) {
            Storage::delete($project->cover_img);
        }

        $project->technologies()->detach();
        $project->delete();
        return redirect()->route('admin.project.index')->with('message', 'Proggetto ' . $project->title . ' è stato eliminato');
    }
}

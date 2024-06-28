
<form class="delete-form" action="{{route('admin.project.destroy', ['project' => $project->slug])}}" method="POST">
    @csrf
    @method('DELETE')
    <button data-project-title="{{ $project->title }}" type="button" class="btn btn-danger"><i class="fa-solid fa-delete-left fa-lg"></i></button>
</form>
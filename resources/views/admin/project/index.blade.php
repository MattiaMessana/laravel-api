@extends('layouts.admin')

@section('content')
    <div class="mt-4">
        <h2 class="mb-3">Lista Progetti</h2>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        {{-- filtri per le pagine --}}

        <form action="{{ route('admin.project.index') }}" method="GET">
            @csrf

            <label class="form-label" for="per_page">Elementi per pagina</label>
            <select class="form-select" name="per_page" id="per_page">
                <option value="5" @selected($projectArray->perPage() == '5')>5</option>
                <option value="10" @selected($projectArray->perPage() == '10')>10</option>
                <option value="15" @selected($projectArray->perPage() == '15')>15</option>
            </select>
        </form>



        <table class="table mt-2">
            <thead class="striped">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Dettagli</th>
                    <th scope="col">Mod</th>
                    <th scope="col">Canc</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectArray as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->description }}</td>
                        <td>{{ $project->slug }}</td>
                        <td> <a href="{{ route('admin.project.show', $project) }}"><i
                                    class="fa-solid fa-ellipsis-vertical fa-2xl"></i></a></td>
                        <td><a class="btn btn-warning" href="{{ route('admin.project.edit', $project) }}"><i
                                    class="fa-solid fa-marker fa-lg"></i></a></td>
                        <td>@include('admin.project.partials.delete-project-form')</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            {{ $projectArray->links() }}
        </div>

    </div>

    @include('admin.project.partials.delete-project-modal')
@endsection

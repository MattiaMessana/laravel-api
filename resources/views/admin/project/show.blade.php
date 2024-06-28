@extends('layouts.admin')

@section('content')
    <div class="container my-3">
        <h2 class="mb-3">Dettaglio Progetto</h2>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif


        <ul>
            <li class="mb-3"><strong>Titolo:</strong> {{ $project->title }}</li>
            <li class="mb-3"><Strong>Categoria:</Strong> {{ $project->category?->name }} </li>
            <li><strong>Technologie:</strong> </li>
            
            @foreach ($project->technologies as $tech)
            <li class="mt-2-"> {{ $tech->name}}</li>
            @endforeach

            <li class="mb-3"><strong>Descrizione:</strong> {{ $project->description }}</li>
            <li class="mb-3"><img class="w-25" src="{{ asset('storage/' . $project->cover_img) }}" alt=""></li>
            <li class="mb-3"><strong>Slug:</strong> {{ $project->slug }}</li>
        </ul>
        <ul class="d-flex gap-2">
            <li><a class="btn btn-warning" href="{{ route('admin.project.edit', $project) }}"><i
                        class="fa-solid fa-marker fa-lg"></i></a></li>
            <li>@include('admin.project.partials.delete-project-form')</li>
        </ul>
    </div>
    @include('admin.project.partials.delete-project-modal')
@endsection

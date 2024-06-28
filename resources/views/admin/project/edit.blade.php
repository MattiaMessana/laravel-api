@extends('layouts.admin')

@section('content')
    <div class="container mt-3">
        <h2>Modifica Progetto</h2>
        <form action="{{ route('admin.project.update' , $project )}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="my-3">
                <label for="title" class="form-label">Titolo</label>
                <input value="{{ old('title') ?? $project->title }}" class="form-control 
                @error('title')
                    is-invalid
                @enderror" 
                type="text" 
                name="title" id="title">
                @error('title')
                    <div id="title-error" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="my-3">
                <label class="form-label" for="category_id">Categoria</label>
                <select class="form-select" name="category_id" id="category_id">
                    <option value="">Seleziona</option>
                    @foreach ($categories as $category)
                        <option @selected(old('category_id', $project->category?->id) == $category->id) value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-3">
                <p>Seleziona technologie utilizzate </p>
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    @foreach ($technologies as $technology)

                    @if (old('technologies') != null)
                    {{-- gestione dellgi errori --}}
                        <input @checked(in_array($technology->id, old('technologies', []))) type="checkbox" class="btn-check" id="tech-{{ $technology->id }}" name="technologies[]" value="{{ $technology->id }}">
                    @else
                    {{-- visualizzazzione collection technologie  --}}
                    <input @checked($project->technologies->contains($technology)) type="checkbox" class="btn-check" id="tech-{{ $technology->id }}" name="technologies[]" value="{{ $technology->id }}">
                    @endif

                    <label class="btn btn-outline-primary" for="tech-{{ $technology->id }}">{{ $technology->name }}</label>

                    @endforeach
                </div>
            </div>

            <div class="my-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea class="form-control @error('description')
                    is-invalid
                @enderror" name="description" id="description" cols="30" rows="10">{{ old('description') ?? $project->description }}</textarea>
                @error('description')
                <div id="description-error" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="my-3">
                <label for="cover_img" class="form-label">Poster</label>
                <input type="file" name="cover_img" id="cover_img" class="form-control" value="{{ old('cover_img') ?? $project->cover_img }}">
            </div>

            <div class="my-3">
                <h4>Preview Immagine</h4>
                <img class="w-25" src="{{ asset('storage/' . $project->cover_img) }}" alt="">
            </div>

            <button class="btn btn-success mt-2" type="submit"><i class="fa-solid fa-floppy-disk fa-lg"></i></button>
        </form>
    </div>
@endsection
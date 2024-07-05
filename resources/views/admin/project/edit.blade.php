@extends('layouts.admin')

@section('content')
    <div class="container mt-3">
        <h2>Modifica Progetto</h2>
        <form action="{{ route('admin.project.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="my-3">
                <label for="title" class="form-label">Titolo</label>
                <input value="{{ old('title') ?? $project->title }}"
                    class="form-control 
                @error('title')
                    is-invalid
                @enderror"
                    type="text" name="title" id="title">
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
                        <option @selected(old('category_id', $project->category?->id) == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-3">
                <p>Seleziona technologie utilizzate </p>
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    @foreach ($technologies as $technology)
                        @if (old('technologies') != null)
                            {{-- gestione dellgi errori --}}
                            <input @checked(in_array($technology->id, old('technologies', []))) type="checkbox" class="btn-check"
                                id="tech-{{ $technology->id }}" name="technologies[]" value="{{ $technology->id }}">
                        @else
                            {{-- visualizzazzione collection technologie  --}}
                            <input @checked($project->technologies->contains($technology)) type="checkbox" class="btn-check"
                                id="tech-{{ $technology->id }}" name="technologies[]" value="{{ $technology->id }}">
                        @endif

                        <label class="btn btn-outline-primary"
                            for="tech-{{ $technology->id }}">{{ $technology->name }}</label>
                    @endforeach
                </div>
            </div>

            <div class="my-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea class="form-control @error('description')
                    is-invalid
                @enderror"
                    name="description" id="description" cols="30" rows="10">{{ old('description') ?? $project->description }}</textarea>
                @error('description')
                    <div id="description-error" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="my-3">
                <label for="cover_img" class="form-label">Poster</label>
                <input type="file" name="cover_img" id="cover_img" class="form-control"
                    value="{{ old('cover_img') ?? $project->cover_img }}">
            </div>

            {{-- checkbox img --}}
            @if ($project->cover_img !== null)
                <label for="removeImage">Rimuovi immagine :</label>
                <input type="checkbox" id="removeImage" name="removeImage">

            {{-- button add and remove --}}
            <div>
                <button class="btn btn-success mt-3 w-25" type="submit">Aggiorna</button>
                <a id="btnDelete" class="btn btn-danger mt-3 hide w-25">Rimuovi</a>
            </div>
            {{-- /button add and remove --}}
            @endif


            <div class="my-3">
                <h4>Preview Immagine</h4>
                <img id="oldImg" class="w-25" src="{{ asset('storage/' . $project->cover_img) }}" alt="">
                <img id="imagePreview" class="hide" src="" alt="">
            </div>

            <ul class="d-flex gap-2">
                <li class="mt-2">
                    <a class="btn btn-primary" href="{{ route('admin.project.index') }}"><i
                            class="fa-solid fa-hand-point-left fa-lg"></i></a>
                </li>

                <li>
                    <button class="btn btn-success mt-2" type="submit"><i
                            class="fa-solid fa-floppy-disk fa-lg"></i></button>
                </li>
            </ul>

        </form>
    </div>
@endsection

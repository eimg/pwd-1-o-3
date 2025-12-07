@extends("layouts.app")

@section("content")
    <div class="container" style="max-width: 600px">
        @if($errors->any())
            <div class="alert alert-warning">
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ url("/articles/create") }}" method="post">
            @csrf
            <input type="text" name="title" placeholder="Title" class="form-control mb-2">
            <textarea name="body" class="form-control mb-2" placeholder="Body"></textarea>
            <select name="category_id"  class="form-select mb-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary">Add Article</button>
        </form>
    </div>
@endsection
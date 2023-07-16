@extends('layouts.app')
@section('style')

@endsection
@section('title')
Create Shorten Url
@endsection
@section('content')
<section class="content">
    <div class="col-md-12">
        <div class="card">    
            <div class="card-body">
                <form action="{{ route('manage-url.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="https://example.com">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>

</script>

@endsection
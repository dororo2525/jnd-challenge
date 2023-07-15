@extends('layouts.app')
@section('title')
    Edit Shorten Url
@endsection
@section('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <section class="content mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('manage-url.update' , $result->code) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                          <label for="url" class="col-lg-2 offset-lg-2 col-form-label">Origin Url</label>
                          <div class="col-lg-4">
                            <input type="text" class="form-control" id="url" name="url" value="{{ old('url',$result->url) }}">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="shorten_url" class="col-lg-2 offset-lg-2 col-form-label">Shorten Url</label>
                          <div class="col-lg-4">
                            <input type="text" class="form-control" id="shorten_url" name="shorten_url" value="{{ old('shorten_url',$result->shorten_url) }}" disabled>
                          </div>
                        </div>
                        <div class="row mb-3">
                            <label for="code" class="col-lg-2 offset-lg-2 col-form-label">Code</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" id="code" name="code" value="{{ old('code',$result->code) }}" disabled>
                            </div>
                          </div>
                        <fieldset class="row mb-3">
                          <legend class="col-form-label col-lg-2 offset-lg-2 pt-0">Status</legend>
                          <div class="col-lg-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" {{ old('status',$result->status) == true ? 'checked' : null }}>
                                </div>
                          </div>
                        </fieldset>
                        <div class="row mb-3">
                          <div class="col-lg-6 offset-lg-2">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" type="button">Save</button>
                              </div>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Shorten Url</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-url" action="{{ route('manage-url.store') }}" method="POST">
                            @csrf
                            <input type="text" class="form-control" id="url" name="url"
                                placeholder="https://example.com">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="btn-save-url" type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')

@endsection

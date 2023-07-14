@extends('layouts.app')
@section('title')
    Url List
@endsection
@section('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <section class="content">
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
                    @elseif(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }} <br>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                            class="bi bi-plus-circle me-1"></i> Shorten Url</button>
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Origin Url</th>
                                <th>Shorten Url</th>
                                <th>Code</th>
                                <th>Clicks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $url)
                                <tr>
                                    <td><a href="{{ $url->url }}">{{ $url->url }}</a></td>
                                    <td><a href="{{ $url->shorten_url }}">{{ $url->shorten_url }}</a></td>
                                    <td>{{ $url->code }}</td>
                                    <td>{{ $url->hits }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('manage-url.edit' , $url->code) }}" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        <tfoot>
                            <tr>
                                <th>Origin Url</th>
                                <th>Shorten Url</th>
                                <th>Code</th>
                                <th>Clicks</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
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
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#btn-save-url').click(function() {
                $('#form-url').submit();
            });
        });
    </script>
@endsection

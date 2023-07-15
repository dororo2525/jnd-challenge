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
                    <table id="table-url" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Origin Url</th>
                                <th>Shorten Url</th>
                                <th>Code</th>
                                <th>Clicks</th>
                                <th>Status</th>
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
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-status" data-code="{{ $url->code }}" type="checkbox" role="switch" {{ $url->status == true ? 'checked' : null }}>
                                            </div>
                                    </td>
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
                                <th>Status</th>
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

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast text-white" data-bs-delay="3000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body"></div>
      </div>
    </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js" integrity="sha512-uE2UhqPZkcKyOjeXjPCmYsW9Sudy5Vbv0XwAVnKBamQeasAVAmH6HR9j5Qpy6Itk1cxk+ypFRPeAZwNnEwNuzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table-url').DataTable();
            $('#btn-save-url').click(function() {
                $('#form-url').submit();
            });

            $('.switch-status').click(function() {
                var code = $(this).data('code');
                var status = Number($(this).is(':checked'));
                $.ajax({
                    url: "{{ route('manage-url.switch-status') }}",
                    type: "POST",
                    data: {
                        code: code,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        if(data.status == true){
                            $('#liveToast').addClass('bg-success');
                            $('.toast-body').text(data.msg);
                            $('.toast').toast('show');
                        } else{
                            $('#liveToast').addClass('bg-danger');
                            $('.toast-body').text(data.msg);
                            $('.toast').toast('show');
                        }
                    }
                });
            });
        });
    </script>
@endsection

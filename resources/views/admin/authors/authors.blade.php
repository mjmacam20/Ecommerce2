@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Authors</h4>
                        <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-edit-author') }}" class="btn btn-block btn-primary">Add Author</a>
                        @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="authors" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($authors as $author)
                                    <tr>
                                        <td>
                                            {{ $author['id'] }}
                                        </td>
                                        <td>
                                            {{ $author['name'] }}
                                        </td>
                                        <td>
                                            @if($author['status']==1)
                                                <a class="updateAuthorStatus" id="author-{{ $author['id'] }}" author_id=" {{ $author['id'] }}" href="javascript:void(0)"><i style='font-size: 21px;'class="mdi mdi-checkbox-multiple-marked" status="Active"></i></a>
                                            @else
                                            <a class="updateAuthorStatus" id="author-{{ $author['id'] }}" author_id=" {{ $author['id'] }}" href="javascript:void(0)"><i style='font-size: 21px;'class="mdi mdi-checkbox-multiple-blank-outline" status="Inactive"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-author/'.$author['id']) }}"><i style='font-size: 21px;'class="mdi mdi-file-multiple"></i></a>
                                            <?php /*<a title="author" class="confirmDelete" href="{{ url('admin/delete-author/'.$author['id']) }}"><i style='font-size: 25px;'class="mdi mdi-delete-forever"></i></a> */?>
                                            <a href="javascript:void(0)" class="confirmDelete" module="author" moduleid="{{ $author['id'] }}"><i style='font-size: 25px;'class="mdi mdi-delete-forever"></i></a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
    </footer>
    <!-- partial -->
</div>

@endsection
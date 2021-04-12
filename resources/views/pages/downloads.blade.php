@extends('layouts.app')

@section('content')
  <div id="my-saved-download">
    <div class="container">
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <table id="download-view-page" class="table table-light table-hover table-striped table-bordered table-md" cellspacing="0" width="100%">
            <thead class="thead-dark">
              <tr class="table-primary">
                <th scope="col">#</th>
                <th scope="col">Type</th>
                <th scope="col">Credit</th>
                <th scope="col">Date</th>
                <!-- <th scope="col">Export By</th> -->
                <th scope="col">Action</th>
                <!-- <th scope="col" colspan="3">Actions</th> -->
              </tr>
            </thead>
            <tbody>
              @if(!empty($download_data))
                @foreach ($download_data as $key => $value)

                <tr>
                  <th scope="row">{{$key+1}}</th>
                  <td> {{$value['type']}} </td>
                  <td> {{$value['credit']}}</td>
                  <td> {{$value['created_at']}}</td>
                  <!-- <td> {{$value['export_by']}}</td> -->
                  <td><a href={{URL::to("/download-export?ids=".$value['contact_id'])}}><span class="glyphicon glyphicon-save"></span></a></td>
                  <!-- <td><a href="#"><i class="fa fa-edit"></i></a></td>
                  <td><a href="#"><i class="fa fa-trash"></i></a></td> -->
                </tr>
                @endforeach

                @else
                <tr>
                  <th scope="row" colspan="6">No Downloads Found</th>
                </tr>
                @endif
            </tbody>
          </table>
          {{ $download_data->render() }}
        </div>
      </div>
    </div>
  </div>
@endsection

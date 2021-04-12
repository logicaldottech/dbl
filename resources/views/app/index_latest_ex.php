@extends('layouts.app')


@section('content')
<!-- geek code start -->
<div class="button-group-search-list">
    <!-- <div class="button-group-search">
      <h6>SAVE SEARCH</h6>
    </div> -->

    <!-- <div class="button-group-list">
      <h6>MY LIST</h6>
    </div>
    <div class="button-group-enrich">
      <h6>ENRICH</h6>
    </div> -->
    <div class="button-group-enrich">
        @if(isset($msg))
          <h6 class="success-search">{{$msg}}</h6>
        @endif
    </div>
  </div>
  <div class="save-search">
    <button class="btn" data-toggle="modal" data-target="#searchModal" type="button">SAVE SEARCH</button>

    <!-- The Modal -->
  <div class="modal fade" id="searchModal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Save Search</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form method="post" action= {{route('save-search')}}>
            @csrf
            <label htmlFor="searchName"> Name
              <input class="form-control" type="text" name="search_name" required/>
            </label>
            <button type="submit" class="btn btn-success" name="search_sub">Save</button>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>


    <a href="{{route('saved-search-view')}}"><button class="btn" type="button">MY SAVED SEARCHES</button></a>
    <button class="btn" type="button">CLEAR ALL CRITERIA</button>
  </div>

  @if(isset($data))
  <div id="my-saved-search">
    <div class="container">
      <div class="row">
        <div class="col-sm-10">
          <table class="table table-hover text-center">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
                <th scope="col" colspan="3">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($data))
                @foreach ($data as $key => $value)
                <tr>
                  <th scope="row">{{$key+1}}</th>
                  <td> {{$value['name']}} </td>
                  <td> {{$value['created_at']}}</td>
                  <td><a href="#">View Results</a></td>
                  <td><a href="#"><i class="fa fa-edit"></i></a></td>
                  <td><a href="#"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach;

                @else
                <tr>
                  <th scope="row" colspan="6">No Saved Searches Found</th>
                </tr>
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @elseif(isset($download_data))
  <div id="my-saved-download">
    <div class="container">
      <div class="row">
        <div class="col-sm-10">
          <table class="table table-hover text-center">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Type</th>
                <th scope="col">Date</th>
                <th scope="col">Credit</th>
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
                  <td> {{$value['created_at']}}</td>
                  <td> {{$value['credit']}}</td>
                  <td><a href={{URL::to("/download-export?ids=".$value['lead_id'])}}>Download</a></td>
                  <!-- <td><a href="#"><i class="fa fa-edit"></i></a></td>
                  <td><a href="#"><i class="fa fa-trash"></i></a></td> -->
                </tr>
                @endforeach;

                @else
                <tr>
                  <th scope="row" colspan="6">No Downloads Found</th>
                </tr>
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @else
  <div id="appContainer">

  </div>
  @endif;
@endsection

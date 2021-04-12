@extends('layouts.app')

@section('title', 'Dollar Business Leads - App')

@section('sidebar')
<div class="search-sidebar">
<div class="search-sidebar-heading">
<h5>Search Criteria</h5>
</div><!--.search-sidebar-heading-->
<div id="search-sidebar-buttons" >

</div><!--#search-sidebar-buttons-->
<div id="search-sidebar-ul" class="search-sidebar-list">
<ul >
  <li class="search-filter-li"><i class="search-filter-icon-check"  stroke-width="2" data-feather="check"></i><span>Industry</span></li>
  <li class="search-filter-li"><i class="search-filter-icon-circle"  stroke-width="2" data-feather="circle"></i><span>Location<span></li>
  <li class="search-filter-li"><i class="search-filter-icon-circle"  stroke-width="2" data-feather="circle"></i><span>Revenue<span></li>
  <li class="search-filter-li"><i class="search-filter-icon-circle"  stroke-width="2" data-feather="circle"></i><span>Company Information<span></li>
  <li class="search-filter-li"><i class="search-filter-icon-circle"  stroke-width="2" data-feather="circle"></i><span>Employees<span></li>

</ul>
</div><!--.search-sidebar-list-->
</div><!--.search-sidebar-->
@endsection

@section('content')
<div id="app-main-table" class="app-main-table">
<table class="table">
  <thead>
    <tr>
      <th scope="col"><i class="action-select-icon" stroke-width="1" data-feather="square"></i></th>
      <th scope="col">Contact<i class="action-sort-icon"  stroke-width="2" data-feather="arrow-up"></th>
      <th scope="col">Company<i class="action-sort-icon"  stroke-width="2" data-feather="arrow-down"></i></th>
      <th scope="col">Title</th>
      <th scope="col">Phone</th>
      <th scope="col">Email</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody id="app-tbody">
    <?php for( $i = 0; $i < 11 ; $i++ ) : ?>
    <tr>
      <th scope="row"><i class="action-select-icon"  stroke-width="1" data-feather="square"></i></th>
      <td>Contact1</td>
      <td>Company1</td>
      <td>Title1</td>
      <td>Phone1</td>
      <td>Email1</td>
      <td><i class="action-download-icon" stroke-width="2" data-feather="download"></i></td>
    </tr>

  <?php endfor; ?>
  </tbody>
</table>
</div><!--.app-main-table-->
@endsection

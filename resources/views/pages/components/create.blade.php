@extends('layouts.app')

@section('content')

@if ($errors->any())
   @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
   @endforeach
@endif

<div class="row">
   @include('pages.sidebar')
   <div class="col-md-9">
      <div class="card">
         <div class="card-header">
            Create Component
         </div>

         <div class="card-body">
               <form action="/components" method="POST">
                  @csrf
                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label" for="id">Storage</label>
                     <div class="col-sm-10">
                        <select class="form-control" name="storage">
                           @foreach ($storages as $storage)
                           <option value="{{ $storage->name }}">{{ $storage->name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label" for="id">Name</label>
                     <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" />
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label" for="id">Category</label>
                     <div class="col-sm-10">
                        <input type="text" class="form-control" name="category" />
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label" for="id">Description</label>
                     <div class="col-sm-10">
                        <input type="text" class="form-control" name="description" />
                     </div>
                  </div>

                   <div class="form-group row">
                     <label class="col-sm-2 col-form-label" for="id">Tags</label>
                     <div class="col-sm-10">
                        <input type="text" data-role="tagsinput" class="form-control" name="tags" />
                     </div>
                  </div>
 
                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label" for="id">Stock</label>
                     <div class="col-sm-10">
                        <input type="text" class="form-control" name="stock" />
                     </div>
                  </div>

                  <div class="form-check">
                     <input class="form-check-input" type="checkbox" class="form-control" name="stock_flag" checked/>
                     <label class="form-check-label">
                        Stock Flag
                     </label>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label" for="id">Attributes</label>
                     <div class="col-sm-10">
                        <table id="attributes" class="table">
                           <thead>
                              <tr>
                                 <th scope="col">Key</th>
                                 <th scope="col">Value</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td><input type="text" class="form-control" name="key[]" list="keys" /></td>
                                 <td><input type="text" class="form-control" name="attribute[]" /></td>
                                 <td><button type="button" onclick="addAtributesRow()" class="btn btn-success">+</button></td>
                              </tr>
                           </tbody>                     
                        </table>
                     </div>
                  </div>

                  <input class="btn btn-primary" type="submit" />
                  <br/>
               </form>
         </div>
      </div>
   </div>
</div>

<script>
function addAtributesRow() {
   $('#attributes').append('<tr><td><input type="text" class="form-control" name="key[]" list="keys" /></td><td><input type="text" class="form-control" name="attribute[]" /></td></tr>')
}
</script>

@endsection
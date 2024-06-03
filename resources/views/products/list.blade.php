<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Laravel 11 CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>

    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('Products.Create') }}" class="btn btn-dark">Create</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if(Session::has('success'))
            <div class="col-md-10 mt-3">
                <div id="error-alert" class="alert alert-success">
                    <p class="text-danger">
                    {{ Session::get('success') }}
                    </p>
               
                </div>
            </div>

            @endif
            <div class="col-md-10">
                <div class="card borde-0 shadow-lg my-4">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">List Of Product</h3>
                    </div>
             <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Id</th>
                        <th></th>
                        <th>Name</th>
                        <th>Sku</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>

                    <tbody>
                        @if($products->isNotEmpty())
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td> 

                            @if($product->Image != '')
                            <img src="{{ asset('uploads/products/'. $product->Image) }}" alt="" width="50">
                            @endif



                            </td>
                            <td>{{ $product->Name }}</td>
                            <td>{{ $product->Sku }}</td>
                            <td>${{ $product->Price }}</td>
                            <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                            <td class="btn-group">
                                <a href="{{ route('Products.Edit',$product->id )}}" class="btn btn-sm btn-dark">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger" onclick="deleteProduct({{ $product->id }})">Delete</a>
                                <form id="delete-product-from-{{ $product->id }}" action="{{ route('Products.Delete',$product->id) }}" method="post">
                                   @csrf
                                    @method('delete')
                                </form>
                            </td>

                        </tr>
                        @endforeach
                        @endif

                    </tbody>
 
                </table>
             </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .alert {
        transition: opacity 0.5s ease-out;
    }
    .alert-hide {
        opacity: 0;
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.classList.add('alert-hide');
            }, 5000); // Hide after 5 seconds
        }
    });
</script>
<script>
    function deleteProduct(id){
        if(confirm("are you sure to delete a product")){
            document.getElementById('delete-product-from-'+id).submit();
        }
    }
</script>
  </body>
</html>
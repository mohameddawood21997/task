@extends('layouts.app')

@section('content')

@if (Session::has('success'))
    <div class="alert alert-success col-6">
        {{ Session::get('success') }}
    </div>
    @elseif(Session::has('error'))
    <div class="alert alert-danger col-6">
      {{ Session::get('error') }}
  </div>
@endif
 



@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    
  <form action="{{route("bills.store")}}" method="post">
    @csrf
  <table class="table border" id="my-table">
    <select name="client_id" class="form-select" aria-label="Default select example">
      <option selected >Open clients name</option>
        @foreach ($clients as $client)
        <option value="{{$client->id}}">{{$client->name}}</option>
        @endforeach
      </select>
      @error('client_id')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror
    <thead>
      <tr>
        <th>#</th>
        <th>product</th>
        <th>price</th>
        <th>quantity</th>
        <th>total</th>
      </tr>
    </thead>
    <tbody>
   
    </tbody>
  </table>
  

  <input type="submit" class="btn btn-success" onclick="" value="submit" id="addBill">

  <button id="add-row-btn" type="button" class="btn btn-primary" onclick="">Add Row</button>

<div id="allTotalPriceDiv">totalPrice:<span id="allTotalPrice"></span></div>
{{-- <input type="text" name="totalPrice" id="hiddenTotalPrice"> --}}

</form>
@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>


var i=0;
  $(document).ready(function() {

    $('#addBill').hide();
    $('#allTotalPriceDiv').hide();
    
    $('#add-row-btn').on('click', function() {
     
      var newRow = '<tr>' +
        `<td>${i+1}</td>`+
        '<td>' +
        `<select id="product-select${++i}" name="product[]" class="form-select product-select" onchange="getPrice('${i}')" onclick="">` +
        '<option selected>Open product name</option>';

      @foreach ($products as $product)
      newRow += '<option value="{{$product->id}}">{{$product->name}}</option>';
      @endforeach

      newRow += '</select>' +
        '</td>' +
        
        '<td>'+

         `<input id="price-input${i}" type="text" name="price[]" readonly></td>` +
         `<td><input id="quantity${i}" type="number" name="quantity[]" min="1" value="1" onchange="getTotal('${i}')"></td>` +
         `<td><input id="price-total${i}" type="text" name="price_total[]" readonly></td>` +
       
        '</tr>';

      $('#my-table tbody').append(newRow);



    });


  });

  function getPrice(id) {
    $('#addBill').show();
    $('#allTotalPriceDiv').show();
      //  $(`#product-select${id}`).on('change', function() {
          var productId = $(`#product-select${id}`).val();
          // console.log(productId);

          // Make an AJAX request to retrieve the price based on the selected product
          $.ajax({

            headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
              url: '/get-price', // Replace with the actual route that fetches the price
              method: 'POST', // Change to 'GET' if your route is configured as a GET request
              data: {
                  product_id: productId
              },
            
              success: function(response) {
              
                  $(`#price-input${id}`).val(response.product.price);
               
                    var quantity =$(`#quantity${id}`).val();
                  $(`#price-total${id}`).val( quantity *  response.product.price );


                  calculateTotalPrice();
                  // function updateHiddenInput(){
  
                  // const totalPrice = document.getElementById('allTotalPrice').textContent;
                  // if(document.getElementById('hiddenTotalPrice').value !=null)
                  //   document.getElementById('hiddenTotalPrice').value = totalPrice;
                  // }
              }
          });


      // });
  }
  
     // Function to calculate the total price
     function calculateTotalPrice() {

      let totalPrice = 0;

      // Loop through each row and calculate the subtotal
      $('#my-table tbody tr').each(function(rowIndex) {
       console.log(rowIndex);
        const quantity = parseInt($(`#quantity${rowIndex+1}`).val());
    const price = parseFloat($(`#price-input${rowIndex+1}`).val());
    // console.log(i);
        const subtotal = quantity * price;
        totalPrice +=subtotal;
   
      });

     
      $('#allTotalPrice').text(totalPrice.toFixed(2));

      return totalPrice;
    }

  function getTotal(id) {
    var price = $(`#price-input${id}`).val();
    var quantity = $(`#quantity${id}`).val();
      //  console.log(price,quantity);

       $(`#price-total${id}`).val( quantity *  price); 
       const total = quantity * price;
       
       $('#allTotalPrice').text( total.toFixed(2));
      
       calculateTotalPrice();
         
  }

  // document.getElementById('allTotalPrice').addEventListener('DOMSubtreeModified', updateHiddenInput);

</script>
 
<script>

</script>






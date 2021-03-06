<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('backend/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('backend/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backend/dist/css/AdminLTE.min.css')}}">
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  <style>

    .page-header{
      font-size: 18px;
      font-family: 'Source Sans Pro', sans-serif; 
      text-align: center;
    }
    table{
      border: 1px solid black;
    }
    th{
      padding: 10px;
      text-align: center;
      font-size: 13p;
    }
    td{
      padding: 5px;
      font-family: sans-serif;
      font-size: 13px;
    }
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h3 class="page-header text-center">
            <i class="fa fa-globe"></i> 
            <span>Phiếu Mua Hàng</span>
            <small class="pull-right">Date: 2/10/2014</small>
          </h3>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Hà Nôi, Inc.</strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>John Doe</strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (555) 539-1037<br>
            Email: john.doe@example.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #007612</b><br>
          <br>
          <b>Order ID:</b> 4F3S8J<br>
          <b>Payment Due:</b> 2/22/2014<br>
          <b>Account:</b> 968-34567
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <hr>
        <h4 class="text-center"> Thông tin hóa đơn </h4>

        <table class="table">
          <thead>
            <tr>

              <th width="35%">Tên sản phẩm</th>
              <th width="110px;">Hình ảnh</th>
              <th>Giá bán</th>
              <th>Màu / Bộ Nhớ</th>
              <th>Số lượng</th>
              <th>Tổng tiền</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->orderDetails as $item => $key)
            <tr>

              <td>{{ $key->name }}</td>
              <td>
                @if($key->image)
                <img src="{{ $key->image }}" alt="" style="max-width:100px;max-height:80px;">
                @endif
              </td>
              <td style="text-align:center;">{{ number_format($key->price , 0, ',','.') }} <sup> đ</sup></td>
              <td style="text-align:center;">{{ $key->color }} - {{ $key->memory }}</td>
              <td style="text-align:center;">{{  number_format($key->qty) }}</td>
              <td>{{ number_format($key->total , 0 ,',','.' ) }} <sup> đ</sup></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <hr>

            <table class="table" style="width:300px; float:right;">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>$250.30</td>
              </tr>
              <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$265.24</td>
              </tr>
            </table>
        <!-- /.col -->
      </div>
      <!-- /.row -->

     
      <!-- /.row -->
    </section>
   
      
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
</body>
</html>

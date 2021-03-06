

<!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Login </title>

  <base href="{{ asset('') }}" target="_parent">
 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./backend/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./backend/bower_components/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="">
   <style type="text/css">
     html {
      height: 100%;
    }
    body {
      margin:0;
      padding:0;
      font-family: sans-serif;
      background: linear-gradient(#141e30, #243b55);
    }

    .login-box {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 400px;
      padding: 40px;
      transform: translate(-50%, -50%);
      background: rgba(0,0,0,.5);
      box-sizing: border-box;
      box-shadow: 0 15px 25px rgba(0,0,0,.6);
      border-radius: 10px;
    }

    .login-box:hover{

      box-shadow: 0 0 5px #03e9f4,
                  0 0 25px #03e9f4,
                  0 0 50px #03e9f4,
                  0 0 100px #03e9f4;

    }

    

    .login-box h2 {
        font-family: 'Myriad Pro', Helvetica, Arial sans-serif;
        font-size: 2em;
        width: 100%;
        text-align: center;
        margin: 0 0 30px;
        padding: 0;
        font-weight: bold;
        color: #C0FF3E;
        text-shadow: 0 2px 0 #721e1e, 0px 2px 5px rgba(0,0,0,0.5);
        position: relative;
        -webkit-transition: all 0.1s ease-in;
    }
     
    .login-box h2:hover {
        text-shadow: 0 2px 0 #d84f4f, 0 3px 0 #d54646, 0 4px 0 #ce3333, 0 5px 0 #b92e2e, 0 6px 0 #912525, 0 7px 0 #721e1e, 0px 8px 10px rgba(0,0,0,0.5);
        top: -0px;
    }


    .login-box .user-box {
      position: relative;
    }

    .login-box .user-box input {
      width: 100%;
      padding: 10px 0;
      font-size: 16px;
      color: #fff;
      margin-bottom: 50px;
      border: none;
      border-bottom: 1px solid #fff;
      outline: none;
      background: transparent;
    }
    .login-box .user-box label {
      position: absolute;
      top:0;
      left: 0;
      padding: 10px 0;
      font-size: 16px;
      color: #fff;
      pointer-events: none;
      transition: .5s;
    }

    .login-box .user-box input:focus ~ label,
    .login-box .user-box input:valid ~ label {
      top: -20px;
      left: 0;
      color: #03e9f4;
      font-size: 12px;
    }

    .login-box form .btn-submit {
      position: relative;
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      color: #03e9f4;
      background: none;
      font-size: 16px;
      text-decoration: none;
      text-transform: uppercase;
      overflow: hidden;
      transition: .5s;
      
      letter-spacing: 4px;
      
    }

    .login-box .btn-submit:hover {
      background: #03e9f4;
      color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 5px #03e9f4,
                  0 0 25px #03e9f4,
                  0 0 50px #03e9f4,
                  0 0 100px #03e9f4;
    }

    .login-box .btn-submit span {
      position: absolute;
      display: block;
    }

    .login-box .btn-submit span:nth-child(1) {
      top: 0;
      left: -100%;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, transparent, #03e9f4);
      animation: btn-anim1 1s linear infinite;
    }

    @keyframes btn-anim1 {
      0% {
        left: -100%;
      }
      50%,100% {
        left: 100%;
      }
    }

    .login-box .btn-submit span:nth-child(2) {
      top: -100%;
      right: 0;
      width: 2px;
      height: 100%;
      background: linear-gradient(180deg, transparent, #03e9f4);
      animation: btn-anim2 1s linear infinite;
      animation-delay: .25s
    }

    @keyframes btn-anim2 {
      0% {
        top: -100%;
      }
      50%,100% {
        top: 100%;
      }
    }

    .login-box .btn-submit span:nth-child(3) {
      bottom: 0;
      right: -100%;
      width: 100%;
      height: 2px;
      background: linear-gradient(270deg, transparent, #03e9f4);
      animation: btn-anim3 1s linear infinite;
      animation-delay: .5s
    }

    @keyframes btn-anim3 {
      0% {
        right: -100%;
      }
      50%,100% {
        right: 100%;
      }
    }

    .login-box .btn-submit span:nth-child(4) {
      bottom: -100%;
      left: 0;
      width: 2px;
      height: 100%;
      background: linear-gradient(360deg, transparent, #03e9f4);
      animation: btn-anim4 1s linear infinite;
      animation-delay: .75s
    }

    @keyframes btn-anim4 {
      0% {
        bottom: -100%;
      }
      50%,100% {
        bottom: 100%;
      }
    }
    .user-remember{
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .user-remember a{
      color: #fff;
      list-style: none;
     
    }
    .user-remember label{
      color: #fff;
    }
    .user-remember input{
      transform:scale(1.5);
    }

    .error{
        position: absolute;
        top: 50px;
        display: block;
        font-size: 12px;
        color: red;
    }
   </style>
  </head>
 <body>
    <div class="login-box">
      <h2>ADMIN</h2>
      <form action="{{ route('post.admin.login') }}" method="post" autocomplete="off">
        @csrf
        <div class="user-box">
          <input type="text" name="email" value="{{ old('email') }}" required="">
          <label>T??i Kho???n : </label>
          @if($errors->has('email'))
            <span class="error">{{ $errors->first('email') }}</span>
          @endif
        </div>
        <div class="user-box">
          <input type="password" name="password" required="">
          <label>M???t kh???u : </label>
           @if($errors->has('password'))
            <span class="error">{{ $errors->first('password') }}</span>
          @endif
        </div>
        <div class="user-remember">
          <label><input type="checkbox" name="remember"> Remember</label>
          
        </div>
        <button class="btn-submit" type="submit">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          ????ng Nh???p</button>
      </form>
       @if(session('msg'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          {{ session('msg') }}
        </div>
      @endif
    </div>

<!-- jQuery 3 -->
<script src="./backend/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./backend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
 </body>
 </html>
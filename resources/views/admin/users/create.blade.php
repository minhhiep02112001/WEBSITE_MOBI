@extends('admin.layout.__index')
@section('content')
    @if (session('error'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'error',
                iconColor:'red',
                html: '<h4 style="color:black;font-weight:500;">Lỗi </h4>',
                background:'#fff',
                toast: true,
                position: 'center',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
                
            })
        </script>
    @endif



    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Thêm Mới Tài Khoản <a href="{{route('danh-muc.index')}}" class="btn btn-flat btn-success "><i
                        class="fa fa-list"></i> Danh Sách Tài Khoản</a>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        
                        <form action="{{ route('tai-khoan.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                
                                <div class="form-group">
                                    <label>Admin hay Khách Hàng : </label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        <option value="0">Khách Hàng</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="exampleInputEmail1">Họ Tên :</label>
                                    <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name" placeholder="Nhập họ &amp; tên">
                                     @if($errors->has('name'))
                                        <p class="text-danger"><strong>Error : </strong> {{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email :</label>
                                    <input type="text" value="{{ old('email') }}" class="form-control" id="email" name="email" placeholder="Nhập Email">
                                     @if($errors->has('email'))
                                        <p class="text-danger"><strong>Error : </strong> {{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu :</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập password">
                                    @if($errors->has('password'))
                                        <p class="text-danger"><strong>Error : </strong> {{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                                   
                                <div class="form-group">
                                    <label for="exampleInputFile">Image :</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control fileName" disabled="" id="fileName">
                                        <input class="file-upload-input" name="avatar" hidden="hidden" style="position:absolute;" type='file' onchange="readURL(this);" accept="image/*" />
                                        <span class="input-group-btn">
                                            <button type="button"  onclick="$('.file-upload-input').trigger( 'click' )" class="btn btn-info btn-flat">Add Image</button>
                                        </span>
                                    </div>
                                    
                                    <div class="file-upload-content text-center ">
                                        
                                    </div>
                                     @if($errors->has('avatar'))
                                        <p class="text-danger"><strong>Error : </strong> {{ $errors->first('avatar') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Chức Vụ Quản Trị : </label>
                                    <select class="form-control" name="roles[]" multiple="multiple" id="roles" disabled>
                                        @foreach($roles as $key)
                                            <option value="{{ $key->id }}" >{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('roles'))
                                        <p class="text-danger"><strong>Error : </strong> {{ $errors->first('roles') }}</p>
                                    @endif
                                </div>
                               
                                 <div class="checkbox">
                                    <label>
                                    <input type="checkbox" value="1" name="is_active"> Kích hoạt tài khoản
                                </label>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('js')

    <script type="text/javascript">
        $(document).ready(function() {
            disabledRole( $('#role_id').val());
            $('#role_id').change(function () {
                console.log($(this).val())
                disabledRole($(this).val());
            });
        });
        function disabledRole(val) {
            if(val == true){
                $('#roles').removeAttr('disabled');
            }else{
                $('#roles').attr('disabled','disabled');
            }
        }
    </script>

@endsection
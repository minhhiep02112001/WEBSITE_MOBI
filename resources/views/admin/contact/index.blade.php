@extends('admin.layout.__index')

@section('css')
@endsection

@section('content')


    @if (session('success'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'success',
                iconColor:'green',
                html: '<h4 style="color:black;font-weight:500;">'+ <?php echo json_encode( session('success')); ?> +'</h4>',
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
    <section class="content-header d-flex" style="display:flex;justify-content: space-between;">
        <h1>
            Quản Lý Liên Hệ
        </h1>
        
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><a href="{{ route('lien-he.index') }}" title="">Danh Sách</a></h3>

                        <div class="box-tools">
                            <form action="" method="get" accept-charset="utf-8">
                                <div class="input-group input-group-sm hidden-xs" style="width: 250px;">
                                    <input type="text" name="search" class="form-control pull-right" placeholder="Search" value="{{ request('search') }}">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>                              
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th></th>
                                <th width="10%">Ngày</th>
                                <th class="text-center">Tên </th>
                                <th >Email</th>
                                <th class="text-center">Số điện thoại</th>
                                <th class="text-center" width="35%">Nội Dung</th>
                                <th ></th>
                            </tr>
                            @foreach($contacts as $key)
                            <tr>
                                <td>{{$key->id}}</td>
                                <td>{{ date_format($key->created_at," H:i:s a  d-m-Y") }}</td>
    
                                <td>{{$key->name}}</td>
                                
                                <td>
                                    {{ $key->email }}
                                </td>
                                <td>
                                    {{ $key->phone }}
                                </td>
                                
                                <td>
                                    
                                    {{ $key->content }}

                                </td>
                               
                                <td align="center">
                                    {{-- <button class="btn btn-sm btn-success">Xem</button> --}}
                                    
                                   
                                    <button type="button" class="btn btn-xs btn-sm btn-danger btn-delete" data-id="{{ $key->id }}" data-model="lien-he">
                                        <i class="fa fa-fw fa-remove"></i>
                                    </button>
                                    
                                </td>
                            </tr>
                            @endforeach
                            @if($contacts->count() == 0)
                                <tr>
                                    <td colspan="8" class="text-center text-danger">Không tồn tại bản ghi nào</td>
                                </tr>
                            @endif

                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix text-center flex-row">
                        {{ $contacts->appends(request()->all())->links() }}
                     
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->

        </div>

    </section>
    <!-- /.content -->
</div>
@endsection

@section('js')
<script>

</script>
    
@endsection

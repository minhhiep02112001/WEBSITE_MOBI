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
            Quản Lý Thương Hiệu
        </h1>
        @can('create' ,App\Model\Brand::class)
        <a href="{{ route('thuong-hieu.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Mới Thương Hiệu</a>
        @endcan
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><a href="{{ route('thuong-hieu.index') }}" title="">Danh Sách</a></h3>

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
                                <th >#</th>
                                <th width="15%">Tên Thương Hiệu</th>
                                <th class="text-center">Hình Ảnh</th>
                                <th >Website</th>
                                <th >Vị trí</th>
                                <th class="text-center">Trạng thái</th>
                                <th ></th>
                            </tr>
                            @foreach($brands as $key)
                            <tr>
                                <td>{{$rank++}}</td>
                                <td>{{$key->name}}</td>
                                <td align="center">
                                    @if($key->image)
                                        <div style="width:50px ; height:50px; border:1px solid;">
                                            <img src="{{ ($key->image)?$key->image:'' }}" style="width:100%;" alt="">
                                        </div>
                                     @endif
                                </td>
                                <td>
                                    @if($key->website)
                                        <a href="{{ $key->website }}" target="_blank" title="">{{ (strlen($key->website) > 40)?substr($key->website, 0 , 40).' ...':$key->website }}</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $key->position }}
                                </td>
                                <td class="text-center">
                                    <span class="badge change-status {{($key->is_active == 0)?'bg-red':'bg-green'}} ">{{($key->is_active == 0)?'ẩn':'hiển thị'}}</span>
                                </td>
                                <td align="center">
                                    {{-- <button class="btn btn-sm btn-success">Xem</button> --}}
                                    @can('update', $key)
                                        <a href="{{ route('thuong-hieu.edit',['id'=>$key->id]) }}" class="btn btn-xs btn-warning" title="">
                                            <i class="fa fa-fw fa-pencil-square-o"></i>
                                        </a>
                                    @endcan

                                    @can('delete' , $key)
                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-id="{{ $key->id }}" data-model="thuong-hieu">
                                        <i class="fa fa-fw fa-remove"></i>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach

                            @if($brands->count() == 0)
                                <tr>
                                    <td colspan="7" class="text-center text-danger">Không tồn tại bản ghi nào</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix text-center flex-row">
                        {{ $brands->appends(request()->all())->links() }}
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

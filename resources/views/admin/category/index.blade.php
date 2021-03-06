@extends('admin.layout.__index')

@section('css')
@endsection

@section('content')


    @if (session('success'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'success',
                iconColor:'green',
                html: '<h4 style="color:black;font-weight:500;">'+ <?= json_encode( session('success')); ?> +'</h4>',
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
            Quản Lý Danh Mục 
        </h1>
        @can('create' ,App\Model\Category::class)
        <a href="{{ route('danh-muc.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm Mới Danh Mục</a>
        @endcan
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><a href="{{ route('danh-muc.index') }}" title="">Danh Sách</a></h3>

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
                                <th class="text-center">Loại Danh Mục</th>
                                <th >Tên Danh Mục</th>
                                <th class="text-center">Hình Ảnh</th>
                                <th >Danh Mục Cha</th>
                                <th class="text-center">Vị Trí</th>
                                
                                <th class="text-center">Trạng thái</th>
                                <th ></th>
                            </tr>
                            @foreach($arrCategory as $key)
                            <tr>
                                <td>{{$key->id}}</td>
                                 <td class="text-center">
                                    @if($key->type)
                                        Tin Tức
                                    @else
                                        Sản phẩm
                                    @endif
                                </td>
                                <td>{{$key->name}}</td>
                                <td align="center">
                                    @if($key->image)
                                        <div style="width:50px ; height:50px; border:1px solid;"> 
                                            <img src="{{ ($key->image)?$key->image:'' }}" style="width:100%;" alt=""> 
                                        </div>
                                     @endif
                                </td>
                                <td>
                                    @if($key->categoryParent != null)
                                    {{'-- '.$key->categoryParent->name}}
                                    @elseif($key->type)
                                        Tin Tức
                                    @endif

                                </td>
                                <td class="text-center">{{ $key->position }}</td>
                               
                                <td class="text-center">
                                    <span class="badge {{($key->is_active == 0)?'bg-red':'bg-green'}} ">{{($key->is_active == 0)?'ẩn':'hiển thị'}}</span>
                                    
                                </td>
                                <td align="center">
                                    
                                    {{-- <button class="btn btn-sm btn-success">Xem</button> --}}
                                    @can('update' , $key)
                                    <a href="{{ route('danh-muc.edit',['id'=>$key->id ]) }}" class="btn btn-xs btn-sm btn-warning" title="">
                                        <i class="fa fa-fw fa-pencil-square-o"></i>
                                    </a>
                                    @endcan
                                    @can('delete' , $key)
                                    <button type="button" class="btn btn-xs btn-sm btn-danger btn-delete" data-id="{{ $key->id }}" data-model="danh-muc">
                                        <i class="fa fa-fw fa-remove"></i>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                            @if($arrCategory->count() == 0)
                                <tr>
                                    <td colspan="8" class="text-center text-danger">Không tồn tại bản ghi nào</td>
                                </tr>
                            @endif

                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix text-center flex-row">
                        {{ $arrCategory->appends(request()->all())->links() }}
                        {{-- <ul class="pagination pagination-sm no-margin pull-right">
                                <li><a href="#">&laquo;</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">&raquo;</a></li>
                            </ul>--}}
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

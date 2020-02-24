@extends('contractors::layouts.master')

@section('content')
    <!-- Message Example -->

    @if(session('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <h2 class="border-bottom border-gray pb-2 mb-0">Бренд</h2>

            <div class="media text-muted pt-3">
                <a href="{{ route('brands.edit', $brand->id) }}"
                   class="btn btn-primary">Редактировать</a>
            </div>
            <div class="media text-muted pt-3">
                <div class="media-body mb-0 lh-125">


                    @csrf
                    @method('get')

                    <table class="table table-bordered table-sm">
                        <tr style="width: 180px;">
                            <td>id</td>
                            <td>{{ @$brand->id }}</td>
                        </tr>
                        <tr>

                        <tr style="width: 180px;">
                            <td>Наименование</td>
                            <td>{{ @$brand->name }}</td>
                        </tr>
                        <tr style="width: 180px;">
                            <td>Слаг</td>
                            <td>{{ @$brand->slug }}</td>
                        </tr>
                        <tr>
                            <td>Наименование родительского бренда</td>
                            <td>
                                @if(@$brand->parent_id)
                                    <span><a href="{{ route('brands.show', $brand->parent_id) }}">{{ @$brand->_parent_name }}</a></span>
                                    <br>
                                    <span style="color: #ccc;">id: {{ @$brand->parent_id }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Дочерние элементы</td>
                            <td>
                               @foreach($brand->children as $childBrand)
                                <span><a href="{{ route('brands.show', $childBrand->id) }}">{{ $childBrand->name }}</a></span><br>
                                   @endforeach

                            </td>
                        </tr>
                        <tr style="width: 180px;">
                            <td>Код страны</td>
                            <td>{{ @$brand->country_code }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

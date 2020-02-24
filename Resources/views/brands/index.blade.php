@extends('contractors::layouts.master')

@section('content')

    @if($errors->isNotEmpty())

    @endif

    <div class="container">
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <h2 class="border-bottom border-gray pb-2 mb-0">Бренды</h2>
            <div class="media text-muted pt-3">
                <a href="{{ route('brands.create') }}" class="btn btn-primary">Добавить</a>
            </div>
            <div class="media text-muted pt-3">
                <div class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                    <table class="table table-sm table-bordered table-light">
                        <tbody>
                        @foreach($brands->filter(function($item) { return !$item->parent_id; }) as $key => $brand)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>
                                    @if($brand->deleted_at)
                                        <span style="text-decoration: line-through;">{{ $brand->name }}</span>
                                    @else
                                        <span>{{ $brand->name }} {{ '('.count($brand->products).')' }}</span>
                                    @endif

                                    @if ($brand->parent_id)
                                        &nbsp;->&nbsp;&nbsp;{{ $brand->_parent_name }}
                                    @endif

                                    <br>
                                    <span style="color: #ccc;">id: {{ $brand->id }}</span>
                                </td>
                                <td>
                                    @foreach($brand->children as $childBrand)
                                        <span>{{ $childBrand->name }} {{ '('. count($childBrand->products).')' }}</span>
                                        <br>
                                        <span style="color: #ccc;">id: {{ $childBrand->id }}</span><br>
                                    @endforeach
                                </td>

                                <td><a href="{{ route('brands.show', $brand->id) }}"
                                       class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a></td>
                                <td>
                                    @if($brand->deleted_at)
                                        <form action="{{ route('brands.update', $brand->id) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="deleted_at" value="">
                                            <button type="submit"
                                                    class="btn btn-sm btn-secondary" {{ auth()->id() == 1 ?: 'disabled' }}>
                                                <i class="fa fa-share"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('brands.destroy', $brand->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="redirect" value="{{ route('brands.index') }}">
                                            <button type="submit"
                                                    class="btn btn-sm btn-secondary" {{ auth()->id() == 1 ?: 'disabled' }}>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

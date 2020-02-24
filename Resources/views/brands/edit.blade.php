@extends('contractors::layouts.master')

@section('content')
    <!-- Message Example -->
    <!--<div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>-->

    <div class="container">
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <h2 class="border-bottom border-gray pb-2 mb-0">Бренд</h2>

            @php
                /** @var \Modules\Shop\Entities\Brand $brand */
                $formAction = $brand->id ? route('brands.update', $brand->id) : route('brands.store');
                $formMethod = $brand->id ? 'patch' : 'post';
            @endphp

            <form action="{{ $formAction }}" method="post">
                @csrf
                @method($formMethod)

                <div class="media text-muted pt-3">
                    <input type="submit" value="Сохранить" class="btn btn-primary">
                </div>
                <div class="media text-muted pt-3">
                    <div class="media-body mb-0 lh-125">

                        <table class="table table-bordered table-sm">
                            <tr style="width: 180px;">
                                <td>id</td>
                                <td>{{ @$brand->id }}</td>
                            </tr>

                            <tr style="width: 180px;">
                                <td>Наименование</td>
                                <td><input type="text" name="name" autocomplete="off" value="{{ @$brand->name }}">
                                </td>
                            </tr>
                            <tr style="width: 180px;">
                                <td>Слаг</td>
                                <td><input type="text" name="slug" autocomplete="off"
                                           value="{{ @$brand->slug }}"></td>
                            </tr>
                            <tr style="width: 180px;">
                                <td>Наименование родительского бренда</td>
                                <td><input type="text" name="parent_name" autocomplete="off"
                                           value="{{ @$brand->_parent_name }}"></td>
                            </tr>
                            <tr style="width: 40px;">
                                <td>Код страны</td>
                                <td><input type="text" name="country_code" autocomplete="off" value="{{ @$brand->country_code }}">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.post.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.id') }}
                            </th>
                            <td>
                                {{ $post->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.categories') }}
                            </th>
                            <td>
                                @foreach($post->categories as $key => $category)
                                    <span class="label label-info">{{ $category->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.featured_position') }}
                            </th>
                            <td>
                                {{ $post->featuredPosition ?? ''}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.title') }}
                            </th>
                            <td>
                                {{ $post->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.subtitle') }}
                            </th>
                            <td>
                                {{ $post->subtitle }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.image_featured') }}
                            </th>
                            <td>
                                @if(!empty($post->featuredImageUrl))
                                    <a href="{{ $post->featuredImageUrl }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $post->featuredImageUrl }}"
                                             style="width: 80px; height: 80px; object-fit: cover;"
                                             loading="lazy"
                                        />
                                    </a>
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.content') }}
                            </th>
                            <td>
                                {!! $post->content !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.source') }}
                            </th>
                            <td>
                                {{ $post->source }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.user') }}
                            </th>
                            <td>
                                @foreach($post->users as $key => $user)
                                    <span class="label label-info">{{ $user->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.published_at') }}
                            </th>
                            <td>
                                {{ $post->published_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.tag') }}
                            </th>
                            <td>
                                @foreach($post->tags as $key => $tag)
                                    <span class="label label-info">{{ $tag->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.post.fields.status') }}
                            </th>
                            <td>
                                {{ App\Models\Post::STATUS_RADIO[$post->status] ?? '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

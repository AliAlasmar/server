@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">



                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Dashboard</div>

                                @if(Session::has('success'))
                                    <div class="col-6 alert alert-success justify-content-center d-flex">
                                        {{Session::get('success')}}
                                    </div>
                                @endif
                                @if(isset($data) && $data -> count() > 0)
                                    @foreach($data as $post)
                                        <div class="card-body">
                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            <h1> {{$post -> title}} - @if(Auth::id() == $post -> users -> id)   المالك @endif</h1>
                                            <br>
                                            {{$post -> content}}

                                            <br>
                                            <br>
                                                <h4>التعليقات</h4>
                                                @if($post->comments ->count() >0)

                                                    @foreach($post->comments as $comment)
                                                        <p>{{$comment -> comment}}</p>
                                                        <br>

                                                    @endforeach
                                                @endif
                                                <br><br>
                                            <form method="POST" action="{{route('comment.save')}}" enctype="multipart/form-data">
                                                @csrf

                                                <input type="hidden" name="post_id" value="{{$post -> id}}">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="post_content">
                                                    @error('name_ar')
                                                    <small class="form-text text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>


                                                @if(Auth::id() != $post -> users -> id)
                                                    <button type="submit" class="btn btn-primary">أضافه ردك</button>
                                                @endif
                                            </form>


                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>


        </div>
    </div>
</div>
@endsection

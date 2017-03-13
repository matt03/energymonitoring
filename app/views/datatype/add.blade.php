@extends('layout.master')

@section('contents')


<fieldset><legend>Add new data type</legend>
    <form action="{{url('datatype/add')}}" method="post">
        <div class="entry">
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
            @endforeach


            <div class="row">
                <div class="col-lg-2"><p>Name</p></div>
                <div class="col-lg-2"> <input type="text"  name= "name" class="form-control"/> </div>

            </div>

                                            <hr>
                                            <div class="sep"></div>

                                            <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                            <a class="btn btn-danger" href="{{ url('datatype') }}"> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
    </form>
</fieldset>
@stop
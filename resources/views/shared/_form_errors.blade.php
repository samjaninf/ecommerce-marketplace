@if($errors->any())
    <div class="row">
        <div class="col-xs-12">
            <p class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{$error}}<br>
                @endforeach
            </p>
        </div>
    </div>
@endif

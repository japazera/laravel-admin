<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
                        
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('success')}}

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('errors') || session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @if(session('errors'))
                        <ul>
                            @foreach (session('errors')->getMessages() as $error)
                                <li>{{$error[0]}}</li>
                            @endforeach
                        </ul>
                    @endif

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>

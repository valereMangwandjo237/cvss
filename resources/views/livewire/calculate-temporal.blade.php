<div class="card mx-4" style="max-width: 100%;">
    <div class="card-header text-white bg-secondary">Temporal Score</div>
    <div class="card-body">
        <div class="row d-flex mt-8px">
            @foreach($temporal as $cle => $valeur)
                <div class="col-md-6 ms-auto">
                    <h4 mt-2>{{ $cle }}</h4>
                    @foreach($valeur as $key => $val)
                        @if ($key != "id")
                        <button type="button" 
                        name="{{ $key }}" 
                        class="default {{$temporal[$cle]['id']}} btn btn-secondary mt-1" 
                        value="{{ $val }}">{{ $key }}</button>
                        @endif
                    @endforeach
                </div>
            
            @endforeach
        </div>
    </div>
</div>
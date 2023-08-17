<div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end text-white">
        @if ($base_score === null)
            <span class="danger mx-4 btn-lg">
                *Select values for all base metrics to generate score
            </span>
        @else
            <span class="btn btn-{{ $severity_base[1] }} mx-4 btn-lg" disabled>
                {{ $base_score }} <br>
                ({{ $severity_base[0] }})
            </span>
        @endif
        
    </div>

    <div class="card mx-4" style="max-width: 100%;">
        <div class="card-header text-white bg-secondary">Base Score</div>
        <div class="card-body">
            <div class="row d-flex mt-8px">
                @foreach($base as $cle => $valeur)
                    <div class="col-md-6 ms-auto">
                        <h4>{{ $cle }}</h4>
                        @foreach($valeur as $key => $val)
                            @if ($key != "id")
                                <button 
                                    type="button" id="" 
                                    class="{{$base[$cle]['id']}} btn btn-secondary mt-1" 
                                    value="{{ $val }}" 
                                    wire:click="recuperation({{ $val }}, '{{$base[$cle]['id']}}')"
                                    wire:ignore>
                                    {{ $key }}
                                </button>
                            @endif
                            
                        @endforeach
                    </div>
                
                @endforeach
            </div>
        </div>
    </div>
</div>


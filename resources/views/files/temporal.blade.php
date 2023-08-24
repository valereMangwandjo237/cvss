<div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end text-white">
        @if ($base_score === null)
            <span class="danger mx-4 btn-lg">
                *Select values for all base metrics to generate score
            </span>
        @else
            <span class="btn btn-{{ $severity_temporal[1] }} mx-4 btn-lg" disabled>
                {{ $score_temporal }} <br>
                ({{ $severity_temporal[0] }})
            </span>
        @endif
        
    </div>
    <div class="card mx-4" style="max-width: 100%;">
        <div class="card-header text-white bg-secondary">Temporal Score</div>
        <div class="card-body">
            <div class="row d-flex mt-8px">
                @foreach($temporal as $cle => $valeur)
                    <div class="col-md-12 ms-auto">
                        <h4 mt-2>{{ $cle }}</h4>
                        @foreach($valeur as $key => $val)
                            @if ($key != "id")
                            <button type="button" 
                                name="{{ $key }}" 
                                class="{{$temporal[$cle]['id']}} btn btn-secondary mt-1" 
                                value="{{ $val[1] }}" 
                                wire:click="recuperation({{ $val[1] }}, '{{ $temporal[$cle]['id'] }}', '{{ $val[0] }}')"
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
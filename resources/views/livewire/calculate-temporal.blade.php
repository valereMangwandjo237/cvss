<div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end text-white">
        <span class="btn btn-{{ $severity_base[1] }} mx-4 btn-lg" disabled>
            {{ $score_temporal }} <br>
            ({{ $severity_base[0] }})
        </span>
    </div>
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
                                class="{{$temporal[$cle]['id']}} btn btn-secondary mt-1" 
                                value="{{ $val }}" 
                                wire:click="recuperation({{ $val }}, '{{$temporal[$cle]['id']}}')"
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
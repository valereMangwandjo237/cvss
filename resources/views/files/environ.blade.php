<div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end text-white">
        @if ($base_score === null)
            <span class="danger mx-4 btn-lg">
                *Select values for all base metrics to generate score
            </span>
        @else
            <span class="btn btn-{{ $severity_env[1] }} mx-4 btn-lg" disabled>
                {{ $EnvironmentalScore }} <br>
                ({{ $severity_env[0] }})
            </span>
        @endif
        
    </div>

    <div class="card mx-4" style="max-width: 100%;">
        <div class="card-header text-white bg-secondary">Environmental Score</div>
        <div class="card-body">
            <div class="row d-flex mt-8px">
                @foreach($environmental as $cle => $valeur)
                    <div class="col-md-6 ms-auto">
                        <h4 mt-2>{{ $cle }}</h4>
                        @foreach($valeur as $key => $val)
                            @if ($key != "id")
                            <button 
                            type="button" 
                            name="{{ $key }}" 
                            class="{{$environmental[$cle]['id']}} btn btn-secondary mt-1"
                            wire:click="recuperation_env({{ $val[1] }}, '{{ $environmental[$cle]['id'] }}', '{{ $val[0] }}')"
                            value="{{ $val[1] }}"
                            wire:ignore>{{ $key }}</button>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
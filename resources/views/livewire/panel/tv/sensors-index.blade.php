<div>
    <div class="row">
        <div class="col col-3 col-lg-3" wire:poll.120000ms="internetServices">
            {{-- <x-adminlte-small-box title="{{ $downIs }} - {{ $upIs }}" text="Internet Services"
                icon="fas fa-sportsball" theme="info" /> --}}
            <div class="small-box bg-info">

                <div class="inner">
                    <h3><i class="fas fa-xs fa-arrow-down"></i>: {{$downIs}} <i class="ml-3 fas fa-xs fa-arrow-up"></i>: {{$upIs}}  </h3>

                    <h5>Internet Services</h5>
                </div>

             

                <div wire:loading.class.remove="d-none" wire:target="internetServices"class="overlay d-none">
                    <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
                </div>

            </div>
        </div>
        <div class="col col-3 col-lg-3" wire:poll.120000ms="fibercorpMuni">
            {{-- <x-adminlte-small-box title="{{ $downIs }} - {{ $upIs }}" text="Internet Services"
                icon="fas fa-sportsball" theme="info" /> --}}
            <div class="small-box bg-info">

                <div class="inner">
                    <h3><i class="fas fa-xs fa-arrow-down"></i>: {{$downFiberMuni}} <i class="ml-3 fas fa-xs fa-arrow-up"></i>: {{$upFiberMuni}}  </h3>

                    <h5>FiberCorp Municipio</h5>
                </div>

        

                <div wire:loading.class.remove="d-none" wire:target="fibercorpMuni"class="overlay d-none">
                    <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
                </div>

            </div>
        </div>
        <div class="col col-3 col-lg-3" wire:poll.120000ms="fibercorpAnexo">
            {{-- <x-adminlte-small-box title="{{ $downIs }} - {{ $upIs }}" text="Internet Services"
                icon="fas fa-sportsball" theme="info" /> --}}
            <div class="small-box bg-info">

                <div class="inner">
                    <h3><i class="fas fa-xs fa-arrow-down"></i>: {{$downFiberAnexo}} <i class="ml-3 fas fa-xs fa-arrow-up"></i>: {{$upFiberAnexo}}  </h3>

                    <h5>FiberCorp Anexo</h5>
                </div>

        

                <div wire:loading.class.remove="d-none" wire:target="fibercorpAnexo"class="overlay d-none">
                    <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
                </div>

            </div>
        </div>
    </div>
</div>

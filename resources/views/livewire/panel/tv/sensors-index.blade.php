<div>
    <div class="row" wire:poll.120000ms="internetServices">
        <div class="col col-3 col-lg-3">
            {{-- <x-adminlte-small-box title="{{ $downIs }} - {{ $upIs }}" text="Internet Services"
                icon="fas fa-sportsball" theme="info" /> --}}
            <div class="small-box bg-info">

                <div class="inner">
                    <h3><i class="fas fa-xs fa-arrow-down"></i>: {{$downIs}} <i class="ml-2 fas fa-xs fa-arrow-up"></i>: {{$upIs}}  </h3>

                    <h5>Internet Services</h5>
                </div>

                <div class="icon">
                    <i class="fas fa-sportsball"></i>
                </div>

                <div wire:loading.class.remove="d-none" wire:target="internetServices"class="overlay d-none">
                    <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <div class="row">

        @php
            $jsons = json_decode(file_get_contents(public_path('json/services.json'),false));
        @endphp
        @foreach ($jsons as $service)
        <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">{{ $service->service }}</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str($service->content)->limit(100) }}</p>
                <a href="{{ route('service',['service'=>strtolower(str_replace(' ',"-",$service->service))]) }}" class="card-link">Read More</a>
            </div>
        </div>
        @endforeach

        {{-- <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Tax</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str('We provide counsel on numerous tax-related concerns in Saudi Arabia, from corporate income tax to VAT, Excise Duty,')->limit(100) }}</p>
                <a href="{{ route('service',['service'=>'tax']) }}" class="card-link">Read More</a>
            </div>
        </div>

        <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Corporate And Commercial</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str('We provide advisory services to companies both within the country and internationally, addressing all aspects of corporate law ')->limit(100) }}</p>
                <a href="{{ route('service',['service'=>'corporate-and-commercial']) }}" class="card-link">Read More</a>
            </div>
        </div>

        <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Governance</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str('Our legal experts possess extensive experience in formulating governance policies in alignment with the Kingdom of Saudi Arabia’s legislation. ')->limit(100) }}</p>
                <a href="{{ route('service',['service'=>'governance']) }}" class="card-link">Read More</a>
            </div>
        </div>

        <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Dispute Resolution</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str('Our history is marked by effectively settling conflicts, which encompasses providing guidance on alternative methods of dispute resolution. ')->limit(100) }}</p>
                <a href="{{ route('service',['service'=>'dispute-resolution']) }}" class="card-link">Read More</a>
            </div>
        </div>

        <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Construction</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str('Our firm is adept at providing counsel on various construction-related issues in the Kingdom of Saudi Arabia. We frequently guide clients through ')->limit(100) }}</p>
                <a href="{{ route('service',['service'=>'construction']) }}" class="card-link">Read More</a>
            </div>
        </div>

        <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Foreign Investment</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str('Our group excels in facilitating the setup of international firms and their ventures within the Kingdom of Saudi Arabia ')->limit(100) }}</p>
                <a href="{{ route('service',['service'=>'foreign-investment']) }}" class="card-link">Read More</a>
            </div>
        </div>

        <div class="card col-md-4 border-0" style="width: 24rem;">
            <div class="card-body">
                <h5 class="card-title">Corporate Crime</h5>
                <p style="font-size:14px;font-weight:300;" class="card-text">{{ str('Our group is proficient in managing a wide array of Corporate & White Collar Crimes, encompassing financial misdeeds ')->limit(100) }}</p>
                <a href="{{ route('service',['service'=>'corporate-crimes']) }}" class="card-link">Read More</a>
            </div>
        </div> --}}
    </div>
</div>

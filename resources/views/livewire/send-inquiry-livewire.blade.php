{{-- <div class="container mb-4">
    <div class="row ">
        <div class="col-lg-8 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">

                    <div class="container">
                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                          </div>
                        @endif
                        <h3>{{ __('Send your inquiry') }}</h3>
                        <form wire:submit='send' id="contact-form" role="form">
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="firstname">{{ __('Firstname') }}</label>
                                            <input wire:model='firstname' id="firstname" type="text" name="firstname"
                                                class="form-control" required="required">
                                            @error('firstname') <span class="text-danger fs-6">{{ $message }}</span>@enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="lastname">{{ __('Lastname') }}</label>
                                            <input wire:model='lastname' id="lastname" type="text" name="lastname"
                                                class="form-control" required="required">
                                                @error('lastname') <span class="text-danger fs-6">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="email">{{ __('Email') }}</label>
                                            <input wire:model='email' id="email" type="email" name="email"
                                                class="form-control" required="required">
                                                @error('email') <span class="text-danger fs-6">{{ $message }}</span>@enderror


                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="phonenumber">{{ __('Phone Number') }}</label>
                                            <input wire:model='phonenumber' id="phonenumber" type="tel" name="phonenumber"

                                                class="form-control" required="required">
                                                @error('phonenumber') <span class="text-danger fs-6">{{ $message }}</span>@enderror


                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">

                                            <label for="legalIssue">{{ __('Please specify your legal issue') }}</label>
                                            <select wire:model='legalIssue' id="legalIssue" name="legalIssue"

                                                class="form-control" required="required">
                                                <option value="" selected>--{{ __('Select Legal Issue') }}--</option>
                                                <option>{{ __('Financial') }}</option>
                                                <option>{{ __('Parenting') }}</option>
                                                <option>{{ __('Divorce') }}</option>
                                                <option>{{ __('Other') }}</option>
                                            </select>
                                            @error('legalIssue') <span class="text-danger fs-6">{{ $message }}</span>@enderror


                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <label for="message">{{ __('Message') }}</label>
                                            <textarea wire:model='message' id="message" name="message"
                                                class="form-control" placeholder="{{ __('Write your inquiry here.') }}" rows="4"

                                                required="required"></textarea>
                                            @error('message') <span class="text-danger fs-6">{{ $message }}</span>@enderror
                                        </div>

                                    </div>


                                    <div class="col-md-12">
                                        <button wire:loading.attr='disabled' type="submit" style="background-color: #619af8;color:#fff;" class="btn btn-send  pt-2 btn-block">
                                            <span wire:loading.remove>{{ __('Send Inquiry') }}</span>
                                            <span wire:loading>{{ __("Sending...") }}</span>
                                        </button>
                                    </div>

                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.8 -->
        </div>
        <!-- /.row-->
    </div>
</div> --}}
<div class="container inquiry p-5">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    @endif
    <h4>{{ __('Send your inquiry') }}</h4>
    <form wire:submit='send' class="row mt-4">
        <div class="mb-3 col-md-3">
            <label for="firstname" class="form-label">{{ __('Firstname') }}</label>
            <input wire:model='firstname' type="text" class="form-control" id="firstname">
            @error('firstname') <span class="text-danger fs-6">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3 col-md-3">
            <label for="lastname" class="form-label">{{ __('Lastname') }}</label>
            <input wire:model='lastname' type="text" class="form-control" id="lastname">
            @error('lastname') <span class="text-danger fs-6">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="phonenumber" class="form-label">{{ __('Phone Number') }}</label>
            <input wire:model='phonenumber' type="text" class="form-control" id="phonenumber">
            @error('phonenumber') <span class="text-danger fs-6">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input wire:model='email' type="email" class="form-control" id="email">
            @error('email') <span class="text-danger fs-6">{{ $message }}</span>@enderror

        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">{{ __('Please specify your legal issue') }}</label>
            <select wire:model='legalIssue' class="form-control form-select">
                <option selected>Select Legal Issue</option>
                <option value="Financial">Financial</option>
                <option value="Parenting">Parenting</option>
                <option value="Others">Others</option>
            </select>
            @error('legalIssue') <span class="text-danger fs-6">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label">{{ __('Write your inquiry here') }}</label>
            <textarea wire:model='message' rows="7"></textarea>
            @error('message') <span class="text-danger fs-6">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-12">
            <button wire:loading.attr='disabled' type="submit" class="btn btn-primary">
                <span wire:loading.remove>{{ __('Send Inquiry') }}</span>
                <span wire:loading>{{ __("Sending...") }}</span>
            </button>
        </div>
    </form>
</div>

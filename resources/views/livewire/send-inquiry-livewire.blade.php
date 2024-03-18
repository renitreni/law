<div class="container mb-4">
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
                        <h3>Send your inquiry</h3>
                        <form wire:submit='send' id="contact-form" role="form">



                            <div class="controls">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input wire:model='firstname' id="firstname" type="text" name="firstname"
                                                class="form-control" required="required">
                                            @error('firstname') <span class="text-danger fs-6">{{ $message }}</span>@enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input wire:model='lastname' id="lastname" type="text" name="lastname"
                                                class="form-control" required="required">
                                                @error('lastname') <span class="text-danger fs-6">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input wire:model='email' id="email" type="email" name="email"
                                                class="form-control" required="required">
                                                @error('email') <span class="text-danger fs-6">{{ $message }}</span>@enderror


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="legalIssue">Please specify your legal issue</label>
                                            <select wire:model='legalIssue' id="legalIssue" name="legalIssue"
                                                class="form-control" required="required">
                                                <option value="" selected>--Select Legal Issue--</option>
                                                <option>Financial</option>
                                                <option>Parenting</option>
                                                <option>Divorce</option>
                                                <option>Other</option>
                                            </select>
                                            @error('legalIssue') <span class="text-danger fs-6">{{ $message }}</span>@enderror


                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea wire:model='message' id="message" name="message"
                                                class="form-control" placeholder="Write your inquiry here." rows="4"
                                                required="required"></textarea>
                                            @error('message') <span class="text-danger fs-6">{{ $message }}</span>@enderror
                                        </div>

                                    </div>


                                    <div class="col-md-12">
                                        <button wire:loading.attr='disabled' type="submit" style="background-color: #619af8;color:#fff;" class="btn btn-send  pt-2 btn-block">
                                            <span wire:loading.remove>Send Inquiry</span>
                                            <span wire:loading>Sending...</span>
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
</div>

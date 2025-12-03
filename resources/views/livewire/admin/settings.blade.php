<div class="main-side">
    <div class="main-title">
        <div class="small">
            @lang('admin.Home')
        </div>
        <div class="large">
            @lang('admin.General Settings')
        </div>
    </div>
    <x-admin-alert></x-admin-alert>
    <div class="row gutters" x-data="{ show: 'settigns' }">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card card-side">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="card-slide">
                            <button @click="show = 'settigns'" class="btn-icon justify-content-between d-flex">
                                الاعدادات الاساسية
                                <div class="icon">
                                    <i class="fas fa-angle-left"></i>
                                </div>
                            </button>
                        </div>
                        <div class="card-slide ">
                            <button @click="show = 'branches'" class="btn-icon justify-content-between d-flex">
                                الفروع
                                <div class="icon">
                                    <i class="fas fa-angle-left"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card" x-show="show === 'settigns'" x-transition>
                <div class="card-body">
                    <h6 class="mb-1">الاعدادات الاساسية</h6>
                    <hr>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span>@lang('admin.Name site')</span>
                                    <input type="text" wire:model="website_name" id="" class="form-control">
                                </label>
                            </div>
                        </div>
                        <!-- <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span>@lang('admin.URL site')</span>
                                    <input type="url" wire:model="website_url" id="" class="form-control">
                                </label>
                            </div>
                        </div> -->
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span>@lang('admin.Tax Number')</span>
                                    <input type="number" wire:model="tax_number" id="" class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span>@lang('admin.Address')</span>
                                    <input type="text" wire:model="address" id="" class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span>@lang('admin.Building number')</span>
                                    <input type="number" wire:model="building_number" id=""
                                        class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span>@lang('admin.Steet')</span>
                                    <input type="text" wire:model="street_number" id=""
                                        class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span>@lang('admin.Phone')</span>
                                    <input type="tel" wire:model="phone" id="" class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input">
                                    <span> @lang('admin.Email')</span>
                                    <input type="email" class="form-control" wire:model="email" id="">
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-label" for="tax">@lang('admin.Activate tax')</label>
                                <select wire:model="is_tax" id="tax" class="form-select">
                                    <option value="">@lang('admin.Active')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-label" for="siteStatus">@lang('admin.Site status')</label>
                                <select wire:model="website_status" id="siteStatus" class="form-select">
                                    <option value="">@lang('admin.Choose')</option>
                                    <option value="1">@lang('admin.Active')</option>
                                    <option value="0">@lang('admin.Inactive')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input mb-1">
                                    <span>@lang('admin.Logo image')</span>
                                    <input type="file" wire:model="logo" id="siteLogo" class="form-control">
                                </label>
                                @if ($show_logo)
                                    <img src="{{ display_file($show_logo) }}" alt="" width='50'>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="inp-holder">
                                <label class="special-input mb-1">
                                    <span>@lang('admin.Browser icon image')</span>
                                    <input type="file" wire:model="fav" id="siteLogo" class="form-control">
                                </label>
                                @if (setting('fav'))
                                    <img src="{{ display_file(setting('fav')) }}" alt="" width='50'>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row gap-0">
                        <div class=" col-md-6 ">
                            <label for="">{{ __('price_quotation_message') }}</label>
                            <textarea name="" wire:model="price_quotation_message" id="" rows="4" class="form-control"></textarea>
                        </div>
                        <div class=" col-md-6">
                            <label class="special-label" for="siteLogo">@lang('admin.Site deactivation message')</label>
                            <textarea wire:model="maintainance_message" id="" rows="4" class="form-control"
                                placeholder="نعتذر الموقع مغلق للصيانة ..."></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="btn-holder d-flex justify-content-center mt-4">
                            <button wire:click='save' type="button" class="main-btn">@lang('admin.Save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" x-show="show === 'branches'" x-transition>
            <div class="card-body">
                <h6 class="mb-1">الفروع</h6>
                <hr>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
                    <div class="col">
                        <label for="">الاسم</label>
                        <input class="form-control" type="text" />
                    </div>

                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="btn-holder d-flex justify-content-center mt-4">
                            <button wire:click='save' type="button" class="main-btn">@lang('admin.Save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

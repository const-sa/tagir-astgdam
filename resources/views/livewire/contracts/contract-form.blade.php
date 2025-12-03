<div class="{{request()->is('*/admin/*') ? 'main-side' : 'main-section users container'}}">
<div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <div class="main-title mb-0">
            <div class="small">{{ __('Home') }}</div>
            <div class="large">{{ __('Add :model', ['model' => 'عقد']) }}</div>
        </div>

        <a href="{{ route('admin.contracts') }}" class="main-btn bg-secondary">{{ __('Back') }} <i
                class="fas fa-arrow-left-long"></i></a>
    </div>
    <x-message-admin></x-message-admin>
    <div class="row g-3">
        <div class="col-12 col-md-4 col-lg-3">
            <label for="">العميل</label>
            <select wire:model='client_id' id="client_id" class="form-control">
                <option value="">اختر العميل</option>
                @foreach ($clients as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>تاريخ بداية العقد</span>
                    <input type="date" wire:model='contract_start_at' class="form-control">
                </label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>تاريخ نهاية العقد</span>
                    <input type="date" wire:model='contract_end_at' class="form-control">
                </label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>قيمه العقد المالية</span>
                    <input type="number" wire:model.live='amount' min="0" class="form-control">
                </label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="tax_included" wire:model.live="tax_included">
                <label class="form-check-label" for="tax_included">
                    المبلغ شامل ضريبة ؟
                </label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>قيمة الضريبة</span>
                    <input type="number" class="form-control" value="{{ $tax_amount }}" readonly>
                </label>
            </div>
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>إجمالي العقد بعد الضريبة</span>
                    <input type="number" class="form-control" value="{{ $total_with_tax }}" readonly>
                </label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>المدفوع مقدم</span>
                    <input type="number" wire:model.live='paid' min="0" class="form-control">
                </label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>المتبقي</span>
                    <input type="number" wire:model='rest' min="0" class="form-control" readonly>
                </label>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <label for="">المدينة</label>
            <select id="" class="form-control" wire:model='city_id'>
                <option value="">اختر المدينة</option>
                @foreach (App\Models\City::get() as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="inp-holder">
                <label class="special-input">
                    <span>ارفاق نسخه العقد</span>
                    <input type="file" class="form-control" wire:model='file'>
                </label>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-8">
            <label for="">بنود العقد</label>
            <textarea name="" id="" rows="5" class="form-control" wire:model="contract_terms"></textarea>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="btn-holder mt-2">
                <button wire:click='submit' class="btn btn-success btn-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>

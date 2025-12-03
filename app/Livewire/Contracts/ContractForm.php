<?php

namespace App\Livewire\Contracts;

use App\Models\Contract;
use App\Models\User;
use App\Traits\livewireResource;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContractForm extends Component
{
    use livewireResource;
    use WithFileUploads;
    public $user_id, $client_id, $contract_number, $paid, $rest, $contract_terms, $file,
     $city_id, $status, $contract_start_at, $contract_end_at, $scheduling_type, $payment_start_at, $amount, $installments_number;
    public $tax_included = false;
    public $tax_rate = 15;
    public $tax_amount = 0;
    public $total_with_tax = 0;
    public $model = Contract::class;

    public function rules()
    {
        return [
            'client_id' => 'required',
            'contract_number' => 'required',
            // 'status' => 'required',
            'contract_start_at' => 'required',
            'contract_end_at' => 'required',
            // 'scheduling_type' => 'required',
            // 'payment_start_at' => 'required',
            'amount' => 'required',
            'paid' => 'required',
            // 'rest' => 'required',
            'city_id' => 'nullable',
            'contract_terms' => 'nullable',
            'file' => 'nullable',
            // 'installments_number' => 'required'
        ];
    }
    public function mount($id = null)
    {
        if ($id) {
            $this->edit($id);
        } else {
            $this->contract_number = Contract::latest()->first()?->contract_number + 1 ?? 1;
        }
        $this->recalculateAmounts();
    }






    public function render()
    {
        $clients = User::clients()->pluck('name', 'id')->toArray();
        return view('livewire.contracts.contract-form', compact('clients'));
    }

    public function beforeSubmit()
    {
        $this->data['user_id'] = auth()->id();
        if ($this->file) {
            if ($this->obj) {
                if ($this->obj->file !== $this->file) {
                    delete_file($this->obj->file);
                    $this->data['file'] = store_file($this->file, 'contracts');
                }
            } else {
                $this->data['file'] = store_file($this->file, 'contracts');
            }
        }
    }
    public function afterSubmit()
    {
        return redirect()->route('admin.contracts')->with('success', __('Added successfully'));
    }


    protected function recalculateAmounts()
    {
        $amount = (float) ($this->amount ?? 0);
        $paid   = (float) ($this->paid ?? 0);
        $rate   = (float) $this->tax_rate;

        if ($amount < 0) $amount = 0;
        if ($paid < 0) $paid = 0;

        if ($this->tax_included) {
            $this->total_with_tax = $amount;
            if ($rate > 0) {
                $this->tax_amount = round($amount - ($amount / (1 + $rate / 100)), 2);
            } else {
                $this->tax_amount = 0;
            }
        } else {
            $this->tax_amount    = round($amount * $rate / 100, 2);
            $this->total_with_tax = $amount + $this->tax_amount;
        }
        if ($paid > $this->total_with_tax) {
            $paid = $this->total_with_tax;
            $this->paid = $paid;
        }
        $rest = $this->total_with_tax - $paid;
        $this->rest = $rest > 0 ? round($rest, 2) : 0;
    }
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['amount', 'paid', 'tax_included'])) {
            $this->recalculateAmounts();
        }
    }

}

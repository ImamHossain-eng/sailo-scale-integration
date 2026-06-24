<?php

namespace App\Livewire\Admin;

use App\Models\Party;
use App\Models\Vehicle;
use App\Models\Weighing;
use Livewire\Component;
use Livewire\WithPagination;

class WeighingHistory extends Component
{
    use WithPagination;

    // Filter Fields
    public $searchQuery = '';
    public $filterStatus = '';
    public $dateFrom;
    public $dateTo;

    // Editing State
    public $isEditing = false;
    public $editingWeighingId;

    // Editing Fields
    public $party_id;
    public $vehicle_id;
    public $driver_name;
    public $driver_phone;
    public $transport_name;
    public $product_name;
    public $quantity;
    public $challan_reference;
    public $first_weight;
    public $second_weight;
    public $wheels_count;

    protected $paginationTheme = 'bootstrap';

    protected function rules(): array
    {
        return [
            'party_id' => 'required|exists:parties,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_name' => 'nullable|string|max:255',
            'driver_phone' => 'nullable|string|max:255',
            'transport_name' => 'nullable|string|max:255',
            'product_name' => 'nullable|string|max:255',
            'quantity' => 'nullable|numeric|min:0',
            'challan_reference' => 'nullable|string|max:255',
            'first_weight' => 'required|numeric|min:1',
            'second_weight' => 'nullable|numeric|min:0',
            'wheels_count' => 'nullable|integer|min:2',
        ];
    }

    public function editRecord($id)
    {
        $weighing = Weighing::find($id);
        if ($weighing) {
            $this->editingWeighingId = $id;
            $this->party_id = $weighing->party_id;
            $this->vehicle_id = $weighing->vehicle_id;
            $this->driver_name = $weighing->driver_name;
            $this->driver_phone = $weighing->driver_phone;
            $this->transport_name = $weighing->transport_name;
            $this->product_name = $weighing->product_name;
            $this->quantity = $weighing->quantity;
            $this->challan_reference = $weighing->challan_reference;
            $this->first_weight = $weighing->first_weight;
            $this->second_weight = $weighing->second_weight;
            $this->wheels_count = $weighing->wheels_count;
            $this->isEditing = true;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['isEditing', 'editingWeighingId', 'party_id', 'vehicle_id', 'driver_name', 'driver_phone', 'transport_name', 'product_name', 'quantity', 'challan_reference', 'first_weight', 'second_weight', 'wheels_count']);
    }

    public function updateRecord()
    {
        $validatedData = $this->validate();
        
        $weighing = Weighing::find($this->editingWeighingId);
        if ($weighing) {
            $first = floatval($validatedData['first_weight']);
            $second = $validatedData['second_weight'] ? floatval($validatedData['second_weight']) : null;
            $net = $second ? abs($first - $second) : null;
            
            $weighing->update([
                'party_id' => $validatedData['party_id'],
                'vehicle_id' => $validatedData['vehicle_id'],
                'driver_name' => $validatedData['driver_name'],
                'driver_phone' => $validatedData['driver_phone'],
                'transport_name' => $validatedData['transport_name'],
                'product_name' => $validatedData['product_name'],
                'quantity' => $validatedData['quantity'],
                'challan_reference' => $validatedData['challan_reference'],
                'first_weight' => $first,
                'second_weight' => $second,
                'net_weight' => $net,
                'wheels_count' => $validatedData['wheels_count'],
                'status' => $second ? 'completed' : 'pending',
            ]);

            $this->cancelEdit();
            session()->flash('success', 'Weighing transaction record updated successfully.');
        }
    }

    public function deleteRecord($id)
    {
        $weighing = Weighing::find($id);
        if ($weighing) {
            $weighing->delete();
            session()->flash('success', 'Weighing record deleted.');
        }
    }

    public function render()
    {
        $partiesList = Party::orderBy('name')->get();
        $vehiclesList = Vehicle::orderBy('vehicle_number')->get();

        $records = Weighing::with(['party', 'vehicle', 'creator'])
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($q) {
                    $q->where('ticket_number', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('driver_name', 'like', '%' . $this->searchQuery . '%')
                      ->orWhereHas('party', function ($pq) {
                          $pq->where('name', 'like', '%' . $this->searchQuery . '%');
                      })
                      ->orWhereHas('vehicle', function ($vq) {
                          $vq->where('vehicle_number', 'like', '%' . $this->searchQuery . '%');
                      });
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('first_weight_datetime', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('first_weight_datetime', '<=', $this->dateTo);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.admin.weighing-history', [
            'records' => $records,
            'partiesList' => $partiesList,
            'vehiclesList' => $vehiclesList,
        ]);
    }
}

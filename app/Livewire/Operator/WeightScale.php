<?php

namespace App\Livewire\Operator;

use App\Models\Party;
use App\Models\Vehicle;
use App\Models\Vessel;
use App\Models\Weighing;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class WeightScale extends Component
{
    use WithPagination;

    // View States
    public $activeTab = 'scale-desk'; // 'scale-desk' or 'records'
    public $formMode = 'first-weight'; // 'first-weight' or 'second-weight'

    // Dropdown Data Arrays
    public $parties = [];
    public $vehicles = [];
    public $vessels = [];

    // Dropdown Selections
    public $selected_party_id = 'new';
    public $selected_vehicle_id = 'new';
    public $selected_vessel_id;

    // First Weight Form Fields
    public $party_name;
    public $party_address;
    public $contact_person;
    public $contact_number;
    public $vehicle_number;
    public $driver_name;
    public $driver_phone;
    public $transport_name;
    public $product_name;
    public $quantity;
    public $challan_reference;
    public $first_weight;

    // Second Weight Form Fields
    public $selected_weighing_id;
    public $selected_weighing;
    public $second_weight;
    public $wheels_count = 4;
    public $net_weight = 0;

    // Search and Filter Fields for Records Tab
    public $searchQuery = '';
    public $filterStatus = ''; // 'pending', 'completed' or empty for all

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->loadDropdowns();
        $this->challan_reference = $this->generateNextChallanRef();
    }

    public function loadDropdowns()
    {
        $this->parties = Party::orderBy('name')->get();
        $this->vehicles = Vehicle::orderBy('vehicle_number')->get();
        // Only load active ships that are currently unloading
        $this->vessels = Vessel::where('status', 'active')->orderBy('name')->get();
        
        // Auto-select the first active vessel if available
        if ($this->vessels->count() > 0 && empty($this->selected_vessel_id)) {
            $this->selected_vessel_id = $this->vessels->first()->id;
        }
    }

    protected function rules(): array
    {
        if ($this->formMode === 'first-weight') {
            $rules = [
                'selected_party_id' => 'required',
                'selected_vehicle_id' => 'required',
                'selected_vessel_id' => 'required|exists:vessels,id',
                'product_name' => 'nullable|string|max:255',
                'quantity' => 'nullable|numeric|min:0',
                'challan_reference' => 'nullable|string|max:255',
                'first_weight' => 'required|numeric|min:1',
            ];

            // If creating a new Party, validate party details
            if ($this->selected_party_id === 'new') {
                $rules['party_name'] = 'required|string|max:255|unique:parties,name';
                $rules['party_address'] = 'nullable|string|max:255';
                $rules['contact_person'] = 'nullable|string|max:255';
                $rules['contact_number'] = 'nullable|string|max:255';
            } else {
                $rules['selected_party_id'] = 'required|exists:parties,id';
            }

            // If creating a new Vehicle, validate vehicle details
            if ($this->selected_vehicle_id === 'new') {
                $rules['vehicle_number'] = 'required|string|max:255|unique:vehicles,vehicle_number';
                $rules['driver_name'] = 'nullable|string|max:255';
                $rules['driver_phone'] = 'nullable|string|max:255';
                $rules['transport_name'] = 'nullable|string|max:255';
            } else {
                $rules['selected_vehicle_id'] = 'required|exists:vehicles,id';
                $rules['driver_name'] = 'nullable|string|max:255';
                $rules['driver_phone'] = 'nullable|string|max:255';
                $rules['transport_name'] = 'nullable|string|max:255';
            }

            return $rules;
        } else {
            return [
                'selected_weighing_id' => 'required|exists:weighings,id',
                'second_weight' => 'required|numeric|min:1',
                'wheels_count' => 'required|integer|min:2',
            ];
        }
    }

    public function updated($propertyName)
    {
        // Dynamically compute Net Weight & Wheels when weights are changed
        if ($propertyName === 'second_weight' || $propertyName === 'first_weight') {
            $this->recalculateWeights();
        }

        // Auto-fill Client/Party Details if client name matches an existing party
        if ($propertyName === 'party_name') {
            $this->autoFillPartyDetails();
        }

        // Auto-fill Driver/Transport details if plate matches an existing vehicle
        if ($propertyName === 'vehicle_number') {
            $this->autoFillVehicleDetails();
        }
        
        // Auto-fill party_id if a vessel is selected (optional context helper)
        if ($propertyName === 'selected_vessel_id') {
            $vessel = Vessel::find($this->selected_vessel_id);
            if ($vessel && $this->selected_party_id === 'new') {
                $this->selected_party_id = $vessel->party_id;
                $this->updatedSelectedPartyId($this->selected_party_id);
            }
        }
    }

    private function autoFillPartyDetails()
    {
        if (!empty($this->party_name)) {
            $party = Party::where('name', 'like', trim($this->party_name))->first();
            if ($party) {
                $this->party_name = $party->name;
                $this->party_address = $party->address;
                $this->contact_person = $party->contact_person;
                $this->contact_number = $party->contact_number;
            }
        }
    }

    private function autoFillVehicleDetails()
    {
        if (!empty($this->vehicle_number)) {
            $vehicle = Vehicle::where('vehicle_number', 'like', trim(strtoupper($this->vehicle_number)))->first();
            if ($vehicle) {
                $this->vehicle_number = $vehicle->vehicle_number;
                $this->driver_name = $vehicle->default_driver_name;
                $this->driver_phone = $vehicle->default_driver_phone;
                $this->transport_name = $vehicle->default_transport_name;
                if ($vehicle->default_wheels_count) {
                    $this->wheels_count = $vehicle->default_wheels_count;
                }
            }
        }
    }

    public function selectWeighingForSecond($id)
    {
        $weighing = Weighing::with(['party', 'vehicle', 'vessel'])->find($id);
        if ($weighing && $weighing->status === 'pending') {
            $this->selected_weighing_id = $id;
            $this->selected_weighing = $weighing;
            $this->second_weight = '';
            $this->net_weight = 0;
            
            $this->wheels_count = $weighing->wheels_count ?? $weighing->vehicle->default_wheels_count ?? 4;
            $this->formMode = 'second-weight';
            $this->activeTab = 'scale-desk';
        }
    }

    public function cancelSecondWeight()
    {
        $this->selected_weighing_id = null;
        $this->selected_weighing = null;
        $this->second_weight = '';
        $this->net_weight = 0;
        $this->formMode = 'first-weight';
    }

    public function recalculateWeights()
    {
        if ($this->formMode === 'second-weight' && $this->selected_weighing) {
            $first = floatval($this->selected_weighing->first_weight);
            $second = floatval($this->second_weight);
            $this->net_weight = abs($first - $second);

            if ($this->net_weight < 6000) {
                $this->wheels_count = 4;
            } elseif ($this->net_weight >= 6000 && $this->net_weight < 10000) {
                $this->wheels_count = 6;
            } else {
                $this->wheels_count = 10;
            }
        }
    }

    public function saveFirstWeight()
    {
        $this->formMode = 'first-weight';
        $validatedData = $this->validate();

        DB::transaction(function () use ($validatedData) {
            // Find or create Party
            if ($this->selected_party_id === 'new') {
                $party = Party::create([
                    'name' => trim($validatedData['party_name']),
                    'address' => $validatedData['party_address'] ?? null,
                    'contact_person' => $validatedData['contact_person'] ?? null,
                    'contact_number' => $validatedData['contact_number'] ?? null,
                ]);
            } else {
                $party = Party::find($this->selected_party_id);
            }

            // Find or create Vehicle
            if ($this->selected_vehicle_id === 'new') {
                $vehicle = Vehicle::create([
                    'vehicle_number' => trim(strtoupper($validatedData['vehicle_number'])),
                    'default_driver_name' => $validatedData['driver_name'] ?? null,
                    'default_driver_phone' => $validatedData['driver_phone'] ?? null,
                    'default_transport_name' => $validatedData['transport_name'] ?? null,
                    'default_wheels_count' => 4,
                ]);
            } else {
                $vehicle = Vehicle::find($this->selected_vehicle_id);
                $vehicleUpdates = [];
                if (empty($vehicle->default_driver_name) && !empty($validatedData['driver_name'])) {
                    $vehicleUpdates['default_driver_name'] = $validatedData['driver_name'];
                }
                if (empty($vehicle->default_driver_phone) && !empty($validatedData['driver_phone'])) {
                    $vehicleUpdates['default_driver_phone'] = $validatedData['driver_phone'];
                }
                if (empty($vehicle->default_transport_name) && !empty($validatedData['transport_name'])) {
                    $vehicleUpdates['default_transport_name'] = $validatedData['transport_name'];
                }
                if (!empty($vehicleUpdates)) {
                    $vehicle->update($vehicleUpdates);
                }
            }

            // Autogenerate ticket number securely
            $latest = Weighing::lockForUpdate()->latest('id')->first();
            $nextNumber = $latest ? ((int) $latest->ticket_number + 1) : 1;
            $ticketNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            Weighing::create([
                'ticket_number' => $ticketNumber,
                'status' => 'pending',
                'party_id' => $party->id,
                'vehicle_id' => $vehicle->id,
                'vessel_id' => $validatedData['selected_vessel_id'],
                'driver_name' => $validatedData['driver_name'] ?: $vehicle->default_driver_name,
                'driver_phone' => $validatedData['driver_phone'] ?: $vehicle->default_driver_phone,
                'transport_name' => $validatedData['transport_name'] ?: $vehicle->default_transport_name,
                'product_name' => $validatedData['product_name'],
                'quantity' => $validatedData['quantity'],
                'challan_reference' => $validatedData['challan_reference'],
                'first_weight' => $validatedData['first_weight'],
                'first_weight_datetime' => Carbon::now(),
                'created_by' => auth()->id(),
            ]);
        });

        $this->resetForm();
        $this->selected_party_id = 'new';
        $this->selected_vehicle_id = 'new';
        $this->loadDropdowns();
        session()->flash('success', 'First weight ticket registered successfully!');
    }

    public function saveSecondWeight()
    {
        $this->formMode = 'second-weight';
        $validatedData = $this->validate();

        $weighing = Weighing::find($this->selected_weighing_id);
        if ($weighing && $weighing->status === 'pending') {
            $first = floatval($weighing->first_weight);
            $second = floatval($validatedData['second_weight']);
            $net = abs($first - $second);

            $weighing->update([
                'second_weight' => $second,
                'net_weight' => $net,
                'wheels_count' => $validatedData['wheels_count'],
                'second_weight_datetime' => Carbon::now(),
                'status' => 'completed',
                'completed_by' => auth()->id(),
            ]);

            $vehicle = Vehicle::find($weighing->vehicle_id);
            if ($vehicle && empty($vehicle->default_wheels_count)) {
                $vehicle->update(['default_wheels_count' => $validatedData['wheels_count']]);
            }

            $ticketNum = $weighing->ticket_number;
            $id = $weighing->id;
            
            $this->cancelSecondWeight();
            $this->loadDropdowns();
            session()->flash('success', "Ticket #{$ticketNum} completed successfully!");

            $this->dispatch('print-ticket', ['id' => $id]);
        }
    }

    private function resetForm()
    {
        $this->reset([
            'party_name', 'party_address', 'contact_person', 'contact_number',
            'vehicle_number', 'driver_name', 'driver_phone', 'transport_name',
            'product_name', 'quantity', 'first_weight'
        ]);
        $this->challan_reference = $this->generateNextChallanRef();
    }

    private function generateNextChallanRef(): string
    {
        $latest = Weighing::latest('id')->first();
        $nextNumber = $latest ? ((int) $latest->ticket_number + 1) : 1;
        $ticketNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        return 'CH-' . date('Ymd') . '-' . $ticketNumber;
    }

    public function render()
    {
        $pendingWeighings = Weighing::with(['party', 'vehicle', 'vessel'])
            ->pending()
            ->orderBy('id', 'desc')
            ->get();

        $records = Weighing::with(['party', 'vehicle', 'vessel'])
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($q) {
                    $q->where('ticket_number', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('driver_name', 'like', '%' . $this->searchQuery . '%')
                      ->orWhereHas('party', function ($pq) {
                          $pq->where('name', 'like', '%' . $this->searchQuery . '%');
                      })
                      ->orWhereHas('vessel', function ($vq) {
                          $vq->where('name', 'like', '%' . $this->searchQuery . '%');
                      })
                      ->orWhereHas('vehicle', function ($vq) {
                          $vq->where('vehicle_number', 'like', '%' . $this->searchQuery . '%');
                      });
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'recordsPage');

        return view('livewire.operator.weight-scale', [
            'pendingWeighings' => $pendingWeighings,
            'records' => $records,
        ]);
    }
}

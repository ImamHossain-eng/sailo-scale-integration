<?php

namespace App\Livewire\Admin;

use App\Models\Party;
use App\Models\Vessel;
use App\Models\Weighing;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class VesselManagement extends Component
{
    use WithPagination;

    // View State
    public $isCreating = false;

    // Form Fields
    public $name;
    public $party_id;
    public $arrival_date;
    public $daily_rent_rate = 1000.00;
    public $cargo_rate_per_ton = 40.00;

    // Filters
    public $searchQuery = '';
    public $filterStatus = '';

    protected $paginationTheme = 'bootstrap';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'party_id' => 'required|exists:parties,id',
            'arrival_date' => 'nullable|date',
            'daily_rent_rate' => 'required|numeric|min:0',
            'cargo_rate_per_ton' => 'required|numeric|min:0',
        ];
    }

    public function toggleCreateMode()
    {
        $this->isCreating = !$this->isCreating;
        if (!$this->isCreating) {
            $this->resetForm();
        }
    }

    public function startUnloading($id)
    {
        $vessel = Vessel::find($id);
        if ($vessel && $vessel->status === 'pending') {
            $vessel->update([
                'status' => 'active',
                'unload_start_datetime' => Carbon::now(),
            ]);
            session()->flash('success', "Unloading started for ship: {$vessel->name}");
        }
    }

    public function endUnloading($id)
    {
        $vessel = Vessel::find($id);
        if ($vessel && $vessel->status === 'active') {
            $vessel->update([
                'status' => 'inactive',
                'unload_end_datetime' => Carbon::now(),
            ]);
            session()->flash('success', "Unloading completed and bill generated for ship: {$vessel->name}");
        }
    }

    public function saveVessel()
    {
        $validatedData = $this->validate();

        Vessel::create([
            'name' => trim($validatedData['name']),
            'party_id' => $validatedData['party_id'],
            'status' => 'pending',
            'arrival_date' => $validatedData['arrival_date'] ? Carbon::parse($validatedData['arrival_date']) : Carbon::now(),
            'daily_rent_rate' => $validatedData['daily_rent_rate'],
            'cargo_rate_per_ton' => $validatedData['cargo_rate_per_ton'],
        ]);

        $this->resetForm();
        $this->isCreating = false;
        session()->flash('success', 'New Vessel registered successfully.');
    }

    public function deleteVessel($id)
    {
        $vessel = Vessel::find($id);
        if ($vessel) {
            // Check if there are weighings linked to this vessel
            if (Weighing::where('vessel_id', $id)->exists()) {
                session()->flash('error', 'Cannot delete vessel. Weighing records are associated with it.');
                return;
            }
            $vessel->delete();
            session()->flash('success', 'Vessel record deleted successfully.');
        }
    }

    private function resetForm()
    {
        $this->reset(['name', 'party_id', 'arrival_date']);
        $this->daily_rent_rate = 1000.00;
        $this->cargo_rate_per_ton = 40.00;
    }

    public function render()
    {
        $parties = Party::orderBy('name')->get();

        $vessels = Vessel::with(['party'])
            ->when($this->searchQuery, function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                      ->orWhereHas('party', function ($pq) {
                          $pq->where('name', 'like', '%' . $this->searchQuery . '%');
                      });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.vessel-management', [
            'vessels' => $vessels,
            'parties' => $parties,
        ]);
    }
}

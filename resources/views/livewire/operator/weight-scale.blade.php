<div>
    <!-- Navigation Tabs -->
    <div class="row mb-4">
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-fill shadow-sm rounded bg-white p-1">
                <li class="nav-item">
                    <a class="nav-link py-3 fw-semibold d-flex align-items-center justify-content-center border-0 rounded {{ $activeTab === 'scale-desk' ? 'active bg-warning text-dark' : 'text-secondary' }}" 
                       href="#" wire:click.prevent="$set('activeTab', 'scale-desk')">
                        <i class="bi bi-speedometer me-2 fs-5"></i>
                        Scale Weighing Desk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-semibold d-flex align-items-center justify-content-center border-0 rounded {{ $activeTab === 'records' ? 'active bg-warning text-dark' : 'text-secondary' }}" 
                       href="#" wire:click.prevent="$set('activeTab', 'records')">
                        <i class="bi bi-journal-text me-2 fs-5"></i>
                        Weighing Records & Search
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Livewire Session Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-success border-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <div>
                    {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- SCALE DESK TAB -->
    @if ($activeTab === 'scale-desk')
        <div class="row">
            <!-- Left Side: Form Desk -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header {{ $formMode === 'first-weight' ? 'bg-primary text-white' : 'bg-success text-white' }} d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0">
                            @if ($formMode === 'first-weight')
                                <i class="bi bi-arrow-right-circle me-2"></i> Phase 1: Register First Weight
                            @else
                                <i class="bi bi-arrow-left-right me-2"></i> Phase 2: Complete Second Weight
                            @endif
                        </h5>
                        <span class="badge bg-light text-dark fw-semibold px-3 py-2 fs-7">
                            Live Weighing Mode
                        </span>
                    </div>
                    
                    <div class="card-body p-4">
                        @if ($formMode === 'first-weight')
                            <!-- Phase 1: First Weight Form -->
                            <form wire:submit.prevent="saveFirstWeight">
                                <h6 class="text-primary text-uppercase fw-bold mb-3 border-bottom pb-2">Client / Party Section</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="selected_party_id" class="form-label fw-semibold">Select Client / Party <span class="text-danger">*</span></label>
                                        <select id="selected_party_id" wire:model.live="selected_party_id" class="form-select @error('selected_party_id') is-invalid @enderror">
                                            <option value="new">+ Register New Party / Client</option>
                                            @foreach($parties as $party)
                                                <option value="{{ $party->id }}">{{ $party->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('selected_party_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    @if($selected_party_id === 'new')
                                        <div class="col-md-6">
                                            <label for="party_name" class="form-label fw-semibold">New Party Name <span class="text-danger">*</span></label>
                                            <input type="text" id="party_name" wire:model="party_name" class="form-control @error('party_name') is-invalid @enderror" placeholder="e.g. Acme Corporation">
                                            @error('party_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="party_address" class="form-label fw-semibold">Party Address</label>
                                            <input type="text" id="party_address" wire:model="party_address" class="form-control @error('party_address') is-invalid @enderror" placeholder="e.g. 123 Industrial Area, Dhaka">
                                            @error('party_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="contact_person" class="form-label fw-semibold">Contact Person</label>
                                            <input type="text" id="contact_person" wire:model="contact_person" class="form-control @error('contact_person') is-invalid @enderror" placeholder="e.g. Manager John">
                                            @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="contact_number" class="form-label fw-semibold">Contact Number</label>
                                            <input type="text" id="contact_number" wire:model="contact_number" class="form-control @error('contact_number') is-invalid @enderror" placeholder="e.g. 017XXXXXXXX">
                                            @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    @else
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="p-3 bg-light rounded w-100 border-start border-primary border-3">
                                                <small class="text-muted d-block uppercase fw-bold fs-8">Selected Client Info</small>
                                                <strong>{{ $party_name }}</strong>
                                                <span class="d-block text-secondary fs-7">{{ $party_address ?? 'No Address Listed' }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <h6 class="text-primary text-uppercase fw-bold mb-3 border-bottom pb-2">Vehicle & Driver Section</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="selected_vehicle_id" class="form-label fw-semibold">Select Vehicle Number <span class="text-danger">*</span></label>
                                        <select id="selected_vehicle_id" wire:model.live="selected_vehicle_id" class="form-select @error('selected_vehicle_id') is-invalid @enderror">
                                            <option value="new">+ Register New Vehicle Plate</option>
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('selected_vehicle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    @if($selected_vehicle_id === 'new')
                                        <div class="col-md-6">
                                            <label for="vehicle_number" class="form-label fw-semibold">New Vehicle Number <span class="text-danger">*</span></label>
                                            <input type="text" id="vehicle_number" wire:model="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror" placeholder="e.g. DHAKA-METRO-TA-11-2222">
                                            @error('vehicle_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    @endif

                                    <div class="col-md-6">
                                        <label for="driver_name" class="form-label fw-semibold">Driver's Name</label>
                                        <input type="text" id="driver_name" wire:model="driver_name" class="form-control @error('driver_name') is-invalid @enderror" placeholder="e.g. Karim Ali">
                                        @error('driver_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="driver_phone" class="form-label fw-semibold">Driver Contact Cell</label>
                                        <input type="text" id="driver_phone" wire:model="driver_phone" class="form-control @error('driver_phone') is-invalid @enderror" placeholder="e.g. 018XXXXXXXX">
                                        @error('driver_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="transport_name" class="form-label fw-semibold">Transport Company</label>
                                        <input type="text" id="transport_name" wire:model="transport_name" class="form-control @error('transport_name') is-invalid @enderror" placeholder="e.g. Bengal Logistics">
                                        @error('transport_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <h6 class="text-primary text-uppercase fw-bold mb-3 border-bottom pb-2">Vessel (Ship) & Cargo Section</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-12">
                                        <label for="selected_vessel_id" class="form-label fw-semibold">Select Active Unloading Vessel (Ship) <span class="text-danger">*</span></label>
                                        @if(count($vessels) > 0)
                                            <select id="selected_vessel_id" wire:model.live="selected_vessel_id" class="form-select @error('selected_vessel_id') is-invalid @enderror">
                                                <option value="">-- Choose Active Ship --</option>
                                                @foreach($vessels as $v)
                                                    <option value="{{ $v->id }}">{{ $v->name }} (Client: {{ $v->party->name }})</option>
                                                @endforeach
                                            </select>
                                            @error('selected_vessel_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        @else
                                            <div class="alert alert-danger border-0 mb-0 shadow-sm">
                                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                                <strong>No active unloading ships at port!</strong> Weighing is blocked. Please ask an administrator to start unloading for a ship first.
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <label for="product_name" class="form-label fw-semibold">Product Name</label>
                                        <input type="text" id="product_name" wire:model="product_name" class="form-control" placeholder="e.g. Coal, Rice, Sand">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label fw-semibold">Quantity (Bags / Units)</label>
                                        <input type="number" step="0.01" id="quantity" wire:model="quantity" class="form-control" placeholder="e.g. 250">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="challan_reference" class="form-label fw-semibold">Challan Ref / Email</label>
                                        <input type="text" id="challan_reference" wire:model="challan_reference" class="form-control" placeholder="e.g. CH-2026-981">
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <label for="first_weight" class="form-label fw-bold text-dark fs-5">First Weight Reading (kg) <span class="text-danger">*</span></label>
                                                <div class="input-group input-group-lg">
                                                    <input type="number" step="0.01" id="first_weight" wire:model.live="first_weight" class="form-control fw-bold text-primary @error('first_weight') is-invalid @enderror" placeholder="0.00">
                                                    <span class="input-group-text bg-primary text-white fw-bold">KG</span>
                                                    @error('first_weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <small class="text-muted mt-2 d-block">
                                                    Input the gross or tare scale value measured upon entry.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold" @if(count($vessels) == 0) disabled @endif>
                                        <i class="bi bi-save me-2"></i> Save and Register First Weight
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Phase 2: Second Weight Form -->
                            <form wire:submit.prevent="saveSecondWeight">
                                <div class="alert alert-info border-0 shadow-sm mb-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1 fw-bold text-dark">Processing Ticket #{{ $selected_weighing->ticket_number }}</h6>
                                            <p class="mb-0 text-muted fs-7">
                                                Vehicle: <strong>{{ $selected_weighing->vehicle->vehicle_number }}</strong> | 
                                                Party: <strong>{{ $selected_weighing->party->name }}</strong> |
                                                Vessel: <strong>{{ $selected_weighing->vessel->name }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                            <span class="badge bg-primary px-3 py-2 fs-7">1st Wt: {{ number_format($selected_weighing->first_weight, 2) }} kg</span>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="text-success text-uppercase fw-bold mb-3 border-bottom pb-2">Secondary Calculations</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light p-3 h-100">
                                            <label for="second_weight" class="form-label fw-bold text-dark fs-6">Second Weight (kg) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" id="second_weight" wire:model.live="second_weight" class="form-control fw-bold text-success @error('second_weight') is-invalid @enderror" placeholder="0.00" autofocus>
                                                <span class="input-group-text bg-success text-white fw-bold">KG</span>
                                                @error('second_weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <small class="text-muted mt-2 d-block">
                                                Input the measured weight of the vehicle leaving.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light p-3 h-100">
                                            <label for="wheels_count" class="form-label fw-bold text-dark fs-6">Number of Wheels <span class="text-danger">*</span></label>
                                            <select id="wheels_count" wire:model="wheels_count" class="form-select @error('wheels_count') is-invalid @enderror">
                                                <option value="4">4 Wheels (Light Truck / Pickup)</option>
                                                <option value="6">6 Wheels (Medium Duty Truck)</option>
                                                <option value="10">10 Wheels (Heavy Duty Rig / Semi)</option>
                                                <option value="12">12 Wheels (Multi-Axle Truck)</option>
                                                <option value="14">14+ Wheels (Heavy Cargo Carrier)</option>
                                            </select>
                                            @error('wheels_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <small class="text-muted mt-2 d-block">
                                                Calculated automatically based on cargo weight, or adjust manually.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card bg-success bg-opacity-10 border-0 p-3">
                                            <div class="row text-center">
                                                <div class="col-md-4 border-end">
                                                    <span class="text-muted d-block fs-7">First Weight</span>
                                                    <span class="fs-4 fw-bold text-dark">{{ number_format($selected_weighing->first_weight, 2) }} kg</span>
                                                </div>
                                                <div class="col-md-4 border-end">
                                                    <span class="text-muted d-block fs-7">Second Weight</span>
                                                    <span class="fs-4 fw-bold text-dark">{{ number_format(floatval($second_weight), 2) }} kg</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-muted d-block fs-7">Net Payload Weight</span>
                                                    <span class="fs-4 fw-bold text-success">{{ number_format($net_weight, 2) }} kg</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-success btn-lg py-3 fw-bold w-100">
                                            <i class="bi bi-printer-fill me-2"></i> Save & Print Final Receipt
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" wire:click="cancelSecondWeight" class="btn btn-outline-secondary btn-lg py-3 w-100">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side: Active / Pending Trucks Yard -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100 bg-light">
                    <div class="card-header bg-dark text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-clock-history me-2"></i> Trucks in Yard
                            </h5>
                            <span class="badge bg-warning text-dark rounded-pill fw-bold">
                                {{ count($pendingWeighings) }} Pending
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body p-3 overflow-auto" style="max-height: 650px;">
                        @if (count($pendingWeighings) > 0)
                            <div class="list-group">
                                @foreach ($pendingWeighings as $pw)
                                    <div class="list-group-item list-group-item-action border-0 shadow-sm rounded mb-3 p-3 bg-white">
                                        <div class="d-flex w-100 justify-content-between align-items-start border-bottom pb-2 mb-2">
                                            <div>
                                                <span class="badge bg-secondary mb-1">TID #{{ $pw->ticket_number }}</span>
                                                <h6 class="mb-0 fw-bold text-dark fs-6">{{ $pw->vehicle->vehicle_number }}</h6>
                                            </div>
                                            <small class="text-muted">{{ $pw->first_weight_datetime->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 text-secondary fs-7">
                                            Party: <strong>{{ $pw->party->name }}</strong> | 
                                            Vessel: <strong>{{ $pw->vessel->name }}</strong>
                                        </p>
                                        <p class="mb-3 text-secondary fs-7">
                                            First Weight: <strong class="text-primary">{{ number_format($pw->first_weight, 2) }} kg</strong>
                                        </p>
                                        
                                        <button wire:click="selectWeighingForSecond('{{ $pw->id }}')" 
                                                class="btn btn-warning btn-sm w-100 fw-bold text-dark d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box-arrow-right me-1"></i> Register Second Weight
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-check2-circle display-4 text-success mb-3"></i>
                                <h6 class="fw-semibold text-dark">Yard is empty!</h6>
                                <p class="text-muted fs-7 mb-0">All incoming vehicles have completed their second weighings.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- WEIGHING RECORDS TAB -->
    @if ($activeTab === 'records')
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center g-3">
                            <div class="col-md-4">
                                <h5 class="mb-0 fw-bold text-dark">Weighing Transactions</h5>
                            </div>
                            <!-- Live Search and Status Filter -->
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" wire:model.live.debounce.300ms="searchQuery" class="form-control border-0 bg-light" placeholder="Search by Ticket ID, Party, or Vehicle Number...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select border-0 bg-light" wire:model.live="filterStatus">
                                    <option value="">All Statuses</option>
                                    <option value="pending">Pending (1st Weight Only)</option>
                                    <option value="completed">Completed (Full)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>Vehicle Number</th>
                                        <th>Party / Client Name</th>
                                        <th>Vessel (Ship)</th>
                                        <th>Product</th>
                                        <th>First Weight</th>
                                        <th>Second Weight</th>
                                        <th>Net Weight</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th class="text-center">Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($records as $record)
                                        <tr>
                                            <td class="fw-bold">#{{ $record->ticket_number }}</td>
                                            <td class="fw-semibold text-dark">{{ $record->vehicle->vehicle_number }}</td>
                                            <td>{{ $record->party->name }}</td>
                                            <td class="fw-bold text-info"><i class="bi bi-ship me-1"></i>{{ $record->vessel->name }}</td>
                                            <td>{{ $record->product_name ?? '—' }}</td>
                                            <td>{{ number_format($record->first_weight, 2) }} kg</td>
                                            <td>
                                                @if ($record->second_weight)
                                                    {{ number_format($record->second_weight, 2) }} kg
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold {{ $record->net_weight ? 'text-success' : '' }}">
                                                @if ($record->net_weight)
                                                    {{ number_format($record->net_weight, 2) }} kg
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($record->status === 'completed')
                                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 fs-8 rounded">Completed</span>
                                                @else
                                                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 fs-8 rounded">Pending</span>
                                                @endif
                                            </td>
                                            <td class="fs-7 text-muted">
                                                {{ $record->first_weight_datetime->format('Y-m-d h:i A') }}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    @if ($record->status === 'completed')
                                                        <a href="{{ route('operator.weighings.print', $record->id) }}" target="_blank" class="btn btn-outline-primary" title="Print Challan Slip">
                                                            <i class="bi bi-printer"></i> Print
                                                        </a>
                                                    @else
                                                        <button wire:click="selectWeighingForSecond('{{ $record->id }}')" class="btn btn-warning text-dark" title="Weigh Out">
                                                            <i class="bi bi-box-arrow-right"></i> Weigh Out
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-5 text-muted">
                                                <i class="bi bi-file-earmark-bar-graph display-4 mb-3 d-block"></i>
                                                No weighing records matching the filter criteria.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $records->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Listen to print event -->
    @script
    <script>
        $wire.on('print-ticket', (data) => {
            const id = data[0].id;
            window.open(`/operator/weighings/${id}/print`, '_blank');
        });
    </script>
    @endscript
</div>

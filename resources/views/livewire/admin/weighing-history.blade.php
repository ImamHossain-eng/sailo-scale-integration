<div>
    <!-- Success Alert -->
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

    @if ($isEditing)
        <!-- EDIT TRANSACTION FORM -->
        <div class="card shadow-sm border-0 mb-4 border-start border-warning border-4">
            <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Weighing Transaction Record</h5>
                <button type="button" class="btn-close" wire:click="cancelEdit" aria-label="Close"></button>
            </div>
            <div class="card-body p-4">
                <form wire:submit.prevent="updateRecord">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="edit_party" class="form-label fw-semibold">Client / Party</label>
                            <select id="edit_party" wire:model="party_id" class="form-select @error('party_id') is-invalid @enderror">
                                @foreach($partiesList as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('party_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="edit_vehicle" class="form-label fw-semibold">Vehicle Number</label>
                            <select id="edit_vehicle" wire:model="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror">
                                @foreach($vehiclesList as $v)
                                    <option value="{{ $v->id }}">{{ $v->vehicle_number }}</option>
                                @endforeach
                            </select>
                            @error('vehicle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="edit_challan" class="form-label fw-semibold">Challan Ref</label>
                            <input type="text" id="edit_challan" wire:model="challan_reference" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_driver" class="form-label fw-semibold">Driver Name</label>
                            <input type="text" id="edit_driver" wire:model="driver_name" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_phone" class="form-label fw-semibold">Driver Phone</label>
                            <input type="text" id="edit_phone" wire:model="driver_phone" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_transport" class="form-label fw-semibold">Transport Company</label>
                            <input type="text" id="edit_transport" wire:model="transport_name" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_product" class="form-label fw-semibold">Product Name</label>
                            <input type="text" id="edit_product" wire:model="product_name" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_qty" class="form-label fw-semibold">Quantity</label>
                            <input type="number" step="0.01" id="edit_qty" wire:model="quantity" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_wheels" class="form-label fw-semibold">Axle Wheels</label>
                            <select id="edit_wheels" wire:model="wheels_count" class="form-select">
                                <option value="4">4 Wheels</option>
                                <option value="6">6 Wheels</option>
                                <option value="10">10 Wheels</option>
                                <option value="12">12 Wheels</option>
                                <option value="14">14 Wheels</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light border-0 p-3">
                                <label for="edit_fw" class="form-label fw-bold text-dark fs-6">First Weight (kg)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="edit_fw" wire:model="first_weight" class="form-control fw-bold text-primary @error('first_weight') is-invalid @enderror">
                                    <span class="input-group-text bg-primary text-white">KG</span>
                                    @error('first_weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light border-0 p-3">
                                <label for="edit_sw" class="form-label fw-bold text-dark fs-6">Second Weight (kg) <small class="text-muted">(leave empty if pending)</small></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="edit_sw" wire:model="second_weight" class="form-control fw-bold text-success @error('second_weight') is-invalid @enderror">
                                    <span class="input-group-text bg-success text-white">KG</span>
                                    @error('second_weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" wire:click="cancelEdit" class="btn btn-outline-secondary px-4">Cancel</button>
                        <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- FILTER BOARD -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-filter-left me-2 text-primary"></i>Query & Filters</h5>
        </div>
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search Query</label>
                    <input type="text" wire:model.live.debounce.300ms="searchQuery" class="form-control" placeholder="Search by Ticket#, vehicle or driver...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending (First Weight)</option>
                        <option value="completed">Completed (Full)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date From</label>
                    <input type="date" wire:model.live="dateFrom" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date To</label>
                    <input type="date" wire:model.live="dateTo" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <!-- DATA TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Ticket ID</th>
                            <th>Vehicle</th>
                            <th>Party / Client</th>
                            <th>Driver</th>
                            <th>Product</th>
                            <th>1st Weight</th>
                            <th>2nd Weight</th>
                            <th>Net Weight</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $r)
                            <tr>
                                <td class="fw-bold">#{{ $r->ticket_number }}</td>
                                <td class="fw-semibold text-dark">{{ $r->vehicle->vehicle_number }}</td>
                                <td>{{ $r->party->name }}</td>
                                <td>
                                    <span class="d-block">{{ $r->driver_name ?? '—' }}</span>
                                    <small class="text-muted fs-8">{{ $r->driver_phone }}</small>
                                </td>
                                <td>{{ $r->product_name ?? '—' }}</td>
                                <td>{{ number_format($r->first_weight, 2) }} kg</td>
                                <td>
                                    @if($r->second_weight)
                                        {{ number_format($r->second_weight, 2) }} kg
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-success">
                                    @if($r->net_weight)
                                        {{ number_format($r->net_weight, 2) }} kg
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->status === 'completed')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded px-2 py-1 fs-8">Completed</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded px-2 py-1 fs-8">Pending</span>
                                    @endif
                                </td>
                                <td class="fs-7 text-muted">{{ $r->first_weight_datetime->format('Y-m-d h:i A') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button wire:click="editRecord('{{ $r->id }}')" class="btn btn-outline-warning text-dark" title="Edit Ticket">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button onclick="confirm('Are you sure you want to delete ticket #{{ $r->ticket_number }}?') || event.stopImmediatePropagation()" 
                                                wire:click="deleteRecord('{{ $r->id }}')" class="btn btn-outline-danger" title="Delete Ticket">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        @if($r->status === 'completed')
                                            <a href="{{ route('operator.weighings.print', $r->id) }}" target="_blank" class="btn btn-outline-primary" title="Print Slip">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="bi bi-info-circle display-4 mb-3 d-block"></i>
                                    No records found matching filters.
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

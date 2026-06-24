<div>
    <!-- Session Messages -->
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
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-danger border-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                <div>
                    {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-dark"><i class="bi bi-ship text-primary me-2"></i>Vessel (Ship) Billing Registry</h4>
        <button wire:click="toggleCreateMode" class="btn {{ $isCreating ? 'btn-secondary' : 'btn-primary' }} fw-bold shadow-sm">
            @if($isCreating)
                <i class="bi bi-x-circle me-1"></i> Close Form
            @else
                <i class="bi bi-plus-circle me-1"></i> Register New Ship / Vessel
            @endif
        </button>
    </div>

    @if ($isCreating)
        <!-- REGISTER SHIP FORM -->
        <div class="card shadow-sm border-0 mb-4 border-start border-primary border-4 animate__animated animate__fadeIn">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-dark">Register Vessel Information</h5>
            </div>
            <div class="card-body p-4">
                <form wire:submit.prevent="saveVessel">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Vessel / Ship Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. M.V. Akbar">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="party_id" class="form-label fw-semibold">Owner Client / Party Name <span class="text-danger">*</span></label>
                            <select id="party_id" wire:model="party_id" class="form-select @error('party_id') is-invalid @enderror">
                                <option value="">-- Choose Party / Client --</option>
                                @foreach($parties as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('party_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="arrival_date" class="form-label fw-semibold">Arrival Date</label>
                            <input type="date" id="arrival_date" wire:model="arrival_date" class="form-control @error('arrival_date') is-invalid @enderror">
                            @error('arrival_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="daily_rent_rate" class="form-label fw-semibold">Daily Rent Rate (BDT) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" step="0.01" id="daily_rent_rate" wire:model="daily_rent_rate" class="form-control @error('daily_rent_rate') is-invalid @enderror">
                                @error('daily_rent_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <small class="text-muted">Charge for port stay stay/day.</small>
                        </div>

                        <div class="col-md-4">
                            <label for="cargo_rate_per_ton" class="form-label fw-semibold">Cargo Rate / Ton (BDT) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" step="0.01" id="cargo_rate_per_ton" wire:model="cargo_rate_per_ton" class="form-control @error('cargo_rate_per_ton') is-invalid @enderror">
                                @error('cargo_rate_per_ton') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <small class="text-muted">Charge for unloading weight/ton.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" wire:click="toggleCreateMode" class="btn btn-outline-secondary px-4">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Register Ship</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- QUERY FILTERS -->
    <div class="card shadow-sm border-0 mb-4 bg-light">
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="searchQuery" class="form-control border-0" placeholder="Search by Ship Name or Client Name...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select wire:model.live="filterStatus" class="form-select border-0">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending (Not Started)</option>
                        <option value="active">Active Unloading (Stay Billed)</option>
                        <option value="inactive">Completed / Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- LIST OF VESSELS -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Ship Name</th>
                            <th>Owner Client</th>
                            <th>Arrival Date</th>
                            <th>Status</th>
                            <th>Unload Timeframe</th>
                            <th class="text-center">Stay Duration</th>
                            <th class="text-center">Cargo (MT)</th>
                            <th class="text-end">Billing (Rent + Cargo)</th>
                            <th class="text-center" width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vessels as $v)
                            <tr>
                                <td class="fw-bold"><i class="bi bi-ship text-secondary me-2"></i>{{ $v->name }}</td>
                                <td>{{ $v->party->name }}</td>
                                <td>{{ $v->arrival_date ? $v->arrival_date->format('Y-m-d') : '—' }}</td>
                                <td>
                                    @if($v->status === 'pending')
                                        <span class="badge bg-secondary">Pending</span>
                                    @elseif($v->status === 'active')
                                        <span class="badge bg-warning text-dark px-3 py-2 fw-semibold animate__animated animate__pulse animate__infinite">Active Unloading</span>
                                    @else
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($v->unload_start_datetime)
                                        <small class="d-block text-success">Start: {{ $v->unload_start_datetime->format('Y-m-d H:i') }}</small>
                                    @endif
                                    @if($v->unload_end_datetime)
                                        <small class="d-block text-danger">End: {{ $v->unload_end_datetime->format('Y-m-d H:i') }}</small>
                                    @endif
                                    @if(!$v->unload_start_datetime)
                                        <span class="text-muted fs-7">—</span>
                                    @endif
                                </td>
                                <td class="text-center fw-semibold">
                                    @if($v->unload_start_datetime)
                                        {{ $v->stay_days }} Days
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center fw-semibold">
                                    {{ number_format($v->total_tonnage, 2) }} MT
                                </td>
                                <td class="text-end fw-bold text-dark fs-6">
                                    @if($v->unload_start_datetime)
                                        ৳{{ number_format($v->total_bill, 2) }}
                                        <small class="d-block text-muted fw-normal fs-8">
                                            (৳{{ number_format($v->rent_bill, 0) }} Rent + ৳{{ number_format($v->cargo_bill, 0) }} Tonnage)
                                        </small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-grid gap-1">
                                        @if($v->status === 'pending')
                                            <button wire:click="startUnloading('{{ $v->id }}')" 
                                                    class="btn btn-warning btn-sm fw-bold text-dark">
                                                <i class="bi bi-play-fill"></i> Start Unloading
                                            </button>
                                        @elseif($v->status === 'active')
                                            <button wire:click="endUnloading('{{ $v->id }}')" 
                                                    class="btn btn-success btn-sm fw-bold text-white">
                                                <i class="bi bi-stop-fill"></i> End & Invoice
                                            </button>
                                        @else
                                            <!-- Print Invoice button -->
                                            <a href="{{ route('admin.vessels.print', $v->id) }}" target="_blank" 
                                               class="btn btn-outline-primary btn-sm fw-bold">
                                                <i class="bi bi-printer-fill me-1"></i> Print Bill Slip
                                            </a>
                                        @endif
                                        
                                        <button onclick="confirm('Delete ship record: {{ $v->name }}?') || event.stopImmediatePropagation()" 
                                                wire:click="deleteVessel('{{ $v->id }}')" 
                                                class="btn btn-outline-danger btn-sm p-1 fs-8 border-0" 
                                                title="Delete Ship">
                                            <i class="bi bi-trash"></i> Delete Ship
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-ship display-4 mb-3 d-block"></i>
                                    No vessels found matching criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $vessels->links() }}
        </div>
    </div>
</div>

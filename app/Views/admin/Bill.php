<?= $this->extend("layouts/admin/base"); ?>
<?= $this->section("content"); ?>

<?php
    $firstName = esc($admin['first_name']);
    $lastName  = esc($admin['last_name']);
    $role      = esc($admin['role']);
    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
?>

<div class="main-content" id="main-content">
    <div class="top-navbar">
        <h4 class="page-title">Billing</h4>
        <div class="user-profile">
            <div class="user-info">
                <p class="user-name"><?= $firstName . ' ' . $lastName ?></p>
                <p class="user-role"><?= $role ?></p>
            </div>
            <div class="user-image"><?= $initials ?></div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Filters and Actions -->
    <div class="patient-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="sort-container">
                <label for="sortDisplay" class="me-2">Show:</label>
                <select id="sortDisplay" class="form-select">
                    <option value="10">10</option>
                    <option value="25">15</option>
                    <option value="50">20</option>
                    <option value="100">30</option>
                </select>
            </div>

            <div class="search-container d-flex align-items-center">
                <form action="<?= site_url('admin/searchStaff') ?>" method="GET" class="d-flex w-100">
                    <input type="text" name="search" class="form-control flex-grow-1 me-2"
                           placeholder="Search by Username or Name"
                           value="<?= esc($searchTerm ?? '') ?>" required>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                    <i class="fas fa-plus"></i> Add Invoice
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Bill ID</th>
                        <th>Patient Name</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listofbill as $billing): ?>
                   <tr>
    <td><?= esc($billing['billing_id']) ?></td>
    <td><?= esc($billing['full_name']) ?></td> 
    <td><?= number_format($billing['amount'], 2) ?></td>
    <td><?= $billing['payment_date'] ? esc($billing['payment_date']) : '-' ?></td>
    <td><?= esc($billing['notes']) ?></td>
    <td>
        <?php if ($billing['payment_status'] === 'Paid'): ?>
            <span class="badge bg-success">Paid</span>
        <?php else: ?>
            <span class="badge bg-danger">Unpaid</span>
        <?php endif; ?>
    </td>
    <td>
    <div class="btn-group gap-2" role="group">
        <?php if ($billing['payment_status'] === 'Unpaid'): ?>
            <a href="<?= site_url('admin/markAsPaid/' . $billing['billing_id']) ?>"
               class="btn btn-success btn-sm"
               onclick="return confirm('Mark this bill as Paid?')">
                <i class="fas fa-check-circle"></i> Mark as Paid
            </a>
        <?php else: ?>
            <a href="<?= site_url('admin/markAsUnpaid/' . $billing['billing_id']) ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Mark this bill as Unpaid?')">
                <i class="fas fa-times-circle"></i> Mark as Unpaid
            </a>
        <?php endif; ?>

        <!-- PDF Download Button -->
        <a href="<?= site_url('admin/billing/pdf/' . $billing['billing_id']) ?>" 
           target="_blank" 
           class="btn btn-secondary btn-sm" 
           title="Download PDF Invoice">
            <i class="fas fa-file-pdf"></i> PDF
        </a>
    </div>
</td>

</tr>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Invoice Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= site_url('admin/dispenseMedicine') ?>" method="post" id="invoiceForm">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Patient -->
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Select Patient</label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <option value="" disabled selected>Choose patient</option>
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?= esc($patient['patient_id']) ?>"><?= esc($patient['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Medicines Section -->
                    <div id="medicines-container">
                        <div class="medicine-row row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Medicine</label>
                                <select name="medicines[0][medicine_id]" class="form-select medicine-select" required>
                                    <option value="" disabled selected>Select medicine</option>
                                    <?php foreach ($medicines as $med): ?>
                                        <option value="<?= esc($med['medicine_id']) ?>" data-price="<?= esc($med['price']) ?>">
                                            <?= esc($med['medicine_name']) ?> (₱<?= esc($med['price']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="medicines[0][quantity]" class="form-control quantity-input" min="1" value="1" required>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-medicine w-100 d-none">Remove</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-secondary" id="addMedicineRow">+ Add Medicine</button>
                    </div>

                    <!-- Total -->
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="text" class="form-control" id="totalAmount" name="total_amount" readonly>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label class="form-label">Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Invoice</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
let medicineIndex = 1;

document.getElementById('addMedicineRow').addEventListener('click', () => {
    const container = document.getElementById('medicines-container');
    const newRow = container.firstElementChild.cloneNode(true);

    newRow.querySelectorAll('input, select').forEach(el => {
        const name = el.getAttribute('name');
        if (name) {
            const newName = name.replace(/\[\d+\]/, `[${medicineIndex}]`);
            el.setAttribute('name', newName);
        }
        if (el.tagName === 'INPUT') el.value = 1;
        if (el.tagName === 'SELECT') el.selectedIndex = 0;
    });

    newRow.querySelector('.remove-medicine').classList.remove('d-none');

    container.appendChild(newRow);
    medicineIndex++;
    updateTotal();
});

document.addEventListener('input', e => {
    if (e.target.matches('.quantity-input') || e.target.matches('.medicine-select')) {
        updateTotal();
    }
});

document.addEventListener('click', e => {
    if (e.target.classList.contains('remove-medicine')) {
        e.target.closest('.medicine-row').remove();
        updateTotal();
    }
});

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.medicine-row').forEach(row => {
        const select = row.querySelector('.medicine-select');
        const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(select?.selectedOptions[0]?.dataset.price || 0);
        total += price * quantity;
    });
    document.getElementById('totalAmount').value = '₱' + total.toFixed(2);
}
</script>

<?= $this->endSection(); ?>

<?= $this->extend("layouts/admin/base"); ?>
<?= $this->section("content"); ?>

<div class="main-content" id="main-content">
    <div class="top-navbar">
        <h4 class="page-title">Medicines</h4>

        <?php
            $session = session();
            $firstName = esc($session->get('first_name') ?? 'Unknown');
            $lastName  = esc($session->get('last_name') ?? '');
            $role      = esc($session->get('role') ?? 'Admin');

            // Get initials (e.g., Sarah Johnson → SJ)
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
            ?>

            <div class="user-profile">
                <div class="user-info">
                    <p class="user-name"><?= $firstName . ' ' . $lastName ?></p>
                    <p class="user-role"><?= $role ?></p>
                </div>
                <div class="user-image"><?= $initials ?></div>
            </div>

    </div>
    <!-- Filters and Actions -->
  
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?> 

<div class="patient-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="sort-container">
                <label for="sortDisplay" class="me-2">Show:</label>
                <select id="sortDisplay" class="form-select">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>

            <div class="search-container d-flex align-items-center">
                <form action="<?= site_url('admin/searchMedicine') ?>" method="GET" class="d-flex w-100">
                    <input type="text" name="search" class="form-control flex-grow-1 me-2" placeholder="Search Medicines" value="<?= esc($searchTerm ?? '') ?>" required>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
                    <i class="fas fa-plus"></i> Add Medicine
                </button>
            </div>
        </div>

        <!-- Medicine Table -->
        <div class="table-responsive">
      
            <table class="table">
                <thead>
                    <tr>
                        <th>Medicine ID</th>
                        <th>Medicine Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Expiry Date</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listofmedicines as $medicines): ?>
                    <tr>

                    <td><?= $medicines['medicine_id'] ?></td>
                        <td><?= $medicines['medicine_name'] ?></td> 
                        <td><?= $medicines['category'] ?></td>
                        <td><?= $medicines['quantity'] ?></td>
                        <td><?= $medicines['expiry_date'] ?></td>
                        <td>₱ <?= $medicines['price'] ?></td>
                        <td>
                            <div class="btn-group gap-2" role="group">
                            <a href="#" class="btn btn-outline-warning btn-sm" onclick='opennUpdateModal(<?= json_encode($medicines) ?>)' title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="<?= site_url('/admin/medicines/deleteMedicine/' . $medicines['medicine_id']) ?>" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-sm" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Medicine list pagination" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pills me-2"></i>Add New Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="<?= site_url('admin/medicines/insertMedicine') ?>" method="POST" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="medicine_name" class="form-label">Medicine Name</label>
                            <input type="text" id="medicine_name" name="medicine_name" class="form-control" placeholder="Enter medicine name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select id="category" name="category" class="form-select">
                                <option value="" selected disabled>Select Category</option>
                                <option value="pain-reliever">Pain Reliever</option>
                                <option value="antibiotic">Antibiotic</option>
                                <option value="vitamin">Vitamin</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter quantity">
                        </div>
                        <div class="col-md-6">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" id="expiry_date" name="expiry_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="text" id="price" name="price" class="form-control" placeholder="Enter price">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Medicine</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Medicine Modal -->
<div class="modal fade" id="updateMedicineModal" tabindex="-1" aria-labelledby="updateMedicineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateMedicineModalLabel"><i class="fas fa-edit me-2"></i>Update Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('/admin/medicines/updateMedicine') ?>" method="POST" novalidate>
                    <input type="hidden" id="update_medicine_id" name="medicine_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_medicine_name" class="form-label">Medicine Name</label>
                            <input type="text" id="update_medicine_name" name="medicine_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="update_category" class="form-label">Category</label>
                            <select id="update_category" name="category" class="form-select">
                                <option value="pain-reliever">Pain Reliever</option>
                                <option value="antibiotic">Antibiotic</option>
                                <option value="vitamin">Vitamin</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_quantity" class="form-label">Quantity</label>
                            <input type="number" id="update_quantity" name="quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="update_expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" id="update_expiry_date" name="expiry_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update_price" class="form-label">Price ($)</label>
                            <input type="text" id="update_price" name="price" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Medicine</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
<?= $this->extend("layouts/admin/base"); ?>

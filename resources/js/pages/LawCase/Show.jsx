import React from 'react';
import { Link, Head } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function Show({ case: lawCase }) {
    const formatDate = (date) => {
        if (!date) return '-';
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    const getStatusBadgeClass = (status) => {
        const statusLower = status?.toLowerCase();
        if (statusLower === 'open') return 'success';
        if (statusLower === 'closed') return 'failed';
        if (statusLower === 'in progress' || statusLower === 'pending') return 'pending';
        return 'pending';
    };

    return (
        <AppLayout title={`Case #${lawCase.id} - Law Practice Management`}>
            <Head>
                <title>Case #{lawCase.id} - Law Practice Management</title>
            </Head>

            <div class="page-header">
                <div>
                    <h1 class="page-title">Case Details</h1>
                    <p class="page-subtitle">Case #{lawCase.id} - {lawCase.case_plaintiff} v. {lawCase.case_defendant}</p>
                </div>
                <div class="d-flex gap-2">
                    <Link href={`/law-cases/${lawCase.id}/edit`} class="btn-custom btn-custom-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </Link>
                    <Link href="/law-cases" class="btn-custom btn-custom-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </Link>
                </div>
            </div>

            <div class="row g-4">
                {/* Main Case Info */}
                <div class="col-12 col-lg-8">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Case Information</h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Plaintiff</label>
                                    <p class="mb-0 fw-medium">{lawCase.case_plaintiff}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Defendant</label>
                                    <p class="mb-0 fw-medium">{lawCase.case_defendant}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Category</label>
                                    <p class="mb-0 fw-medium">{lawCase.case_category}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Status</label>
                                    <span className={`badge-table ${getStatusBadgeClass(lawCase.case_status)}`}>
                                        {lawCase.case_status}
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Case Date</label>
                                    <p class="mb-0 fw-medium">{formatDate(lawCase.case_date)}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Attorney</label>
                                    <p class="mb-0 fw-medium">{lawCase.case_attorney || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Opponent</label>
                                    <p class="mb-0 fw-medium">{lawCase.case_opponent || '-'}</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom text-muted mb-1">Description</label>
                                    <p class="mb-0 fw-medium">{lawCase.case_description || 'No description provided'}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Related Clients */}
                    {lawCase.client && (
                        <div class="card border-light shadow-sm mt-4">
                            <div class="card-header">
                                <h2 class="card-title">Client Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom text-muted mb-1">Client Name</label>
                                        <p class="mb-0 fw-medium">{lawCase.client.client_name}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom text-muted mb-1">Contact</label>
                                        <p class="mb-0 fw-medium">{lawCase.client.client_email || '-'}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom text-muted mb-1">Phone</label>
                                        <p class="mb-0 fw-medium">{lawCase.client.client_phone || '-'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* Courts */}
                    {lawCase.courts && lawCase.courts.length > 0 && (
                        <div class="card border-light shadow-sm mt-4">
                            <div class="card-header">
                                <h2 class="card-title">Court Appearances</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Court Name</th>
                                                <th>Judge</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {lawCase.courts.map((court) => (
                                                <tr key={court.id}>
                                                    <td>{court.court_name}</td>
                                                    <td>{court.judge_name || '-'}</td>
                                                    <td>{formatDate(court.hearing_date)}</td>
                                                    <td><span className={`badge-table ${getStatusBadgeClass(court.status)}`}>{court.status}</span></td>
                                                    <td>{court.notes || '-'}</td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* Files */}
                    {lawCase.files && lawCase.files.length > 0 && (
                        <div class="card border-light shadow-sm mt-4">
                            <div class="card-header">
                                <h2 class="card-title">Case Files</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Type</th>
                                                <th>Size</th>
                                                <th>Uploaded</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {lawCase.files.map((file) => (
                                                <tr key={file.id}>
                                                    <td>{file.file_name}</td>
                                                    <td>{file.file_type}</td>
                                                    <td>{file.file_size ? (file.file_size / 1024).toFixed(1) + ' KB' : '-'}</td>
                                                    <td>{formatDate(file.created_at)}</td>
                                                    <td>
                                                        <a href={`/case/download/${file.file_name}`} class="table-btn-action" title="Download">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    )}
                </div>

                {/* Sidebar Info */}
                <div class="col-12 col-lg-4">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Quick Actions</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <Link href={`/law-cases/${lawCase.id}/edit`} class="btn-custom btn-custom-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit Case
                                </Link>
                                <Link href="/law-cases/create" class="btn-custom btn-custom-outline-secondary">
                                    <i class="bi bi-plus-lg"></i> Create New Case
                                </Link>
                                <button class="btn-custom btn-custom-outline-danger" onClick={() => {
                                    if (confirm('Are you sure you want to delete this case?')) {
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = `/law-cases/${lawCase.id}`;
                                        const methodInput = document.createElement('input');
                                        methodInput.type = 'hidden';
                                        methodInput.name = '_method';
                                        methodInput.value = 'DELETE';
                                        const tokenInput = document.createElement('input');
                                        tokenInput.type = 'hidden';
                                        tokenInput.name = '_token';
                                        tokenInput.value = document.querySelector('meta[name="csrf-token"]')?.content || '';
                                        form.appendChild(methodInput);
                                        form.appendChild(tokenInput);
                                        document.body.appendChild(form);
                                        form.submit();
                                    }
                                }}>
                                    <i class="bi bi-trash"></i> Delete Case
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card border-light shadow-sm mt-4">
                        <div class="card-header">
                            <h2 class="card-title">Case Timeline</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="timeline-icon bg-lime-accent">
                                            <i class="bi bi-file-earmark-plus"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Case Created</h6>
                                        <small class="text-muted">{formatDate(lawCase.created_at)}</small>
                                    </div>
                                </div>
                                {lawCase.updated_at !== lawCase.created_at && (
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="timeline-icon bg-primary">
                                                <i class="bi bi-pencil"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Last Updated</h6>
                                            <small class="text-muted">{formatDate(lawCase.updated_at)}</small>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

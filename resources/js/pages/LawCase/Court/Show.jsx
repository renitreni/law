import React from 'react';
import { Link, Head } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function CourtShow({ lawCase, court }) {
    const getStatusBadgeClass = (status) => {
        const statusLower = status?.toLowerCase();
        if (statusLower === 'scheduled') return 'pending';
        if (statusLower === 'completed') return 'success';
        if (statusLower === 'cancelled') return 'failed';
        if (statusLower === 'pending') return 'pending';
        return 'pending';
    };

    const formatDate = (date) => {
        if (!date) return '-';
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    return (
        <AppLayout title={`Court Appearance - Case #${lawCase.id} - Law Practice Management`}>
            <Head>
                <title>Court Appearance Details - Law Practice Management</title>
            </Head>

            <div class="page-header">
                <div>
                    <h1 class="page-title">Court Appearance Details</h1>
                    <p class="page-subtitle">{court.court_name}</p>
                </div>
                <div class="d-flex gap-2">
                    <Link href={`/law-cases/${lawCase.id}/courts/${court.id}/edit`} class="btn-custom btn-custom-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </Link>
                    <Link href={`/law-cases/${lawCase.id}/courts`} class="btn-custom btn-custom-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </Link>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Court Appearance Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Court Name</label>
                                    <p class="mb-0 fw-medium">{court.court_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Judge</label>
                                    <p class="mb-0 fw-medium">{court.judge_name || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Date</label>
                                    <p class="mb-0 fw-medium">{formatDate(court.court_date)}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Status</label>
                                    <span className={`badge-table ${getStatusBadgeClass(court.status)}`}>
                                        {court.status}
                                    </span>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom text-muted mb-1">Address</label>
                                    <p class="mb-0 fw-medium">{court.court_address || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Created</label>
                                    <p class="mb-0 fw-medium">{new Date(court.created_at).toLocaleDateString()}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Last Updated</label>
                                    <p class="mb-0 fw-medium">{new Date(court.updated_at).toLocaleDateString()}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Actions</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <Link href={`/law-cases/${lawCase.id}/courts/${court.id}/edit`} class="btn-custom btn-custom-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit Court Appearance
                                </Link>
                                <Link href={`/law-cases/${lawCase.id}/courts/create`} class="btn-custom btn-custom-outline-secondary">
                                    <i class="bi bi-plus-lg"></i> Add Another
                                </Link>
                                <button class="btn-custom btn-custom-outline-danger" onClick={() => {
                                    if (confirm('Are you sure you want to delete this court appearance?')) {
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = `/law-cases/${lawCase.id}/courts/${court.id}`;
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
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

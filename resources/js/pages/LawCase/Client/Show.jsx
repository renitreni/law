import React from 'react';
import { Link, Head } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function ClientShow({ lawCase, client }) {
    return (
        <AppLayout title={`Client - Case #${lawCase.id} - Law Practice Management`}>
            <Head>
                <title>Client Details - Law Practice Management</title>
            </Head>

            <div class="page-header">
                <div>
                    <h1 class="page-title">Client Details</h1>
                    <p class="page-subtitle">{client.client_name}</p>
                </div>
                <div class="d-flex gap-2">
                    <Link href={`/law-cases/${lawCase.id}/clients/${client.id}/edit`} class="btn-custom btn-custom-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </Link>
                    <Link href={`/law-cases/${lawCase.id}/clients`} class="btn-custom btn-custom-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </Link>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Client Information</h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Client Name</label>
                                    <p class="mb-0 fw-medium">{client.client_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Contact Person</label>
                                    <p class="mb-0 fw-medium">{client.client_contact || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Email</label>
                                    <p class="mb-0 fw-medium">{client.client_email || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Company</label>
                                    <p class="mb-0 fw-medium">{client.client_company || '-'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Created</label>
                                    <p class="mb-0 fw-medium">{new Date(client.created_at).toLocaleDateString()}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom text-muted mb-1">Last Updated</label>
                                    <p class="mb-0 fw-medium">{new Date(client.updated_at).toLocaleDateString()}</p>
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
                                <Link href={`/law-cases/${lawCase.id}/clients/${client.id}/edit`} class="btn-custom btn-custom-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit Client
                                </Link>
                                <Link href={`/law-cases/${lawCase.id}/clients/create`} class="btn-custom btn-custom-outline-secondary">
                                    <i class="bi bi-plus-lg"></i> Add Another Client
                                </Link>
                                <button class="btn-custom btn-custom-outline-danger" onClick={() => {
                                    if (confirm('Are you sure you want to delete this client?')) {
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = `/law-cases/${lawCase.id}/clients/${client.id}`;
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
                                    <i class="bi bi-trash"></i> Delete Client
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

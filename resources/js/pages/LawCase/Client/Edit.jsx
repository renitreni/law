import React from 'react';
import { useForm, Head, Link } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function ClientEdit({ lawCase, client }) {
    const { data, setData, put, processing, errors } = useForm({
        client_name: client.client_name,
        client_contact: client.client_contact,
        client_email: client.client_email,
        client_company: client.client_company,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('law-cases.clients.update', [lawCase, client]));
    };

    return (
        <AppLayout title={`Edit Client - Case #${lawCase.id} - Law Practice Management`}>
            <Head>
                <title>Edit Client - Law Practice Management</title>
            </Head>

            <div class="page-header">
                <div>
                    <h1 class="page-title">Edit Client</h1>
                    <p class="page-subtitle">Case: {lawCase.case_plaintiff} v. {lawCase.case_defendant}</p>
                </div>
            </div>

            <Link href={`/law-cases/${lawCase.id}/clients`} class="btn-custom btn-custom-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Clients
            </Link>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Client Information</h2>
                        </div>
                        <div class="card-body">
                            <form onSubmit={handleSubmit}>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Client Name <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            className={`form-control-custom ${errors.client_name ? 'is-invalid-custom' : ''}`}
                                            value={data.client_name}
                                            onChange={(e) => setData('client_name', e.target.value)}
                                            placeholder="Enter client name"
                                            required
                                        />
                                        {errors.client_name && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.client_name}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Contact Person</label>
                                        <input
                                            type="text"
                                            class="form-control-custom"
                                            value={data.client_contact}
                                            onChange={(e) => setData('client_contact', e.target.value)}
                                            placeholder="Contact person name"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Email</label>
                                        <input
                                            type="email"
                                            className={`form-control-custom ${errors.client_email ? 'is-invalid-custom' : ''}`}
                                            value={data.client_email}
                                            onChange={(e) => setData('client_email', e.target.value)}
                                            placeholder="client@example.com"
                                        />
                                        {errors.client_email && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.client_email}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Company</label>
                                        <input
                                            type="text"
                                            class="form-control-custom"
                                            value={data.client_company}
                                            onChange={(e) => setData('client_company', e.target.value)}
                                            placeholder="Company name"
                                        />
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn-custom btn-custom-primary" disabled={processing}>
                                        {processing ? (
                                            <><span className="spinner-border spinner-border-sm me-2"></span>Updating...</>
                                        ) : (
                                            <><i className="bi bi-check-lg"></i> Update Client</>
                                        )}
                                    </button>
                                    <Link href={`/law-cases/${lawCase.id}/clients`} class="btn-custom btn-custom-secondary">
                                        <i class="bi bi-x-lg"></i> Cancel
                                    </Link>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

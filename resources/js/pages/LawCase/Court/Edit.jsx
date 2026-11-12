import React from 'react';
import { useForm, Head, Link } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function CourtEdit({ lawCase, court }) {
    const { data, setData, put, processing, errors } = useForm({
        court_name: court.court_name,
        judge_name: court.judge_name,
        court_date: court.court_date ? court.court_date.split('T')[0] : '',
        court_address: court.court_address,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(`/law-cases/${lawCase.id}/courts/${court.id}`);
    };

    return (
        <AppLayout title={`Edit Court Appearance - Case #${lawCase.id} - Law Practice Management`}>
            <Head>
                <title>Edit Court Appearance - Law Practice Management</title>
            </Head>

            <div class="page-header">
                <div>
                    <h1 class="page-title">Edit Court Appearance</h1>
                    <p class="page-subtitle">Case: {lawCase.case_plaintiff} v. {lawCase.case_defendant}</p>
                </div>
            </div>

            <Link href={`/law-cases/${lawCase.id}/courts`} class="btn-custom btn-custom-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Court Appearances
            </Link>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Court Appearance Details</h2>
                        </div>
                        <div class="card-body">
                            <form onSubmit={handleSubmit}>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Court Name <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            className={`form-control-custom ${errors.court_name ? 'is-invalid-custom' : ''}`}
                                            value={data.court_name}
                                            onChange={(e) => setData('court_name', e.target.value)}
                                            placeholder="Enter court name"
                                            required
                                        />
                                        {errors.court_name && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.court_name}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Judge Name</label>
                                        <input
                                            type="text"
                                            class="form-control-custom"
                                            value={data.judge_name}
                                            onChange={(e) => setData('judge_name', e.target.value)}
                                            placeholder="Judge name"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Court Date <span class="text-danger">*</span></label>
                                        <input
                                            type="date"
                                            className={`form-control-custom ${errors.court_date ? 'is-invalid-custom' : ''}`}
                                            value={data.court_date}
                                            onChange={(e) => setData('court_date', e.target.value)}
                                            required
                                        />
                                        {errors.court_date && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.court_date}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label-custom">Court Address</label>
                                        <textarea
                                            class="form-control-custom"
                                            rows="3"
                                            value={data.court_address}
                                            onChange={(e) => setData('court_address', e.target.value)}
                                            placeholder="Court address"
                                        />
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn-custom btn-custom-primary" disabled={processing}>
                                        {processing ? (
                                            <><span className="spinner-border spinner-border-sm me-2"></span>Updating...</>
                                        ) : (
                                            <><i className="bi bi-check-lg"></i> Update Court Appearance</>
                                        )}
                                    </button>
                                    <Link href={`/law-cases/${lawCase.id}/courts`} class="btn-custom btn-custom-secondary">
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

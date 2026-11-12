import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function Edit({ case: lawCase }) {
    const { data, setData, put, processing, errors } = useForm({
        case_plaintiff: lawCase.case_plaintiff,
        case_defendant: lawCase.case_defendant,
        case_category: lawCase.case_category,
        case_status: lawCase.case_status,
        case_description: lawCase.case_description,
        case_attorney: lawCase.case_attorney,
        case_date: lawCase.case_date ? lawCase.case_date.split('T')[0] : '',
        case_opponent: lawCase.case_opponent,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(`/law-cases/${lawCase.id}`);
    };

    return (
        <AppLayout title="Edit Case - Law Practice Management">
            <Head>
                <title>Edit Case - Law Practice Management</title>
            </Head>

            <div class="page-header">
                <div>
                    <h1 class="page-title">Edit Case</h1>
                    <p class="page-subtitle">Update the case details</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">Case Information</h2>
                        </div>
                        <div class="card-body">
                            <form onSubmit={handleSubmit}>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Plaintiff <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            className={`form-control-custom ${errors.case_plaintiff ? 'is-invalid-custom' : ''}`}
                                            value={data.case_plaintiff}
                                            onChange={(e) => setData('case_plaintiff', e.target.value)}
                                            placeholder="Enter plaintiff name"
                                            required
                                        />
                                        {errors.case_plaintiff && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.case_plaintiff}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Defendant <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            className={`form-control-custom ${errors.case_defendant ? 'is-invalid-custom' : ''}`}
                                            value={data.case_defendant}
                                            onChange={(e) => setData('case_defendant', e.target.value)}
                                            placeholder="Enter defendant name"
                                            required
                                        />
                                        {errors.case_defendant && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.case_defendant}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Category <span class="text-danger">*</span></label>
                                        <select
                                            className={`form-select-custom ${errors.case_category ? 'is-invalid-custom' : ''}`}
                                            value={data.case_category}
                                            onChange={(e) => setData('case_category', e.target.value)}
                                            required
                                        >
                                            <option value="">Select category...</option>
                                            <option value="Civil">Civil</option>
                                            <option value="Criminal">Criminal</option>
                                            <option value="Family">Family Law</option>
                                            <option value="Corporate">Corporate</option>
                                            <option value="Real Estate">Real Estate</option>
                                            <option value="Intellectual Property">Intellectual Property</option>
                                            <option value="Employment">Employment</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        {errors.case_category && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.case_category}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Status <span class="text-danger">*</span></label>
                                        <select
                                            className={`form-select-custom ${errors.case_status ? 'is-invalid-custom' : ''}`}
                                            value={data.case_status}
                                            onChange={(e) => setData('case_status', e.target.value)}
                                            required
                                        >
                                            <option value="Open">Open</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Closed">Closed</option>
                                            <option value="Dismissed">Dismissed</option>
                                        </select>
                                        {errors.case_status && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.case_status}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Case Date <span class="text-danger">*</span></label>
                                        <input
                                            type="date"
                                            className={`form-control-custom ${errors.case_date ? 'is-invalid-custom' : ''}`}
                                            value={data.case_date}
                                            onChange={(e) => setData('case_date', e.target.value)}
                                            required
                                        />
                                        {errors.case_date && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.case_date}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Attorney</label>
                                        <input
                                            type="text"
                                            class="form-control-custom"
                                            value={data.case_attorney}
                                            onChange={(e) => setData('case_attorney', e.target.value)}
                                            placeholder="Attorney name"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">Opponent</label>
                                        <input
                                            type="text"
                                            class="form-control-custom"
                                            value={data.case_opponent}
                                            onChange={(e) => setData('case_opponent', e.target.value)}
                                            placeholder="Opponent name"
                                        />
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label-custom">Description</label>
                                        <textarea
                                            class="form-control-custom"
                                            rows="4"
                                            value={data.case_description}
                                            onChange={(e) => setData('case_description', e.target.value)}
                                            placeholder="Case description..."
                                        />
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn-custom btn-custom-primary" disabled={processing}>
                                        {processing ? (
                                            <><span className="spinner-border spinner-border-sm me-2"></span>Updating...</>
                                        ) : (
                                            <><i className="bi bi-check-lg"></i> Update Case</>
                                        )}
                                    </button>
                                    <a href="/law-cases" class="btn-custom btn-custom-secondary">
                                        <i class="bi bi-x-lg"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

import React from 'react';
import { usePage, Link } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function TimesheetIndex({ clients, matters, offices }) {
    const { flash = {} } = usePage().props;

    return (
        <AppLayout title="Timesheet - Law Practice Management">
            <div className="page-header">
                <div>
                    <h1 className="page-title">Timesheet</h1>
                    <p className="page-subtitle">Manage your time entries</p>
                </div>
            </div>

            {flash?.success && (
                <div className="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {flash.success}
                    <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            )}

            <div className="row g-4">
                <div className="col-12 col-md-6 col-lg-3">
                    <div className="card border-light shadow-sm h-100">
                        <div className="card-body">
                            <h6 className="card-title text-muted mb-2">Clients</h6>
                            <p className="display-6 mb-0">{clients.length}</p>
                            <Link href="/options" className="text-decoration-none small">
                                Manage Clients <i className="bi bi-arrow-right ms-1"></i>
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="col-12 col-md-6 col-lg-3">
                    <div className="card border-light shadow-sm h-100">
                        <div className="card-body">
                            <h6 className="card-title text-muted mb-2">Matters</h6>
                            <p className="display-6 mb-0">{matters.length}</p>
                            <Link href="/matters" className="text-decoration-none small">
                                Manage Matters <i className="bi bi-arrow-right ms-1"></i>
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="col-12 col-md-6 col-lg-3">
                    <div className="card border-light shadow-sm h-100">
                        <div className="card-body">
                            <h6 className="card-title text-muted mb-2">Offices</h6>
                            <p className="display-6 mb-0">{offices.length}</p>
                            <Link href="#" className="text-decoration-none small">
                                Manage Offices <i className="bi bi-arrow-right ms-1"></i>
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="col-12 col-md-6 col-lg-3">
                    <div className="card border-light shadow-sm h-100">
                        <div className="card-body">
                            <h6 className="card-title text-muted mb-2">Quick Actions</h6>
                            <div className="d-grid gap-2">
                                <Link href="/law-cases/create" className="btn-custom btn-custom-outline-primary">
                                    <i className="bi bi-plus-lg"></i> New Case
                                </Link>
                                <Link href="/invoice" className="btn-custom btn-custom-outline-secondary">
                                    <i className="bi bi-file-earmark-text"></i> New Invoice
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="card border-light shadow-sm mt-4">
                <div className="card-header">
                    <h2 className="card-title">Time Entry Calendar</h2>
                </div>
                <div className="card-body">
                    <div className="alert alert-info">
                        <i className="bi bi-info-circle me-2"></i>
                        Calendar integration coming soon. Use the quick actions above to manage cases and invoices.
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
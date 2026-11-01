import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function CourtIndex({ lawCase, courts }) {
    const { flash } = usePage().props;

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
        return new Date(date).toLocaleDateString();
    };

    return (
        <AppLayout title={`Court Appearances - Case #${lawCase.id} - Law Practice Management`}>
            <div class="page-header">
                <div>
                    <h1 class="page-title">Court Appearances</h1>
                    <p class="page-subtitle">Case: {lawCase.case_plaintiff} v. {lawCase.case_defendant}</p>
                </div>
                <Link href={`/law-cases/${lawCase.id}/courts/create`} class="btn-custom btn-custom-primary">
                    <i class="bi bi-plus-lg"></i> Add Court Appearance
                </Link>
            </div>

            {flash.success && (
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {flash.success}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            )}

            <Link href={`/law-cases/${lawCase.id}`} class="btn-custom btn-custom-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Case
            </Link>

            <div class="table-card-custom">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Court Name</th>
                                <th>Judge</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {courts.data.map((court) => (
                                <tr key={court.id}>
                                    <td>
                                        <div class="table-user-name">{court.court_name}</div>
                                    </td>
                                    <td>{court.judge_name || '-'}</td>
                                    <td>{formatDate(court.court_date)}</td>
                                    <td>
                                        <span className={`badge-table ${getStatusBadgeClass(court.status)}`}>
                                            {court.status}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <Link href={`/law-cases/${lawCase.id}/courts/${court.id}`} class="table-btn-action" title="View">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <Link href={`/law-cases/${lawCase.id}/courts/${court.id}/edit`} class="table-btn-action" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </Link>
                                            <form onSubmit={(e) => {
                                                e.preventDefault();
                                                if (confirm('Are you sure you want to delete this court appearance?')) {
                                                    e.currentTarget.submit();
                                                }
                                            }} action={`/law-cases/${lawCase.id}/courts/${court.id}`} method="POST">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} />
                                                <button type="submit" class="table-btn-action delete" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                <div class="table-footer-control">
                    <span class="table-pagination-info">
                        Showing {courts.from} to {courts.to} of {courts.total} entries
                    </span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0 gap-1">
                            {courts.prev_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={courts.prev_page_url}><i class="bi bi-chevron-left"></i></a>
                                </li>
                            )}
                            {Array.from({ length: courts.last_page }, (_, i) => i + 1).map((page) => (
                                <li key={page} className={`page-item ${courts.current_page === page ? 'active' : ''}`}>
                                    <a class="page-link border-0" href={`/law-cases/${lawCase.id}/courts?page=${page}`}>{page}</a>
                                </li>
                            ))}
                            {courts.next_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={courts.next_page_url}><i class="bi bi-chevron-right"></i></a>
                                </li>
                            )}
                        </ul>
                    </nav>
                </div>
            </div>
        </AppLayout>
    );
}
